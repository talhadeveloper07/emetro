@extends('layouts.admin')

@section('content')
    <style>
        .select2-container{
            width: 100% !important;
        }
    </style>
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        <a href="{{ route('records.index') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>
                        </a>
                        Record
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <button type="button" id="edit-btn" class="btn btn-primary">Edit</button>
                        <button type="button" id="discard-btn" class="btn btn-secondary d-none" >Discard Changes</button>
                        <button type="submit" id="save-btn" class="btn btn-primary d-none" form="details-form">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            @include('records.partials.top_cards')
            <div class="card">
                <form id="details-form" action="{{ route('records.save_details', $record->slno) }}" method="POST">
                    @csrf
                <div class="row">
                    <div class="col-12 d-flex flex-column">
                        <div class="card-body">
                            @include('records.partials.tabs')
                            <div class="row mb-3">
                                <h2 class="text-lime">Organization</h2>
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label" for="edit-installed-by">Primary Organization</label>
                                    {{--                                    <input disabled type="text" id="edit-installed-by" name="installed_by" value="{{ $record->productSerial->org->name }}" size="60" maxlength="128" class="form-control">--}}
                                    <select class="form-select select2" name="installed_by" id="installed_by" disabled>
                                        <option value="">-Select-</option>
                                        @foreach($orgs as $org)
                                            <option value="{{$org->nid}}" {{ $record->installed_by == $org->nid ? 'selected' : '' }}>{{$org->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label" for="edit-dealer-type">Organization Type</label>
                                    <input disabled readonly type="text" id="edit-dealer-type" name="dealer_type" value="{{ $record->productSerial?->org?->org_type }}" size="60" maxlength="128" class="form-control">
                                </div>
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label" for="edit-dealer-email">Organization Email</label>
                                    <input disabled type="text" id="edit-dealer-email" name="dealer_email" value="{{ $record->dealer_email }}" size="60" maxlength="128" class="form-control">
                                </div>

                                <div class="col-md-4 col-sm-12 mb-3 {{$record->productSerial?->end_customer_id?"":"d-none"}}" id="secondary-org-container">
                                    <label class="form-label" for="secondary_org">Secondary Organization</label>
                                    <select class="form-select select2" name="secondary_org" id="secondary_org" disabled>
                                        <option value="">-Select-</option>
                                        @foreach($orgs as $org)
                                            <option value="{{$org->nid}}" {{ $record->productSerial?->end_customer_id == $org->nid ? 'selected' : '' }}>{{$org->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <h2 class="text-lime">Warranty</h2>
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select select2" name="site_status" id="site_status" disabled>
                                        <option value="">-Select-</option>
                                        @foreach(get_site_status_options() as $site_status)
                                            <option value="{{$site_status}}" {{ $record->site_status == $site_status ? 'selected' : '' }}>{{$site_status}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label">Installation</label>
                                    <input disabled type="date" name="installation_date" value="{{ timeToDateYMD($record->installation_date) }}" class="form-control">
                                </div>
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label">Services Assurance Renewal</label>
                                    <input disabled type="date" name="support_renewal_date" value="{{ timeToDateYMD($record->support_renewal_date) }}" class="form-control">
                                </div>
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label">HW Warranty Renewal</label>
                                    <input disabled type="date" name="warranty_renewal_date" value="{{ timeToDateYMD($record->warranty_renewal_date) }}" class="form-control">
                                </div>
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label">Service Level</label>
                                    @php
                                        // Normalize DB value
                                        $normalizedSupportType = strtolower(str_replace(' ', '', $record->support_type));
                                    @endphp
                                    <select disabled  class="form-select select2" name="support_type" id="support_type">
                                        <option value="">-Select-</option>
                                        <option value="Standard" {{ in_array($normalizedSupportType, ['standard']) ? 'selected' : '' }}>Standard</option>
                                        <option value="Premium" {{ in_array($normalizedSupportType, ['premium']) ? 'selected' : '' }}>Premium</option>
                                        <option value="Premium Plus" {{ in_array($normalizedSupportType, ['premiumplus']) ? 'selected' : '' }}>Premium Plus</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <h2 class="text-lime">Details</h2>
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label">Configuration</label>
                                    <select class="form-select select2" name="configuration" id="configuration" disabled>
                                        <option value="">-Select-</option>
                                        @foreach(get_configuration_options() as $configuration)
                                            <option value="{{$configuration}}" {{ $record->configuration == $configuration ? 'selected' : '' }}>{{$configuration}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label">MAC Address 1</label>
                                    <input disabled type="text" id="edit-mac-address-0" name="mac_address_0" value="{{ $record->productSerial?->mac_address_0 }}" size="60" maxlength="128" class="form-control">
                                </div>
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label">MAC Address 2</label>
                                    <input disabled type="text" id="edit-mac-address-1" name="mac_address_1" value="{{ $record->productSerial?->mac_address_0 }}" size="60" maxlength="128" class="form-control">
                                </div>
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label">SW Version</label>
                                    <input disabled type="text" id="edit-sw-version" name="sw_version" value="{{ $record->sw_version }}" size="60" maxlength="128" class="form-control">
                                </div>
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label">Public IP Address</label>
                                    <input disabled type="text" id="edit-public-ip" name="public_ip" value="{{ $record->access?->public_ip }}" size="60" maxlength="128" class="form-control">
                                </div>
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label">UCX VPN</label>
                                    <input disabled type="text" id="edit-vpn-ip-address" name="vpn_ip_address" value="{{ $record->access?->vpn }}" size="60" maxlength="128" class="form-control">
                                </div>
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label">UCX URL</label>
                                    <input disabled type="text" name="url" size="60" maxlength="128" value="{{ optional($record->access)->hostname ? 'https://' . $record->access->hostname : '' }}" class="form-control">
                                </div>
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label">UCX LAST REPORTED</label>
                                    <input disabled type="text" name="url" size="60" maxlength="128" class="form-control">
                                </div>
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label">INFINITY VIDEO URL</label>
                                    <input disabled type="text" name="url" size="60" maxlength="128" class="form-control">
                                </div>
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label">Host ID</label>
                                    <input disabled type="text" id="edit-host-id" name="host_id" value="{{ $record->productSerial?->host_id }}" size="60" maxlength="128" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <h2 class="text-lime">Extension</h2>
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label" for="edit-basic">Basic</label>
                                    <input disabled type="text" id="edit-basic" name="basic_ext" value="{{ $record->basic_ext }}" size="60" maxlength="128" class="form-control">
                                </div>
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label" for="edit-universal">Universal</label>
                                    <input disabled type="text" id="edit-universal" name="universal_ext" value="{{ $record->universal_ext }}" size="60" maxlength="128" class="form-control">
                                </div>
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label" for="edit-emetro">Standard</label>
                                    <input disabled type="text" id="edit-emetro" name="e_metrotel_ext" value="{{ $record->e_metrotel_ext }}" size="60" maxlength="128" class="form-control">
                                </div>
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label" for="edit-extension-total">Total</label>
                                    <input disabled type="text" id="edit-extension-total" name="extension_total" value="{{ (int)$record->basic_ext + (int)$record->universal_ext + (int)$record->e_metrotel_ext }}" size="60" maxlength="128" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <h2 class="text-lime">Applications</h2>
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <button type="button" class="btn btn-primary">Connect Omnichannel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let isEditing = false;
            const editBtn = document.getElementById('edit-btn');
            const saveBtn = document.getElementById('save-btn');
            const discardBtn = document.getElementById('discard-btn');
            const form = document.getElementById('details-form');
            const secondaryOrgContainer = document.getElementById('secondary-org-container');

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
                secondaryOrgContainer.classList.remove('d-none');

            });

            saveBtn.addEventListener('click', function () {
                // inputs.forEach(input => {
                //     input.disabled = true;
                // });
                isEditing = false;
                editBtn.classList.remove('d-none');
                saveBtn.classList.add('d-none');
                discardBtn.classList.add('d-none');
                secondaryOrgContainer.classList.add('d-none');

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
