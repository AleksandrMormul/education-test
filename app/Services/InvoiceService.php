<?php

namespace App\Services;

use App\Http\Requests\Api\CreateInvoiceRequest;
use App\Models\Ad;
use App\Models\FailedInvoice;
use App\Models\Invoice;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Log;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Throwable;

/**
 * Class InvoiceService
 * @package App\Services
 */
class InvoiceService
{
    public const EVENT_APPROVED = 'CHECKOUT.ORDER.APPROVED';
    public const EVENT_COMPLETED = 'CHECKOUT.ORDER.COMPLETED';
    public const EVENT_PAYMENT_CREATED = 'PAYMENT.ORDER.CREATED';
    public const INVOICE_CREATED = 'CREATED';
    public const INVOICE_APPROVED = 'APPROVED';
    public const INVOICE_CANCEL = 'CANCEL';
    public const INVOICE_COMPLETED = 'COMPLETED';
    public const INVOICE_NOT_FOUND = 'RESOURCE_NOT_FOUND';

    /**
     * @param CreateInvoiceRequest $request
     * @return array|Application|RedirectResponse|Redirector
     * @throws Throwable
     */
    public static function createInvoice(CreateInvoiceRequest $request)
    {
        $provider = self::initialPayPalProvider();

        $order = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('ads.index'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => 'USD',
                        "value" => $request->value,
                    ]
                ]
            ]
        ]);

        if (!$order['links']) {
            return redirect(route('ads.show', $request->ad_id))
                ->with(['code' => 'danger', 'message' => 'Something went wrong with PayPal']);
        }

        Ad::find($request->ad_id)->update(['status_paid' => AdService::RESERVATION]);

        Invoice::create([
            'user_id' => $request->user()->id,
            'ad_id' => $request->ad_id,
            'order_id' => $order['id'],
            'paypal_status' => $order['status'],
        ]);

        $urlApprove = self::getApproveURL($order['links']);

        self::createWebHook($provider, 'https://1a46f2ce926a.ngrok.io/api/webhook');

        return ['url' => $urlApprove];
    }

    /**
     * @return PayPalClient
     * @throws Throwable
     */
    private static function initialPayPalProvider(): PayPalClient
    {
        $provider = new PayPalClient();
        $config = self::getConfig();

        $provider->setApiCredentials($config);
        $provider->getAccessToken();

        return $provider;
    }

    /**
     * @return Repository|Application|mixed
     */
    private static function getConfig()
    {
        $payPalMode = config('paypal.mode');

        return config('paypal.keys.' . $payPalMode);
    }

    /**
     * @param array $links
     * @return mixed
     */
    public static function getApproveURL(array $links)
    {
        foreach ($links as $link) {
            if ($link['rel'] === 'approve') {
                return $link['href'];
            }
        }
    }

    /**
     * @throws Throwable
     */
    private static function createWebHook(PayPalClient $provider, string $url)
    {
        $listWebhook = $provider->listWebHooks();
        if ($listWebhook['webhooks'] && $listWebhook['webhooks'][0]['url'] === $url) {
            Log::info('webhook exist');
            return;
        } else {
            Log::info('creating webhook');
            $provider->createWebHook(
                $url,
                [self::EVENT_APPROVED, self::EVENT_COMPLETED, self::EVENT_PAYMENT_CREATED]
            );
        }
    }

    /**
     * @param array $links
     * @return array
     */
    public static function getConfirmURL(array $links): array
    {
        foreach ($links as $link) {
            if ($link['rel'] === 'capture') {
                return ['url' => $link['href']];
            }
        }
    }

    /**
     * @param Request $request
     */
    public static function updateInvoice(Request $request)
    {
        Log::info('start updating status invoice....................................' . $request['resource']['id']);

        $invoice = Invoice::whereOrderId($request['resource']['id']);
        $invoice->update(['paypal_status' => $request['resource']['status']]);

        Log::info('updated ad ' . $invoice->first()->ad_id);

        Ad::find($invoice->first()->ad_id)->update(['status_paid' => AdService::PAID]);
    }

    /**
     * @throws Throwable
     */
    public static function validationInvoices()
    {
        $provider = self::initialPayPalProvider();
        Invoice::whereIn('paypal_status', [self::INVOICE_APPROVED, self::INVOICE_CREATED])
            ->chunkById(15, function ($invoices) use ($provider) {
                foreach ($invoices as $invoice) {
                    $invoiceDetail = $provider->showOrderDetails($invoice->order_id);
                    if ($invoiceDetail['type'] === 'error') {
                        Ad::findOrFail($invoice->ad_id)->update(['status_paid' => AdService::FAILED]);
                        FailedInvoice::create([
                            'invoice_id' => $invoice->id,
                            'ad_id' => $invoice->ad_id,
                            'user_id' => $invoice->user_id,
                        ]);
                        $invoice->update([
                            'paypal_status' => null,
                            'ad_id' => null,
                        ]);
                    }
                }
            });
    }
}
