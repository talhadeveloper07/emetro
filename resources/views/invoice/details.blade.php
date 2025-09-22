<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{$invoice->id}}</title>
    <link href="{{asset('')}}dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="{{asset('')}}dist/css/tabler-vendors.min.css" rel="stylesheet"/>
    <link href="{{asset('')}}dist/css/demo.min.css" rel="stylesheet"/>
    <link rel="shortcut icon" type="image/png" href="{{asset('')}}static/logo-small.png"/>
    <link href='https://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome-font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('dist/css/app.css')}}?v={{time()}}">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }

        /* Apply to all elements */
        * {
            font-family: 'Montserrat', sans-serif !important;
        }
        @media print {
            .d-print-none {
                display: none !important;
            }
            body {
                font-size: 12px;
                margin: 0;
                padding: 0;
                background: white;
            }
            .page-body {
                margin: 0;
                padding: 0;
            }
            .container-xl {
                max-width: 100%;
                margin: 0;
                padding: 0;
            }
            .card {
                box-shadow: none;
                border: 1px solid #dee2e6;
                margin-bottom: 20px;
            }
            .card-body {
                padding: 15px;
            }
            .table {
                font-size: 11px;
            }
            .table th,
            .table td {
                padding: 8px;
                border: 1px solid #dee2e6;
            }
            .pay_status {
                width: 100px;
                height: 100px;
            }
            .page-header {
                margin-bottom: 20px;
            }
            hr {
                margin: 10px 0;
            }
            @page {
                size: A4;
                margin: 0.5cm; /* Reduced margin for single-page fit */
            }
            .card {
                page-break-inside:avoid !important;
            }
            .table-responsive {
                overflow: visible !important;
            }
            /* Ensure single page layout */
            .invoice-header, .card, .row {
                min-height: 0;
                max-height: none;
            }
            /* Adjust column widths for single page */
            .col-md-8, .col-md-4 {
                flex: 0 0 auto;
                width: 100% !important;
                max-width: 100% !important;
            }
        }
        .pay_status {
            position: absolute;
            top: 0;
            left: -5px;
            width: 100px;
            height: 100px;
            z-index: 10;
            object-fit: contain;
        }

        .invoice-header {
            position: relative;
            overflow: hidden;
            padding-left: 55px;
        }
        .company-logo {
            max-height: 80px;
            width: auto;
        }
        .invoice-summary-table {
            background-color: #f8f9fa;
        }
        .invoice-summary-table td {
            padding: 8px 12px;
            border: 1px solid #dee2e6;
        }
        .invoice-summary-table .amount {
            font-weight: bold;
        }
        .bill-to-section {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
        }
        .invoice-header {
            position: relative;
        }
        .total-section {
            background-color: #82b800 ;
            color: white;
        }
        .total-section td {
            background-color: #82b800  !important;
            color: white !important;
            font-weight: bold;
        }
        .address p {
            margin: 0;
        }
    </style>
</head>
<body>
<div class="container-xl ">
    <!-- Page title -->
    <div class="page-header d-print-none mt-3">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Invoice: {{$invoice->id}}
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <button class="btn btn-outline-secondary" onclick="window.print()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"/>
                            <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"/>
                            <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z"/>
                        </svg>
                        Print
                    </button>
                    <button class="btn btn-outline-primary" onclick="generatePDF()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M14 3v4a1 1 0 0 0 1 1h4"/>
                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"/>
                        </svg>
                        PDF
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<hr class="d-print-none">
@php


    $companyInfo = priceTypeAddress($invoice->org?->price_type);
    $payment_status           = !empty($invoice->payment_status) ? json_decode($invoice->payment_status, true) : null;
    $invoice_data = !empty($invoice->data) ? json_decode($invoice->data, true) : null;
    $category_discount=null;
    if($invoice_data){
        $category_discount=$invoice_data['category_discount'];
    }
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
    if($invoice->org?->billing_country=="CA"){
        $tax_hts="HST Number : 73115 9877 RT0001";
        if($invoice->org?->billing_state=="QC"){
        $tax_hts="QST Number : 1227469443 TQ0001";
        }
    }

@endphp
<div class="page-body" id="invoiceContent">
    <div class="container-xl ">
        <!-- Invoice Header Section -->
        <div class="card mb-4 invoice-header">

            <div class="card-body">
                <div class="row">
                    <!-- Left Side: Company Info -->
                    <div class="col-md-6 col-sm-6">
                        <div class="mb-3">
                            <h3 class="mb-2">{{$companyInfo['name']}}</h3>
                            <address class="mb-0">{!! $companyInfo['address'] !!}</address>
                        </div>
                    </div>

                    <!-- Right Side: Logo and HST -->
                    <div class="col-md-6 col-sm-6 text-end">
                        <div class="mb-3">
                            <img src="{{asset('')}}/logo.png"  alt="{{env('APP_NAME')}}" class="company-logo mb-2">

                            @if($tax_hts)
                            <div class="small <!--text-muted-->">
                                    {{$tax_hts}}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Invoice Details Row -->
                <div class="row">
                    <!-- Bill To Section -->
                    <div class="col-md-6 col-sm-6">
                        <div class="bill-to-section">
                            <h5 class="mb-2"><strong>Bill To:</strong></h5>
                            <address class="mb-0 address">
                                <strong>
                                    @if(!empty($invoice->end_customer))
                                        {!! $invoice->end_customer !!}
                                    @else
                                        @if(!empty($invoice->org?->name))
                                            {{ $invoice->org?->name }}<br>
                                        @endif
                                    @endif
                                </strong><br>
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


                            </address>
                        </div>
                    </div>

                    <!-- Invoice Info and Summary -->
                    <div class="col-md-6 col-sm-6">
                       {{-- <div class="row mb-3">
                            <div class="col-6"><strong>Invoice #</strong></div>
                            <div class="col-6">{{$invoice->id}}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6"><strong>Invoice Date</strong></div>
                            <div class="col-6">
                                {{ \Carbon\Carbon::parse($invoice->create_at)->format('M d, Y') }}
                            </div>
                        </div>--}}

                        <table class="table table-sm invoice-summary-table">
                            @if($slno)

                                <tr>
                                    <td><strong>Serial #</strong></td>
                                    <td class="text-end">{{$slno}}</td>
                                </tr>
                            @endif
                            <tr>
                                <td><strong>Invoice #</strong></td>
                                <td class="text-end ">{{$invoice->id}}</td>
                            </tr>
                            <tr>
                                <td><strong>Invoice Date</strong></td>
                                <td class="text-end ">
                                    {{ \Carbon\Carbon::parse($invoice->created_at)->format('M d, Y') }}
                                </td>
                            </tr>


                            @if(($invoice->type=="assurance"))

                                <tr>
                                    <td><strong>Due Date</strong></td>
                                    <td class="text-end">
                                        {{ \Carbon\Carbon::parse($invoice_data['startdate'])->format('M d, Y') }}
                                    </td>
                                </tr>
                            @endif
                            @if(($payment_status))

                                <tr>
                                    <td><strong>Payment Received on</strong></td>
                                    <td class="text-end">
                                        {{ \Carbon\Carbon::createFromTimestamp($payment_status['payment_date'])->format('M d, Y') }}
                                    </td>
                                </tr>
                            @endif

                        </table>

                        <!-- Invoice Summary Table -->
                        {{--<table class="table table-sm invoice-summary-table">
                            <tr>
                                <td><strong>Subtotal (CAD)</strong></td>
                                <td class="text-end amount">$ 10,159.70</td>
                            </tr>
                            <tr>
                                <td><strong>Total Due(CAD)</strong></td>
                                <td class="text-end amount">$ 10,159.70</td>
                            </tr>
                            <tr class="total-section">
                                <td><strong>Balance (CAD)</strong></td>
                                <td class="text-end amount">$ 10,159.70</td>
                            </tr>
                        </table>--}}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div id="OrderDetailsDiv" class="col-md-8 col-sm-12">
                <!-- Item Details Table -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0 w-100">
                            <div  class="text-decoration-none d-block" {{--data-bs-toggle="collapse" data-bs-target="#orderDetails"--}}>
                                <div class="d-flex">
                                    <div class="col-12">
                                        Items
                                    </div>
                                    {{--<div class="col-6 text-end">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M6 9l6 6l6 -6" />
                                        </svg>
                                    </div>--}}
                                </div>
                            </div>
                        </h5>
                    </div>
                    @php
                        $hideDiscounted = !empty($invoice->end_customer_id) || $order_pricing === "MSRP";
                    $totalQty=0;
                    $totalPrice=0;
                    @endphp
                    <div id="orderDetails"{{-- class="collapse show"--}}>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Itm</th>
                                        <th>PC</th>
                                        <th>Part Description</th>
                                        <th>Price</th>
                                        @unless($hideDiscounted)
                                            <th>Discounted Price</th>
                                        @endunless
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($invoice->details as $index => $line_item)
                                        <tr>
                                            @php
                                                $discounted_price = $line_item->price;

                                                if($hideDiscounted==0){
                                                    $discount_percent=calculateDiscount($line_item->product_node_id,$category_discount);
                                                    $discounted_price=$discounted_price - (($discounted_price*$discount_percent)/100);
                                                }
//                                                dump($discount_percent);
                                                $subtotal = $discounted_price * $line_item->qty;
                                                $totalQty += $line_item->qty;
                                                $totalPrice += $subtotal;
                                            @endphp

                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $line_item->product?->product_code }}</td>
                                            <td><span class="text-wrap">{{ $line_item->product_node_title }}</span></td>
                                            <td>{{ $currencySymbol }} {{ number_format($line_item->price, 2) }}</td>

                                            @unless($hideDiscounted)
                                                <td>{{ $currencySymbol }} {{ number_format($discounted_price, 2) }}</td>
                                            @endunless

                                            <td>{{ $line_item->qty }}</td>
                                            <td>{{ $currencySymbol }} {{ number_format($subtotal, 2) }}</td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <!-- Right Column: Order Summary -->
            <div id="OrderSummaryDiv" class="col-md-4 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total</h5>
                        <hr style="margin: 10px 0;">
                        {{--<div class="d-flex justify-content-between">
                            <p>Items ({{ $totalQty }}):</p>
                            <p>{{ $currencySymbol }} {{ number_format($totalPrice, 2) }}</p>
                        </div>--}}
                        <div class="d-flex justify-content-between">
                            <p>Subtotal ({{$price_type_display}})</p>
                            <p>{{ $currencySymbol }} {{ number_format($totalPrice, 2) }}</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p>Total Due ({{$price_type_display}})</p>
                            <p>{{ $currencySymbol }} {{ number_format($invoice->total, 2) }}</p>
                        </div>
                        <hr style="margin: 10px 0;">


                        <div class="d-flex justify-content-between">
                            <p>Balance ({{$price_type_display}})</p>
                            <p>{{ $currencySymbol }}
                                {{$invoice->balance}}
                            </p>
                        </div>
                        @if(empty($invoice->payment_status))
                        <button type="submit" class="btn btn-primary d-print-none w-100 mt-3 checkoutBtn">
                            PAY
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
</div>


<!-- Tabler Core -->
<script src="{{asset('')}}dist/js/tabler.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    function generatePDF() {
        const element = document.getElementById('invoiceContent');
        $('.checkoutBtn').hide();
        $('#OrderDetailsDiv').addClass('col-md-12');
        $('#OrderSummaryDiv').addClass('col-md-12');
        $('#OrderDetailsDiv').removeClass('col-md-8');
        $('#OrderSummaryDiv').removeClass('col-md-4');
        html2pdf()
            .set({
                margin: [0.5, 0.5, 0.5, 0.5], // margins in cm
                filename: 'invoice_61710.pdf',
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'cm', format: 'a4', orientation: 'portrait' }
            })
            .from(element)
            .save()
            .then(() => {
                $('.checkoutBtn').show();
                $('#OrderDetailsDiv').removeClass('col-md-12').addClass('col-md-8');
                $('#OrderSummaryDiv').removeClass('col-md-12').addClass('col-md-4');
            })
            .catch(() => {
                $('.checkoutBtn').show();
                $('#OrderDetailsDiv').removeClass('col-md-12').addClass('col-md-8');
                $('#OrderSummaryDiv').removeClass('col-md-12').addClass('col-md-4');
            });
    }
</script>
</body>
</html>
