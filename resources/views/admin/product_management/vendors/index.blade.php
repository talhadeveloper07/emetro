@extends('layouts.admin')

@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        <a href="{{route('e_admin.product_management.index')}}"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg></a>
                        Vendors
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="javascript:void(0)" class="btn btn-primary  d-inline-block" data-bs-toggle="modal" data-bs-target="#addModal">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                            Create New
                        </a>

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
                        <div class="card-body overflow-hidden">
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th>Country</th>
                                            <th>Payment detail</th>
                                            <th>Currency</th>
                                            <th>Point of contact</th>
                                            <th class="w-1">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($vendors as $vendor)
                                        <tr>
                                            <td>{{ $vendor->name }}</td>
                                            <td><span class="text-wrap">{{ $vendor->address }}</span></td>
                                            <td>{{ $vendor->country?getCountryByCode($vendor->country):"" }}</td>
                                            <td><span class="text-wrap">{{ $vendor->payment_detail }}</span></td>
                                            <td>{{ $vendor->currency?getCurrencyByCode($vendor->currency):"" }}</td>
                                            <td><span class="text-wrap">{{ $vendor->point_of_contact }}</span></td>
                                            <td>
                                                <div class="btn-list flex-nowrap">
                                                    <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updateModal-{{$vendor->id}}">Edit</a>

                                                    <form action="{{ route('e_admin.product_management.vendors.delete', $vendor->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger delete-btn">Delete</button>
                                                    </form>
                                                </div>
                                                <div class="modal modal-blur fade" id="updateModal-{{$vendor->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Update Vendor</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form id="payment-form" method="post" action="{{route('e_admin.product_management.vendors.update',$vendor->id)}}">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">

                                                                            <div class="mb-3">
                                                                                <label class="form-label required">Name</label>
                                                                                <input type="text" class="form-control" name="name" value="{{ $vendor->name }}" placeholder="Enter Name" required>
                                                                                @error('name', 'updateData')
                                                                                <span class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label ">Address</label>
                                                                                <input type="text" class="form-control" name="address" value="{{ $vendor->address }}" placeholder="Enter Address" >
                                                                                @error('address', 'updateData')
                                                                                <span class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label class="form-label ">Country</label>
                                                                                <select name="country" class="form-control select2-modal-{{$vendor->id}} country">
                                                                                    <option value="" selected disabled>(Select)</option>
                                                                                    @foreach(getAllCounties() as $country)
                                                                                        <option value="{{$country['iso2']}}" {{ $country['iso2']==$vendor->country?"selected":"" }}>{{$country['name']}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                @error('country', 'updateData')
                                                                                <span class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label ">Payment detail</label>
                                                                                <input type="text" class="form-control" name="payment_detail" value="{{ $vendor->payment_detail }}" placeholder="Enter Payment detail" >
                                                                                @error('payment_detail', 'updateData')
                                                                                <span class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label ">Currency</label>
                                                                                <select name="currency" class="form-control  currency">
                                                                                    <option value="" selected disabled>(Select)</option>
                                                                                    @if($vendor->country)
                                                                                        @foreach(getCountryCurrency($vendor->country) as $currency)
                                                                                            <option value="{{$currency['code']}}" {{ $currency['code']==$vendor->currency?"selected":"" }}>{{$currency['name']}}</option>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </select>
                                                                                @error('currency', 'updateData')
                                                                                <span class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label class="form-label ">Point of contact</label>
                                                                                <input type="text" class="form-control" name="point_of_contact" value="{{ $vendor->point_of_contact }}" placeholder="" >
                                                                                @error('point_of_contact', 'updateData')
                                                                                <span class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                                                                        Cancel
                                                                    </a>
                                                                    <button type="submit" id="submitPayment" class="btn btn-primary ms-auto">
                                                                        Submit
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

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
                        </div>
                        <div class="card-footer d-flex align-items-center">
                            {{$vendors->links()}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal modal-blur fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Vendor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="payment-form" method="post" action="{{route('e_admin.product_management.vendors.store')}}">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">

                                    <div class="mb-3">
                                        <label class="form-label required">Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Enter Name" required>
                                        @error('name', 'createData')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label ">Address</label>
                                        <input type="text" class="form-control" name="address" value="{{ old('address') }}" placeholder="Enter Address" >
                                        @error('address', 'createData')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label ">Country</label>
                                        <select name="country" class="form-control select2-modal country">
                                            <option value="" selected disabled>(Select)</option>
                                            @foreach(getAllCounties() as $country)
                                                <option value="{{$country['iso2']}}" {{ $country['iso2']==old('country')?"selected":"" }}>{{$country['name']}}</option>
                                            @endforeach
                                        </select>
                                        @error('country', 'createData')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label ">Payment detail</label>
                                        <input type="text" class="form-control" name="payment_detail" value="{{ old('payment_detail') }}" placeholder="Enter Payment detail" >
                                        @error('payment_detail', 'createData')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label ">Currency</label>
                                        <select name="currency" class="form-control  currency">
                                            <option value="" selected disabled>(Select)</option>
                                        </select>
                                        @error('currency', 'createData')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label ">Point of contact</label>
                                        <input type="text" class="form-control" name="point_of_contact" value="{{ old('point_of_contact') }}" placeholder="" >
                                        @error('point_of_contact', 'createData')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                                Cancel
                            </a>
                            <button type="submit" id="submitPayment" class="btn btn-primary ms-auto">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>

@endsection

@section('scripts')
    <script>
        $('#addModal').on('shown.bs.modal', function () {
            $('.select2-modal').select2({
                dropdownParent: $('#addModal') // Attach dropdown to the modal
            });
        });
        // Destroy Select2 when the modal is hidden to avoid duplication issues
        $('#addModal').on('hidden.bs.modal', function () {
            $('.select2-modal').select2('destroy');
        });



        @foreach ($vendors as $vendor)
        $('#updateModal-{{$vendor->id}}').on('shown.bs.modal', function () {
            $('.select2-modal-{{$vendor->id}}').select2({
                dropdownParent: $('#updateModal-{{$vendor->id}}') // Attach dropdown to the modal
            });
        });
        // Destroy Select2 when the modal is hidden to avoid duplication issues
        $('#updateModal-{{$vendor->id}}').on('hidden.bs.modal', function () {
            $('.select2-modal-{{$vendor->id}}').select2('destroy');
        });
        @endforeach

        $('.country').on('change', function() {
            var countryCode = $(this).val();
            var currencySelect = $(this).closest('.modal-body').find('.currency');

            let url = '{{ route("getCurrencies", ":countryCode") }}'.replace(':countryCode', countryCode);

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(currencies) {
                    currencySelect.empty().append('<option value="">(Select)</option>');
                    $.each(currencies, function(key, currency) {
                        currencySelect.append('<option value="' + currency.code + '">' + currency.name + '</option>');
                    });
                },
                error: function() {
                    currencySelect.empty().append('<option value="">(Select)</option>');
                    console.error('Failed to load currencies.');
                }
            });
        });

    </script>
    @if (session('open_modal') === 'create')
        <script>
            $(document).ready(function () {
                $('#addModal').modal('show');
            });
        </script>
    @endif
    @if (Str::startsWith(session('open_modal'), 'update'))
        <script>
            $(document).ready(function () {
                const id = '{{ str_replace("update-", "", session("open_modal")) }}';
                $('#updateModal-' + id).modal('show');
            });
        </script>
    @endif
@endsection
