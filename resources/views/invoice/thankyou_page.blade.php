@extends('layouts.admin')

@section('content')
    <style>
        .thank-you-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .thank-you-card {
            max-width: 700px;
            width: 100%;
            border: none;
            border-radius: 20px;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }
        .thank-you-icon {
            font-size: 3.5rem;
            color: #28a745;
            margin-bottom: 1rem;
        }
        .card-title {
            color: #2c3e50;
            font-weight: bold;
        }
        .card-text {
            color: #6c757d;
            font-size: 1.1rem;
        }
        .list-group-item {
            border: none;
            padding: 0.75rem 1.25rem;
            background-color: transparent;
        }
        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2c3e50;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
        }
        /*.btn-primary, .btn-outline-primary {
            border-radius: 25px;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-outline-primary {
            border-color: #007bff;
            color: #007bff;
        }
        .btn-outline-primary:hover {
            background-color: #007bff;
            color: #fff;
        }*/
        .btn-group .btn {
            margin: 0 0.5rem;
        }
        .address p {
            margin: 0;
        }
        @media (max-width: 576px) {
            .btn-group .btn {
                display: block;
                width: 100%;
                margin: 0.5rem 0;
            }
        }
    </style>
@php


    $payment_status           = !empty($invoice->payment_status) ? json_decode($invoice->payment_status, true) : null;
    $invoice_data = !empty($invoice->data) ? json_decode($invoice->data, true) : null;
    $slno           = $invoice_data['enter_asset_number']??null;

        $currencySymbol = "$";
        if (!empty($invoice->org?->billing_country)) {
            $countryCurrency = getCountryCurrency($invoice->org->billing_country);
            if (!empty($countryCurrency) && isset($countryCurrency[0]['symbol_native'])) {
                $currencySymbol = $countryCurrency[0]['symbol_native'];
            }
        }
        $price_type = $invoice->org?->price_type;
        $priceMap = [
            'price1' => 'USD',
            'price2' => 'AUD',
            'price3' => 'EUR',
            'price4' => 'CAD',
            'price5' => 'USD',
            'price6' => 'EUR',
            'price7' => 'EUR',
        ];

        // Default to USD if not set or invalid
        $price_type_display = $priceMap[$price_type] ?? 'USD';
        $order_pricing = $invoice_data['price_type'] ?? null;
    $tax_hts=null;
    $tax_hts_title=null;
    if($invoice->org?->billing_country=="CA"){
        $tax_hts_title="HST Number";
        $tax_hts="73115 9877 RT0001";
        if($invoice->org?->billing_state=="QC"){
        $tax_hts_title="QST Number";
        $tax_hts="1227469443 TQ0001";
        }
    }

@endphp
<div class="container-xl ">

<div class="page-body">
    <div class="thank-you-container">
        <div class="card thank-you-card p-4">
            <div class="card-body text-center">
                <div class="thank-you-icon">✅</div>
                <h1 class="card-title mb-3">Thank you for your Payment</h1>
                <p class="card-text mb-4">
                    We've received your payment, and you'll get a confirmation email soon.
                </p>

                <div class="text-start">
                    <h5 class="section-title">Order Information</h5>
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Order Number:</span>
                            <strong>{{$invoice->id}}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Payment Received on:</span>
                            <strong>{{ \Carbon\Carbon::createFromTimestamp($payment_status['payment_date'])->format('M d, Y') }}</strong>
                        </li>
                    </ul>

                    <h5 class="section-title">Customer Information</h5>
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Customer:</span>
                            <strong>

                                @if(!empty($invoice->end_customer))
                                    {!! $invoice->end_customer !!}
                                @else
                                    @if(!empty($invoice->org?->name))
                                        {{ $invoice->org?->name }}<br>
                                    @endif
                                @endif
                            </strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Address:</span>
                            <strong class="text-end address">
                                @if(!empty($invoice->address))
                                    {!! $invoice->address !!}
                                @else
                                    @if(!empty($invoice->org?->name))
                                        {{ $invoice->org?->name }}<br>
                                    @endif

                                    @if(!empty($invoice->org?->billing_address_1))
                                        {{ $invoice->org?->billing_address_1 }}<br>
                                    @endif

                                    @php
                                        $city = $invoice->org?->billing_city;
                                        $state = $invoice->org?->billing_state ? getStateByCode($invoice->org?->billing_state) : null;
                                        $zip = $invoice->org?->billing_zip;
                                        $country = $invoice->org?->billing_country ? getCountryByCode($invoice->org?->billing_country) : null;
                                    @endphp

                                    @if($city || $state)
                                        {{ $city }}{{ $city && $state ? ', ' : '' }}{{ $state }}<br>
                                    @endif

                                    @if($zip || $country)
                                        {{ $zip }}{{ $zip && $country ? ', ' : '' }}{{ $country }}
                                    @endif
                                @endif
                            </strong>
                        </li>
                    </ul>

                    <h5 class="section-title">Payment Information</h5>
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Payment Method:</span>
                            <strong>{{$payment_status['type']}}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Sub Total ({{$price_type_display}}):</span>
                            <strong>{{ $currencySymbol }} {{ number_format($invoice->total, 2) }}</strong>
                        </li>
                        {{--<li class="list-group-item d-flex justify-content-between">
                            <span>Tax (13%):</span>
                            <strong>$10.65</strong>
                        </li>--}}
                        @if($tax_hts)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{$tax_hts_title}}:</span>
                            <strong>{{$tax_hts}}</strong>
                        </li>
                        @endif
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total:</span>
                            <strong>{{ $currencySymbol }} {{ number_format($invoice->total, 2) }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Charged Amount:</span>
                            <strong>{{ $currencySymbol }} {{ number_format($invoice->total, 2) }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Balance:</span>
                            <strong>{{ $currencySymbol }} {{ number_format($invoice->balance, 2) }}</strong>
                        </li>
                    </ul>
                </div>

                <div class="btn-group mb-3">
                    <a href="#" class="btn btn-outline-primary">View Invoice</a>
                    <a href="#" class="btn btn-outline-primary">Download Invoice</a>
                    <a href="#" class="btn btn-outline-primary">Track Order</a>
                </div>
                {{--<div>
                    <a href="/" class="btn btn-primary btn-lg"></i>Continue Shopping</a>
                </div>--}}
            </div>
        </div>
    </div>
</div>
</div>
@endsection

