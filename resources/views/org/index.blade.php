@extends('layouts.admin')

@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Organizations
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
                        <form action="{{route('org.index')}}" method="get">
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
                                            <label class="form-label">Email</label>
                                            <input type="text" name="org_email" class="form-control" value="{{ request('org_email') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select id="edit-status" name="status"
                                                    class="form-control form-select select2">
                                                <option value="" selected="selected">(Select)</option>
                                                <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                                <option value="Prospect" {{ request('status') == 'Prospect' ? 'selected' : '' }}>Prospect</option>
                                                <option value="Hold" {{ request('status') == 'Hold' ? 'selected' : '' }}>Hold</option>
                                                <option value="Deactivated" {{ request('status') == 'Deactivated' ? 'selected' : '' }}>Deactivated</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Type</label>
                                            <select name="org_type" class="form-control form-select select2" multiple>
                                                <option value="Reseller" {{ collect(request('org_type'))->contains('Reseller') ? 'selected' : '' }}>Reseller</option>
                                                <option value="Distributor" {{ collect(request('org_type'))->contains('Distributor') ? 'selected' : '' }}>Distributor</option>
                                                <option value="Customer" {{ collect(request('org_type'))->contains('Customer') ? 'selected' : '' }}>Customer</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Country</label>
                                            <select id="country" name="country" class="form-control form-select select2">
                                                <option value="">Select Country</option>
                                                @foreach($countries as $country)
                                                    <option value="{{$country['iso2']}}" {{ request('country') == $country['iso2'] ? 'selected' : '' }}>
                                                        {{ $country['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">State/Province</label>
                                            <select id="state" name="state" class="form-control form-select select2">
                                                @foreach($states as $state)
                                                    <option value="{{$state['state_code']}}" {{ request('state') == $state['state_code'] ? 'selected' : '' }}>
                                                        {{ $state['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">First Name</label>
                                            <input type="text" name="first_name" class="form-control" value="{{ request('first_name') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Last name</label>
                                            <input type="text" name="last_name" class="form-control" value="{{ request('last_name') }}">
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
                                            <a href="{{ route('org.index') }}" class="btn btn-secondary">Clear Filter</a>
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
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>State</th>
                                    <th>Country</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th class="w-1">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                {{--<tr>
                                    <td>Compton's Telecommunication Services</td>
                                    <td> <span class="text-wrap">975 Elgin St W Unit 5</span> </td>
                                    <td>Ontario</td>
                                    <td>Canada</td>
                                    <td>aburchat@comptontel.ca</td>
                                    <td>905-372-0353</td>
                                    <td>Reseller</td>
                                    <td>Active</td>
                                    <td>
                                        <a href="{{route('org.details',1)}}" class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>--}}

                                @forelse($orgs as $org)
                                <tr>
                                    <td><span class="text-wrap">{{$org->name}}</span></td>
                                    <td><span class="text-wrap">{{$org->billing_address_1}}{{$org->billing_address_2?" , ".$org->billing_address_2:""}}</span></td>
                                    <td>{{getStateByCode($org->billing_state)}}</td>
                                    <td>{{getCountryByCode($org->billing_country)}}</td>
                                    <td><span class="text-wrap">{{$org->email}}</span></td>
                                    <td><span class="text-wrap">{{$org->phone}}</span></td>
                                    <td>{{$org->org_type}}</td>
                                    <td>{{$org->status}}</td>
                                    <td>
                                        <a href="{{route('org.summary',$org->id)}}" class="btn btn-primary btn-sm">View</a>
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
                            {{$orgs->links()}}
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
