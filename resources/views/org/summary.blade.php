@extends('layouts.admin')

@section('content')
    @include('org.header')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="row">
                    <div class="col-12 d-flex flex-column">
                        <div class="card-body">
                            @include('org.header_tabs')
                            <div class="row align-items-center">
                                <div class="col">
                                </div>
                                <div class="col-auto ms-auto d-print-none">
                                    <div class="btn-list">
                                        <button type="button" id="edit-btn" class="btn btn-primary">Edit</button>
                                        <button type="button" id="discard-btn" class="btn btn-secondary d-none" >Discard Changes</button>
                                        <button type="submit" id="save-btn" class="btn btn-primary d-none" form="details-form">Save</button>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active show" role="tabpanel">
                                    <form id="details-form" action="{{route('org.summary_update',$org->id)}}" method="POST">
                                        @csrf
                                    <div class="row mb-3">
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="form-label">Type</label>
                                            @php
                                                $types = ['Reseller', 'Distributor', 'Customer'];
                                            @endphp
                                            <select name="org_type" class="form-control form-select select2" disabled>
                                                <option value="">(Select)</option>
                                                @foreach ($types as $type)
                                                    <option value="{{ $type }}" {{ $org->org_type == $type ? 'selected' : '' }}>{{ $type }}</option>
                                                @endforeach
                                                @if ($org->org_type && !in_array($org->org_type, $types))
                                                    <option value="{{ $org->org_type }}" selected>{{ $org->org_type }}</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-control form-select select2" disabled>
                                                <option value="">(Select)</option>
                                                <option value="Active" {{ $org->status == "Active" ? "selected" : "" }}>Active</option>
                                                <option value="Prospect" {{ $org->status == "Prospect" ? "selected" : "" }}>Prospect</option>
                                                <option value="Hold" {{ $org->status == "Hold" ? "selected" : "" }}>Hold</option>
                                                <option value="Deactivated" {{ $org->status == "Deactivated" ? "selected" : "" }}>Deactivated</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="form-label">Country</label>
                                            <select class="form-control form-select select2" name="billing_country" id="billing_country" disabled>
                                                <option value="">-None-</option>
                                                @foreach($countries as $country)
                                                    <option value="{{ $country['iso2'] }}"
                                                            @if($org->billing_country == $country['iso2']) selected @endif>
                                                        {{ $country['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="form-label">State/Province</label>
                                            <select class="form-control form-select select2" name="billing_state" id="billing_state" disabled>
                                                <option value="">-None-</option>
                                                @foreach($states as $state)
                                                    <option value="{{ $state['state_code'] }}"
                                                            @if($org->billing_state == $state['state_code']) selected @endif>
                                                        {{ $state['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="form-label">Prime Contact</label>
                                            <select class="form-control" name="" id="" disabled> {{--convert it into select--}}
                                                <option value="">(Select)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="text" name="email" value="{{ $org->email }}" class="form-control" disabled>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="form-label">Phone</label>
                                            <input type="text" name="phone" value="{{ $org->phone }}" class="form-control" disabled>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="form-label">Website</label>
                                            <input type="text" name="website" value="{{ $org->website }}" class="form-control" disabled>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="form-label">Assigned To</label> {{--convert it into select--}}
                                            <input disabled type="text" value="{{$org->emt_contact}}" class="form-control" disabled>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="form-label">Price Type</label>
                                            <input type="text" name="price_type" value="{{ $org->price_type }}" class="form-control" disabled>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="form-label">Sales Agent</label>
                                            <select name="sale_agent" id="" class="form-control select2" disabled>
                                                <option value="">-None-</option>
                                                @if($org->agent_name)
                                                    <option value="{{ $org->agent_name }}">{{ $org->agent_name }}</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="form-label">Agent Start Date</label>
                                            <input type="date" name="agent_start" value="{{ $org->agent_start }}" class="form-control" disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <h2 class="text-lime">Fulfillment</h2>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="form-label">HW Fulfillment</label>
                                            <select name="hw_fulfilment[]" id="hw_fulfilment" class="form-control select2" multiple disabled>
                                                <option value="" >-None-</option> {{--idont want to select it for multiple--}}
                                                @php
                                                    $selectedHwFulfillments = $org->hwFulfillments->pluck('hw_fulfillment_nid')->toArray();
                                                @endphp
                                                @foreach($orgs as $or)
                                                    <option value="{{ $or->nid }}" {{ in_array($or->nid, $selectedHwFulfillments) ? 'selected' : '' }}>
                                                        {{ $or->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="form-label">SW/Services Fulfillment</label>
                                            <select name="sw_fulfilment[]" id="sw_fulfilment" class="form-control select2" multiple disabled>
                                                <option value="" >-None-</option> {{--idont want to select it for multiple --}}
                                                @php
                                                    $selectedSwFulfillments = $org->swFulfillments->pluck('sw_fulfillment_nid')->toArray();
                                                @endphp
                                                @foreach($orgs as $or)
                                                    <option value="{{ $or->nid }}" {{ in_array($or->nid, $selectedSwFulfillments) ? 'selected' : '' }}>
                                                        {{ $or->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $('#billing_country').change(function(){
                let countryCode = $(this).val();

                if(countryCode) {
                    let url = '{{ route("getStates", ":countryCode") }}'.replace(':countryCode', countryCode);

                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            $('#billing_state').empty().append('<option value="">-None-</option>');
                            // console.log(response);
                            $.each(response, function(key, state) {
                                $('#billing_state').append('<option value="'+ state.state_code +'">'+ state.name +'</option>');
                            });
                        }
                    });
                } else {
                    $('#billing_state').empty().append('<option value="">-None-</option>');
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            let isEditing = false;
            const editBtn = document.getElementById('edit-btn');
            const saveBtn = document.getElementById('save-btn');
            const discardBtn = document.getElementById('discard-btn');
            const form = document.getElementById('details-form');

            const inputs = form.querySelectorAll('input, select, textarea, input[type="radio"], input[type="checkbox"]');
            const tabLinks = document.querySelectorAll('.nav-tabs .nav-link');

            editBtn.addEventListener('click', function () {
                isEditing = true;
                inputs.forEach(input => {
                    if (input.name !== 'extension_total') { // Exclude readonly total field
                        input.disabled = false;
                    }
                });
                editBtn.classList.add('d-none');
                saveBtn.classList.remove('d-none');
                discardBtn.classList.remove('d-none');

            });

            saveBtn.addEventListener('click', function () {
                // inputs.forEach(input => {
                //     input.disabled = true;
                // });
                isEditing = false;
                editBtn.classList.remove('d-none');
                saveBtn.classList.add('d-none');
                discardBtn.classList.add('d-none');

            });
            discardBtn.addEventListener('click', function () {
                Swal.fire({
                    title: 'Discard Changes?',
                    text: 'You have unsaved changes. Are you sure you want to discard them?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, discard',
                    cancelButtonText: 'No, stay',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            });
            tabLinks.forEach(link => {
                link.addEventListener('click', function (event) {
                    if (isEditing) {
                        event.preventDefault();
                        Swal.fire({
                            title: 'Discard Changes?',
                            text: 'You have unsaved changes. Are you sure you want to discard them?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, discard',
                            cancelButtonText: 'No, stay',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                isEditing = false;
                                inputs.forEach(input => {
                                    input.disabled = true;
                                });
                                editBtn.classList.remove('d-none');
                                saveBtn.classList.add('d-none');
                                window.location.href = link.href;
                            }
                        });
                    }
                });
            });
        });
    </script>

@endsection
