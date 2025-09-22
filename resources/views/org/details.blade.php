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
                                <div class="col"></div>
                                <div class="col-auto ms-auto d-print-none">
                                    <div class="btn-list">
                                        <button type="button" id="edit-btn" class="btn btn-primary">Edit</button>
                                        <button type="button" id="discard-btn" class="btn btn-secondary d-none">Discard Changes</button>
                                        <button type="submit" id="save-btn" class="btn btn-primary d-none" form="details-form">Save</button>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active show" role="tabpanel">
                                    <form id="details-form" action="{{ route('org.details_update', $org->id) }}" method="POST">
                                        @csrf
                                    <div class="row mb-3">
                                        <h2 class="text-lime">Billing Address</h2>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="form-label">Address 1</label>
                                            <input type="text" name="billing_address_1" value="{{ $org->billing_address_1 }}" class="form-control" disabled>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="form-label">Address 2</label>
                                            <input type="text" name="billing_address_2" value="{{ $org->billing_address_2 }}" class="form-control" disabled>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="form-label">City</label>
                                            <input type="text" name="billing_city" value="{{ $org->billing_city }}" class="form-control" disabled>
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
                                                @foreach($billingStates as $state)
                                                    <option value="{{ $state['state_code'] }}"
                                                            @if($org->billing_state == $state['state_code']) selected @endif>
                                                        {{ $state['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="form-label">Zip/postal code</label>
                                            <input type="text" name="billing_zip" value="{{ $org->billing_zip }}" class="form-control" disabled>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="form-label">County</label>
                                            <select name="billing_county" id="b_county" class="form-control form-select select2" disabled>
                                                <option value="">-None-</option>
                                                @if($org->billing_county)
                                                    <option value="{{ $org->billing_county }}" selected>{{ $org->billing_county }}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <h2 class="text-lime">Shipping Address</h2>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="form-label">Address 1</label>
                                            <input type="text" name="shipping_address_1" value="{{ $org->shipping_address_1 }}" class="form-control" disabled>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="form-label">Address 2</label>
                                            <input type="text" name="shipping_address_2" value="{{ $org->shipping_address_2 }}" class="form-control" disabled>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="form-label">City</label>
                                            <input type="text" name="shipping_city" value="{{ $org->shipping_city }}" class="form-control" disabled>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="form-label">Country</label>
                                            <select class="form-control form-select select2" name="shipping_country" id="shipping_country" disabled>
                                                <option value="">-None-</option>
                                                @foreach($countries as $country)
                                                    <option value="{{ $country['iso2'] }}"
                                                            @if($org->shipping_country == $country['iso2']) selected @endif>
                                                        {{ $country['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="form-label">State/Province</label>
                                            <select class="form-control form-select select2" name="shipping_state" id="shipping_state" disabled>
                                                <option value="">-None-</option>
                                                @foreach($shippingStates as $state)
                                                    <option value="{{ $state['state_code'] }}"
                                                            @if($org->shipping_state == $state['state_code']) selected @endif>
                                                        {{ $state['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="form-label">Zip/postal code</label>
                                            <input type="text" name="shipping_zip" value="{{ $org->shipping_zip }}" class="form-control" disabled>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="form-label">County</label>
                                            <select name="shipping_county" id="s_county" class="form-control form-select select2" disabled>
                                                <option value="">-None-</option>
                                                @if($org->shipping_county)
                                                    <option value="{{ $org->shipping_county }}" selected>{{ $org->shipping_county }}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                            <h2 class="text-lime">Other</h2>
                                            <div class="col-md-4 col-sm-12 mb-3">
                                                <label class="form-label" for="edit-basic">Business Tax ID or Social Security Number</label>
                                                <input disabled type="text" id="edit-basic" name="basic" value="" class="form-control" disabled>
                                            </div>
                                            <div class="col-md-4 col-sm-12 mb-3">
                                                <label class="form-label" for="no_of_emp"># of Employees</label>
                                                <input type="text" id="no_of_emp" name="no_of_emp" value="{{ $org->no_of_emp }}" class="form-control" disabled>
                                            </div>
                                            <div class="col-md-4 col-sm-12 mb-3">
                                                <label class="form-label" for="tax_exemption">Tax Exemption</label>
                                                <input type="text" id="tax_exemption" name="tax_exemption" value="{{ $org->tax_exemption }}" class="form-control" disabled>
                                            </div>
                                            <div class="col-md-4 col-sm-12 mb-3">
                                                <label class="form-label" for="edit-extension-total">Logo</label>
                                                <input disabled type="file" id="edit-extension-total" name="extension_total" value="0" size="60" maxlength="128" class="form-control" disabled>
                                            </div>
                                        </div>
                                    <div class="row mb-3">
                                        <h1 class="text-lime">E-MetroTel Internal</h1>
                                        <h2 class="text-lime">Discounts</h2>
                                        @foreach($discounts as $discount)
                                            @php
                                                $orgDiscount = $org->discounts->firstWhere('id', $discount->id);
                                                $value = $orgDiscount?->pivot?->custom_amount ?? $discount->amount;
                                            @endphp
                                            <div class="col-md-2 col-sm-4 mb-3">
                                                <label class="form-label">{{ $discount->name }}</label>
                                                <input type="number"
                                                       name="discounts[{{ $discount->id }}]"
                                                       value="{{ $value }}"
                                                       class="form-control"
                                                       step="0.01"
                                                       disabled>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="row mb-3">
                                        <h2 class="text-lime">Payment</h2>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <div class="form-label">Payment Options</div>
                                            <div>
                                                <label class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="is_paypal"
                                                           value="1" {{ $org->setting?->is_paypal ? 'checked' : '' }} disabled>
                                                    <span class="form-check-label">PayPal</span>
                                                </label>
                                                <label class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="is_emtpay"
                                                           value="1" {{ $org->setting?->is_emtpay ? 'checked' : '' }} disabled>
                                                    <span class="form-check-label">EmtPay</span>
                                                </label>
                                                <label class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="is_stripe"
                                                           value="1" {{ $org->setting?->is_stripe ? 'checked' : '' }} disabled>
                                                    <span class="form-check-label">Stripe</span>
                                                </label>
                                                <label class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="is_ach"
                                                           value="1" {{ $org->setting?->is_ach ? 'checked' : '' }} disabled>
                                                    <span class="form-check-label">ACH</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <div class="form-label">EMTPay TopUp</div>
                                            <div>
                                                <label class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="is_emtpay_topup" value="1"
                                                           {{ $org->setting?->is_emtpay_topup ? 'checked' : '' }} disabled>
                                                    <span class="form-check-label">Yes</span>
                                                </label>
                                                <label class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="is_emtpay_topup" value="0"
                                                           {{ $org->setting && !$org->setting->is_emtpay_topup ? 'checked' : '' }} disabled>
                                                    <span class="form-check-label">No</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="form-label">Save Credit Card</label>
                                            <select class="form-control form-select select2" name="save_credit_card" disabled>
                                                <option value="">-None-</option>
                                                <option value="1" {{ $org->setting?->save_credit_card ? 'selected' : '' }}>Yes</option>
                                                <option value="0" {{ $org->setting && !$org->setting->save_credit_card ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="form-label">Monthly bill auto credit card payment</label>
                                            <select class="form-control form-select select2" name="monthly_bill_auto_payment" disabled>
                                                <option value="">-None-</option>
                                                <option value="1" {{ $org->setting?->monthly_bill_auto_payment ? 'selected' : '' }}>Yes</option>
                                                <option value="0" {{ $org->setting && !$org->setting->monthly_bill_auto_payment ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="form-label">Annual bill auto credit card payment</label>
                                            <select class="form-control form-select select2" name="annual_bill_auto_payment" disabled>
                                                <option value="">-None-</option>
                                                <option value="1" {{ $org->setting?->annual_bill_auto_payment ? 'selected' : '' }}>Yes</option>
                                                <option value="0" {{ $org->setting && !$org->setting->annual_bill_auto_payment ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 col-sm-12 mb-3">
                                            <label class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="force_direct_customer_billing" value="1"
                                                       {{ $org->setting?->force_direct_customer_billing ? 'checked' : '' }} disabled>
                                                <span class="form-check-label">Force Direct Customer billing</span>
                                            </label>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="form-label">Payment Terms</label>
                                            <div>
                                                @php
                                                    $selectedTerms = $org->paymentTerms->pluck('id')->toArray();
                                                @endphp
                                                @foreach($paymentTerms as $term)
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name="payment_terms[]" value="{{ $term->id }}"
                                                               {{ in_array($term->id, $selectedTerms) ? 'checked' : '' }} disabled>
                                                        <span class="form-check-label">{{ $term->name }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-3">
                                            <label class="form-label">Payment Terms Credit Limit</label>
                                            <input type="number" step="0.01" name="payment_terms_credit_limit"
                                                   value="{{ $org->setting?->payment_terms_credit_limit ?? '' }}" class="form-control" disabled>
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
                            $.each(response, function(key, state) {
                                $('#billing_state').append('<option value="'+ state.state_code +'">'+ state.name +'</option>');
                            });
                        }
                    });
                } else {
                    $('#billing_state').empty().append('<option value="">-None-</option>');
                }
            });

            $('#shipping_country').change(function(){
                let countryCode = $(this).val();
                if(countryCode) {
                    let url = '{{ route("getStates", ":countryCode") }}'.replace(':countryCode', countryCode);
                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            $('#shipping_state').empty().append('<option value="">-None-</option>');
                            $.each(response, function(key, state) {
                                $('#shipping_state').append('<option value="'+ state.state_code +'">'+ state.name +'</option>');
                            });
                        }
                    });
                } else {
                    $('#shipping_state').empty().append('<option value="">-None-</option>');
                }
            });

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
                    if (input.name !== 'extension_total' && input.name !== 'basic') { // Exclude readonly fields
                        input.disabled = false;
                    }
                });
                editBtn.classList.add('d-none');
                saveBtn.classList.remove('d-none');
                discardBtn.classList.remove('d-none');
            });

            saveBtn.addEventListener('click', function () {
                isEditing = false;
                /*inputs.forEach(input => {
                    input.disabled = true;
                });*/
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
                                discardBtn.classList.add('d-none');
                                window.location.href = link.href;
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
