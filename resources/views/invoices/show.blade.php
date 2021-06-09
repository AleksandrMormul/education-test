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
                <td>
                    @if($invoice->paypal_status === 'APPROVED')
                        <button class="btnApprove">Confirm</button>
                    @else
                        You need to pay for this order!
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
