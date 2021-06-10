<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\ShowInvoiceRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{

    /**
     * @param ShowInvoiceRequest $request
     * @return Application|Factory|View
     */
    public function showUserInvoices(ShowInvoiceRequest $request)
    {
        $invoices = $request->user()->invoice;
        return view(
            'invoices.show',
            [
                'invoices' => $invoices,
            ]
        );
    }
}
