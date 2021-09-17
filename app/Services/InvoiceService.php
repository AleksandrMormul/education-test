<?php

namespace App\Services;

use App\Http\Requests\Api\CreateInvoiceRequest;
use App\Models\Ad;
use App\Models\Invoice;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Log;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Throwable;
use Illuminate\Http\Request;

/**
 * Class InvoiceService
 * @package App\Services
 */
class InvoiceService
{
    public const EVENT_APPROVED = 'CHECKOUT.ORDER.APPROVED';
    public const EVENT_COMPLETED = 'CHECKOUT.ORDER.COMPLETED';
    public const INVOICE_CREATED = 'CREATED';
    public const INVOICE_APPROVED = 'APPROVED';

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

        self::createWebHook($provider, 'https://410c3c8e98ff.ngrok.io/api/webhook');

        return ['url' => $urlApprove];
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
                [self::EVENT_APPROVED, self::EVENT_COMPLETED]
            );
        }
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
    private static function getApproveURL(array $links)
    {
        foreach ($links as $link) {
            if ($link['rel'] === 'approve') {
                return $link['href'];
            }
        }
    }

    /**
     * @param Request $request
     */
    public static function updateStatusInvoice(Request $request)
    {
        Log::info('start updating status invoice....................................' . $request['resource']['id']);

        $invoice = Invoice::whereOrderId($request['resource']['id']);
        $invoice->update(['paypal_status' => $request['resource']['status']]);

        Log::info('updated ad '. $invoice->first()->ad_id);

        Ad::find($invoice->first()->ad_id)->update(['status_paid' => AdService::PAID]);
    }
}
