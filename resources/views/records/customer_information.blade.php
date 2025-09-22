@extends('layouts.admin')

@section('content')
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
                <form action="{{ route('records.save_customer_information', $record->slno) }}" method="post" id="details-form">
                    @csrf
                <div class="row">
                    <div class="col-12 d-flex flex-column">
                        <div class="card-body">
                            @include('records.partials.tabs')
                            <div class="row">
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label" for="edit-customer-name">Customer Name</label>
                                    <input disabled type="text" id="edit-customer-name" name="customer_name" value="{{ $record->customer_name }}" size="60" maxlength="128" class="form-control">
                                </div>
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label" for="edit-site-name">Site Name</label>
                                    <input disabled type="text" id="edit-site-name" name="site_name" value="{{ $record->site_name }}" size="60" maxlength="128" class="form-control">
                                </div>
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label" for="edit-customer-email-address">Customer E-Mail</label>
                                    <input disabled type="text" id="edit-customer-email-address" name="customer_email_address" size="60" maxlength="128" value="{{ $record->customer_email_address }}" class="form-control">
                                </div>
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label" for="edit-customer-phone-number">Customer phone number</label>
                                    <input disabled type="text" id="edit-customer-phone-number" name="customer_phone_number" size="60" maxlength="128" value="{{ $record->customer_phone_number }}" class="form-control">
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
