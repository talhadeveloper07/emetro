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

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            @include('records.partials.top_cards')
            <div class="card">

                <div class="row">
                    <div class="col-12 d-flex flex-column">
                        <div class="card-body">
                            @include('records.partials.tabs')
                            <div class="row">
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label">EMT SIP Channel</label>
                                    <input disabled type="number" id="edit-sip_trunks" name="sip_trunks" value="{{ $record->sip_trunks }}" class="form-control">
                                </div>
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label">Total DID</label>
                                    <input disabled type="number" id="edit-did_numbers" name="did_numbers" value="{{ $record->did_numbers }}" class="form-control">
                                </div>
                                <h2 class="text-lime">E911 Address</h2>
                                <div id="e911-addresses">
                                    @if($record->sipTruncks)
                                        @foreach($record->sipTruncks as $index => $sipTrunk)
                                            <div class="e911-address row" data-index="{{ $index }}">
                                                <div class="col-md-4 col-sm-12 mb-3">
                                                    <label class="form-label">Name</label>
                                                    <input type="hidden" name="sip_trunk[{{ $index }}][id]" value="{{ $sipTrunk->id }}">
                                                    <input type="text" name="sip_trunk[{{ $index }}][customer_name]" value="{{ $sipTrunk->customer_name }}" class="form-control" disabled>
                                                </div>
                                                <div class="col-md-4 col-sm-12 mb-3">
                                                    <label class="form-label">Address 1</label>
                                                    <input type="text" name="sip_trunk[{{ $index }}][customer_address1]" value="{{ $sipTrunk->customer_address1 }}" class="form-control" disabled>
                                                </div>
                                                <div class="col-md-4 col-sm-12 mb-3">
                                                    <label class="form-label">City</label>
                                                    <input type="text" name="sip_trunk[{{ $index }}][customer_city]" value="{{ $sipTrunk->customer_city }}" class="form-control" disabled>
                                                </div>
                                                <div class="col-md-4 col-sm-12 mb-3">
                                                    <label class="form-label">State</label>
                                                    <input type="text" name="sip_trunk[{{ $index }}][customer_state]" value="{{ $sipTrunk->customer_state }}" class="form-control" disabled>
                                                </div>
                                                <div class="col-md-4 col-sm-12 mb-3">
                                                    <label class="form-label">ZIP</label>
                                                    <input type="text" name="sip_trunk[{{ $index }}][customer_zip]" value="{{ $sipTrunk->customer_zip }}" class="form-control" disabled>
                                                </div>
                                                <div class="col-md-3 col-sm-12 mb-3">
                                                    <label class="form-label">Country</label>
                                                    <input type="text" name="sip_trunk[{{ $index }}][customer_country]" value="{{ $sipTrunk->customer_country }}" class="form-control" disabled>
                                                </div>
                                                <div class="col-md-1 col-sm-12 mb-3">
                                                    <label class="form-label">&nbsp;</label>
                                                    <button type="button" class="btn btn-danger delete-e911-btn d-none">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0"/><path d="M10 11l0 6"/><path d="M14 11l0 6"/><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/></svg>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div>
                                    <button type="button" id="add-e911-btn" class="btn btn-primary d-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5v14m-7-7h14" /></svg>
                                        Add E911 Address
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
{{--@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let isEditing = false;
            const editBtn = document.getElementById('edit-btn');
            const saveBtn = document.getElementById('save-btn');
            const discardBtn = document.getElementById('discard-btn');
            const addE911Btn = document.getElementById('add-e911-btn');
            const form = document.getElementById('details-form');
            const e911Addresses = document.getElementById('e911-addresses');
            let inputs = form.querySelectorAll('input, select, textarea, input[type="radio"], input[type="checkbox"]');
            const tabLinks = document.querySelectorAll('.nav-tabs .nav-link');
            let e911Index = {{ $record->sipTruncks ? $record->sipTruncks->count() : 0 }};
            function updateInputs() {
                inputs = form.querySelectorAll('input, select, textarea, input[type="radio"], input[type="checkbox"]');
            }
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
                addE911Btn.classList.remove('d-none');
                $('.delete-e911-btn').removeClass('d-none');
            });

            saveBtn.addEventListener('click', function () {
                // inputs.forEach(input => {
                //     input.disabled = true;
                // });
                isEditing = false;
                editBtn.classList.remove('d-none');
                saveBtn.classList.add('d-none');
                discardBtn.classList.add('d-none');
                addE911Btn.classList.add('d-none');
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
            addE911Btn.addEventListener('click', function () {
                let newE911 = document.createElement('div');
                newE911.className = 'e911-address row';
                newE911.dataset.index = e911Index;
                newE911.innerHTML = `
                <div class="col-md-4 col-sm-12 mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="sip_trunk[${e911Index}][customer_name]" class="form-control">
                </div>
                <div class="col-md-4 col-sm-12 mb-3">
                    <label class="form-label">Address 1</label>
                    <input type="text" name="sip_trunk[${e911Index}][customer_address1]" class="form-control">
                </div>
                <div class="col-md-4 col-sm-12 mb-3">
                    <label class="form-label">City</label>
                    <input type="text" name="sip_trunk[${e911Index}][customer_city]" class="form-control">
                </div>
                <div class="col-md-4 col-sm-12 mb-3">
                    <label class="form-label">State</label>
                    <input type="text" name="sip_trunk[${e911Index}][customer_state]" class="form-control">
                </div>
                <div class="col-md-4 col-sm-12 mb-3">
                    <label class="form-label">ZIP</label>
                    <input type="text" name="sip_trunk[${e911Index}][customer_zip]" class="form-control">
                </div>
                <div class="col-md-3 col-sm-12 mb-3">
                    <label class="form-label">Country</label>
                    <input type="text" name="sip_trunk[${e911Index}][customer_country]" class="form-control">
                </div>
                <div class="col-md-1 col-sm-12 mb-3">
                    <label class="form-label">&nbsp;</label>
                    <button type="button" class="btn btn-danger delete-e911-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0"/><path d="M10 11l0 6"/><path d="M14 11l0 6"/><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/></svg>
                    </button>
                </div>
            `;
                e911Addresses.appendChild(newE911);
                e911Index++;
                updateInputs();
                // Attach delete event listener to the new delete button
                newE911.querySelector('.delete-e911-btn').addEventListener('click', function () {
                    newE911.remove();
                    updateInputs();
                });
            });

            // Attach delete event listeners to existing delete buttons
            document.querySelectorAll('.delete-e911-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    btn.closest('.e911-address').remove();
                    updateInputs();
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
                                discardBtn.classList.add('d-none');
                                addE911Btn.classList.add('d-none');
                                window.location.href = link.href;
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection--}}
