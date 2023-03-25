<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateInvoiceRequest;
use App\Services\InvoiceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Log;
use Throwable;

/**
 * Class InvoiceController
 * @package App\Http\Controllers\Api
 */
class InvoiceController extends Controller
{

    /**
     * @param CreateInvoiceRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function createInvoice(CreateInvoiceRequest $request): JsonResponse
    {
        return response()->json(InvoiceService::createInvoice($request));
    }

    /**
     * @param Request $request
     */
    public function handle(Request $request)
    {
        Log::info('handle run...........');
        InvoiceService::updateInvoice($request);
    }
}
