@extends('layouts.admin')

@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Records
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
                            <form action="{{ route('records.index') }}" method="GET">
                                <div class="card-body">
                                    <div class="row row-cards">
                                        <div class="col-sm-6 col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">Organization</label>
                                                <select id="organization" name="org_id" class="form-control mb-3 select2">
                                                    <option value="">All</option>
                                                    @foreach($orgs as $org)
                                                        <option value="{{ $org->nid }}" {{ request('org_id') == $org->nid ? 'selected' : '' }}>{{ $org->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">Product Code</label>
                                                <input type="text" name="product_code" class="form-control" value="{{ request('product_code') }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">Status</label>
                                                <select id="edit-status" name="site_status" class="form-control form-select select2">
                                                    <option value="">(Select)</option>
                                                    <option value="Sold To" {{ request('site_status') == 'Sold To' ? 'selected' : '' }}>Waiting for Activation</option>
                                                    <option value="Activated" {{ request('site_status') == 'Activated' ? 'selected' : '' }}>Activated</option>
                                                    <option value="In Service" {{ request('site_status') == 'In Service' ? 'selected' : '' }}>In Service</option>
                                                    <option value="Assigned" {{ request('site_status') == 'Assigned' ? 'selected' : '' }}>Assigned</option>
                                                    <option value="Demo with Service" {{ request('site_status') == 'Demo with Service' ? 'selected' : '' }}>Demo with Service</option>
                                                    <option value="Demo-Lab" {{ request('site_status') == 'Demo-Lab' ? 'selected' : '' }}>Demo-Lab</option>
                                                    <option value="Retired" {{ request('site_status') == 'Retired' ? 'selected' : '' }}>Retired</option>
                                                    <option value="Blacklisted" {{ request('site_status') == 'Blacklisted' ? 'selected' : '' }}>Blacklisted</option>
                                                    <option value="Expired" {{ request('site_status') == 'Expired' ? 'selected' : '' }}>Expired</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">Parent Serial Number</label>
                                                <input type="text" name="parent_serial_number" class="form-control" value="{{ request('parent_serial_number') }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">Child Serial Number</label>
                                                <input type="text" name="child_serial_number" class="form-control" value="{{ request('child_serial_number') }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">DID Number</label>
                                                <input type="text" name="did_number" class="form-control" value="{{ request('did_number') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row row-cards advanced-filters" style="display: none;">
                                        <div class="col-sm-6 col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Cluster Serial Number</label>
                                                <input type="text" name="cluster_serial_number" class="form-control" value="{{ request('cluster_serial_number') }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">URL</label>
                                                <input type="text" name="url" class="form-control" value="{{ request('url') }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Host ID</label>
                                                <input type="text" name="host_id" class="form-control" value="{{ request('host_id') }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Customer Name</label>
                                                <input type="text" name="customer_name" class="form-control" value="{{ request('customer_name') }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-1">
                                            <div class="mb-3">
                                                <label class="form-label">Service Level</label>
                                                <select id="edit-service-level" name="service_level" class="form-control form-select select2">
                                                    <option value="">All</option>
                                                    <option value="Standard" {{ request('service_level') == 'Standard' ? 'selected' : '' }}>Standard</option>
                                                    <option value="Premium" {{ request('service_level') == 'Premium' ? 'selected' : '' }}>Premium</option>
                                                    <option value="Premium Plus" {{ request('service_level') == 'Premium Plus' ? 'selected' : '' }}>Premium Plus</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-1">
                                            <div class="mb-3">
                                                <label class="form-label">DSM 16</label>
                                                <select id="edit-dsm16" name="dsm16" class="form-control form-select select2">
                                                    <option value="">(Select)</option>
                                                    <option value="Yes" {{ request('dsm16') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                    <option value="No" {{ request('dsm16') == 'No' ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">Site Name</label>
                                                <input type="text" name="site_name" class="form-control" value="{{ request('site_name') }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">Renewal Date Range Start</label>
                                                <input type="date" name="renewal_date_start" class="form-control" value="{{ request('renewal_date_start') }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">Renewal Date Range End</label>
                                                <input type="date" name="renewal_date_end" class="form-control" value="{{ request('renewal_date_end') }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">Activation Date Range Start</label>
                                                <input type="date" name="activation_date_start" class="form-control" value="{{ request('activation_date_start') }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">Activation Date Range End</label>
                                                <input type="date" name="activation_date_end" class="form-control" value="{{ request('activation_date_end') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row row-cards">
                                        <div class="col-sm-12 col-md-12 text-end">
                                            <button type="button" class="btn btn-info toggle-advanced-filters">Show Advanced Filters</button>
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            @php
                                                $hasFilters = collect(request()->except('_token'))->filter()->isNotEmpty();
                                            @endphp
                                            @if($hasFilters)
                                                <a href="{{ route('records.index') }}" class="btn btn-secondary">Clear Filter</a>
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
                            <table class="table table-selectable card-table table-vcenter text-nowrap datatable">
                                <thead>
                                <tr>
                                    <th>Serial Number</th>
                                    <th>Status</th>
                                    <th>Code</th>
                                    <th>Customer Name</th>
                                    <th>Site Name</th>
                                    <th>Activation</th>
                                    <th>HW Renewal</th>
                                    <th>SW Renewal</th>
                                    <th class="w-1">Level</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($records as $record)
                                <tr>

                                    <td><a href="{{ route('records.details', $record->slno) }}">{{ $record->slno }}</a></td>
                                    <td>{{ $record->site_status ?? '' }}</td>
                                    <td>{{ $record->productSerial?->product_code ?? '' }}</td>
                                    <td>{{ $record->customer_name ?? '' }}</td>
                                    <td>{{ $record->site_name ?? '' }}</td>
                                    <td>{{ timeToDate($record->installation_date) ?? '' }}</td>
                                    <td>{{ timeToDate($record->warranty_renewal_date) ?? '' }}</td>
                                    <td>{{ timeToDate($record->support_renewal_date) ?? '' }}</td>
                                    <td>{{ ucfirst($record->support_type ?? '') }}</td>
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
                            {{$records->links()}}
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
        });
    </script>
@endsection
