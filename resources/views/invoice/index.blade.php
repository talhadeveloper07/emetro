@extends('layouts.admin')

@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Invoices
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">

        <div class="container-xl">
            <div class="row row-deck row-cards">

                <div class="col-12">
                    <div class="card">
                        <form action="{{route('invoice.index')}}" method="get">
                            <div class="card-body">
                                <div class="row row-cards">

                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Organization</label>
                                            <select id="organization" name="org_id"
                                                    class="form-control mb-3 select2">
                                                <option value="">All</option>
                                                @foreach($all_orgs as $all_org)
                                                    <option value="{{$all_org->id}}" {{ request('org_id') == $all_org->id ? 'selected' : '' }}>{{$all_org->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">ID</label>
                                            <input type="text" name="invoice_id" class="form-control" value="{{ request('invoice_id') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">End Customer</label>
                                            <input type="text" name="end_customer" class="form-control" value="{{ request('end_customer') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Type</label>
                                            <select id="edit-type" name="type" class="form-control form-select select2">
                                                <option value="" selected="selected">(Select)</option>
                                                <option value="Monthly Service" {{ request('type') == 'Monthly Service' ? 'selected' : '' }}>Monthly Service</option>
                                                <option value="Annual Service" {{ request('type') == 'Annual Service' ? 'selected' : '' }}>Annual Service</option>
                                                <option value="New Application & Virtual System" {{ request('type') == 'New Application & Virtual System' ? 'selected' : '' }}>New Application & Virtual System</option>
                                                <option value="New Cloud System" {{ request('type') == 'New Cloud System' ? 'selected' : '' }}>New Cloud System</option>
                                                <option value="Add-On" {{ request('type') == 'Add-On' ? 'selected' : '' }}>Add-On</option>
                                                <option value="Wholesale" {{ request('type') == 'Wholesale' ? 'selected' : '' }}>Wholesale</option>
                                                <option value="Wholesale-Monthly" {{ request('type') == 'Wholesale-Monthly' ? 'selected' : '' }}>Wholesale-Monthly</option>
                                                <option value="Wholesale-UCX" {{ request('type') == 'Wholesale-UCX' ? 'selected' : '' }}>Wholesale-UCX</option>
                                                <option value="SIP Monthly Renewal" {{ request('type') == 'SIP Monthly Renewal' ? 'selected' : '' }}>SIP Monthly Renewal</option>
                                                <option value="SIP Annual Renewal" {{ request('type') == 'SIP Annual Renewal' ? 'selected' : '' }}>SIP Annual Renewal</option>
                                                <option value="Appliance" {{ request('type') == 'Appliance' ? 'selected' : '' }}>Appliance</option>
                                                <option value="Custom" {{ request('type') == 'Custom' ? 'selected' : '' }}>Custom</option>
                                                <option value="SMS" {{ request('type') == 'SMS' ? 'selected' : '' }}>SMS</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Payment Status</label>
                                            <select id="edit-payment-status" name="payment_status" class="form-control form-select select2">
                                                <option value="" selected="selected">(Select)</option>
                                                <option value="Paid" {{ request('payment_status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                                                <option value="Not Paid" {{ request('payment_status') == 'Not Paid' ? 'selected' : '' }}>Not Paid</option>
                                                <option value="Over Due" {{ request('payment_status') == 'Over Due' ? 'selected' : '' }}>Over Due</option>
                                                <option value="Hardware Order Only" {{ request('payment_status') == 'Hardware Order Only' ? 'selected' : '' }}>Hardware Order Only</option>
                                                <option value="Exclude Hardware Order" {{ request('payment_status') == 'Exclude Hardware Order' ? 'selected' : '' }}>Exclude Hardware Order</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Due Date Range Start</label>
                                            <input type="date" name="due_date_start" class="form-control" value="{{ request('due_date_start') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Due Date Range End</label>
                                            <input type="date" name="due_date_end" class="form-control" value="{{ request('due_date_end') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Serial Number</label>
                                            <input type="text" name="slno" class="form-control" value="{{ request('slno') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row row-cards">

                                    <div class="col-sm-12 col-md-12  text-end">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        @php
                                            $hasFilters = collect(request()->except('_token'))->filter()->isNotEmpty();
                                        @endphp

                                        @if($hasFilters)
                                            <a href="{{ route('invoice.index') }}" class="btn btn-secondary">Clear Filter</a>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                <tr>
                                    <th>Invoice</th>
                                    <th>Creation</th>
                                    <th>Due date</th>
                                    <th>Total</th>
                                    <th>Balance</th>
                                    <th>Organization</th>
                                    <th>End Customer</th>
                                    <th>Type</th>
                                    <th>Payment Status</th>
                                    <th>Order id</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($invoices as $invoice)
                                    <tr>
                                        <td><span class="text-wrap"> <a href="{{route('invoice.details',$invoice->id)}}" target="_blank">{{$invoice->id}}</a></span></td>
                                        <td><span class="text-wrap">{{ $invoice->created_at->format('m-d-Y') }}</span></td>
                                        <td><span class="text-wrap">
                                                @if(!empty($invoice->type=="assurance"))
                                                    @php     $invoice_data = !empty($invoice->data) ? json_decode($invoice->data, true) : null;
                                                    @endphp
                                                    {{ \Carbon\Carbon::parse($invoice_data['startdate'])->format('M d, Y') }}
                                                @else
                                                    N/A
                                                @endif

                                            </span></td>
                                        <td><span class="text-wrap">$ {{$invoice->total}}</span></td>
                                        <td><span class="text-wrap">$ {{$invoice->balance}}</span></td>
                                        <td><span class="text-wrap">{{$invoice->org?->name}}</span></td>
                                        <td><span class="text-wrap">{{$invoice->end_customer}}</span></td>
                                        <td><span class="text-wrap">{{ucwords($invoice->type)}}</span></td>
                                        <td><span class="text-wrap">
                                                {{--{{$invoice->payment_status}}--}}
                                                @if(!empty($invoice->payment_status))
                                                    @php     $payment_status           = !empty($invoice->payment_status) ? json_decode($invoice->payment_status, true) : null;
                                                    @endphp
                                                    Paid on {{ \Carbon\Carbon::createFromTimestamp($payment_status['payment_date'])->format('M d, Y') }}
                                                    <a href="{{route('invoice.thankyou',$invoice->id)}}" target="_blank">Receipt</a>
                                                @else
                                                    Not Paid
                                                @endif
                                            </span></td>
                                        <td><span class="text-wrap"> <a href="{{route('invoice.order_details',$invoice->id)}}" target="_blank">{{$invoice->id}}</a></span></td>
                                        <td>
                                       <span class="dropdown">
                                          <button class="btn dropdown-toggle align-text-top" data-bs-boundary="table-responsive" data-bs-toggle="dropdown" aria-expanded="false">
                                              <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-settings m-0"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" /><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /></svg>
                                          </button>
                                          <div class="dropdown-menu dropdown-menu-start" style="">
                                            <a class="dropdown-item" href="#">
                                              Send Mail
                                            </a>
                                            <a class="dropdown-item" href="#">
                                              Payment Received
                                            </a>
<a class="dropdown-item" href="#">
                                              Delete
                                            </a>
                                          </div>
                                        </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="20">
                                            <div class="empty">
                                                <div class="empty-img"><img src="{{asset('')}}static/illustrations/undraw_printing_invoices_5r4r.svg" height="128"  alt="">
                                                </div>
                                                <p class="empty-title">No results found</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center">
                            {{$invoices->links()}}
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            $('.toggle-advanced-filters').on('click', function() {
                $('.advanced-filters').slideToggle(300, function() {
                    // Update button text after animation completes
                    var $button = $('.toggle-advanced-filters');
                    if ($('.advanced-filters').is(':visible')) {
                        $button.text('Hide Advanced Filters');
                    } else {
                        $button.text('Show Advanced Filters');
                    }
                });
            });

            $('#country').change(function(){
                let countryCode = $(this).val();

                if(countryCode) {
                    let url = '{{ route("getStates", ":countryCode") }}'.replace(':countryCode', countryCode);

                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            $('#state').empty().append('<option value="">-None-</option>');
                            // console.log(response);
                            $.each(response, function(key, state) {
                                $('#state').append('<option value="'+ state.state_code +'">'+ state.name +'</option>');
                            });
                        }
                    });
                } else {
                    $('#state').empty().append('<option value="">-None-</option>');
                }
            });

        });
    </script>
@endsection
