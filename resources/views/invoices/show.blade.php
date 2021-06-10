@extends('layouts.app')

@section('content')
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Order ID</th>
                <th scope="col">STATUS</th>
                <th scope="col">Handle</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($invoices as $count => $invoice)
            <tr>
                <th scope="row">{{$count}}</th>
                <td>{{$invoice->order_id}}</td>
                <td>{{$invoice->paypal_status}}</td>
                <td id="handle-{{$invoice->id}}">
                    @if($invoice->paypal_status === 'APPROVED')
                        <button class="btnApprove" id="payPalConfirm" data-invoice-id="{{$invoice->id}}"
                                data-invoice-order-id="{{$invoice->order_id}}">Confirm
                        </button>
                    @elseif($invoice->paypal_status === 'COMPLETED')
                        <p>COMPLETED</p>
                    @elseif($invoice->paypal_status === '' || is_null($invoice->paypal_status))
                        <p>Time for pay order is up. Please try again process <a class="buying" href="{{route('ads.show', $invoice->ad_id)}}" >buying</a> </p>
                    @else
                        You need to <a class="orderPay" data-invoice-order-id="{{$invoice->order_id}}">pay</a> for this order! Or update page after 5min
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
