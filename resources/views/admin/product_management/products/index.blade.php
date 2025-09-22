@extends('layouts.admin')

@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        <a href="{{route('e_admin.product_management.index')}}"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg></a>
                        Products
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{route('e_admin.product_management.product.create')}}" class="btn btn-primary  d-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                            Create Product
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
                        <form action="{{route('e_admin.product_management.product.index')}}" id="productFilterForm" method="get">
                            <div class="card-body">
                                <div class="row row-cards">
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Product Code</label>
                                            <input type="text" name="product_code" class="form-control" value="{{isset($request) && $request->product_code ?$request->product_code:""}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Product Name</label>
                                            <input type="text" name="title" class="form-control" value="{{isset($request) && $request->title ?$request->title :""}}">
                                        </div>
                                    </div>


                                    <div class="col-sm-6 col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Product Type</label>
                                            <select id="product_type" name="product_type"
                                                    class="form-control form-select select2">
                                                <option value="" selected="selected">(Select)</option>
                                                <option value="Hardware" {{ isset($request) && $request->product_type == 'Hardware' ? 'selected' : '' }}>Hardware</option>
                                                <option value="Software" {{ isset($request) && $request->product_type == 'Software' ? 'selected' : '' }}>Software</option>
                                                <option value="Service" {{ isset($request) && $request->product_type == 'Service' ? 'selected' : '' }}>Services</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Product Sub Type</label>
                                            <select id="product_sub_type" name="product_sub_type"
                                                    class="form-control form-select select2">
                                                <option value="" selected="selected">(Select)</option>
                                                <option value="monthly" {{ isset($request) && $request->product_sub_type == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                                <option value="annual" {{ isset($request) && $request->product_sub_type == 'annual' ? 'selected' : '' }}>Annual</option>
                                                <option value="one time" {{ isset($request) && $request->product_sub_type == 'one time' ? 'selected' : '' }}>One Time</option>

                                            </select>
                                        </div>
                                    </div>
                                    {{--<div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Vendor</label>
                                            <select  name="vendor_id"
                                                     class="form-control form-select select2" >
                                                <option value="" selected="selected">(Select)</option>
                                                @foreach($vendors as $vendor)
                                                    <option value="{{ $vendor->id }}" {{ isset($request) && $request->vendor_id == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Discount Category</label>
                                            <select  name="discount_category_id"
                                                     class="form-control form-select select2" >
                                                <option value="" selected="selected">(Select)</option>
                                                    @foreach($discounts as $discount)
                                                        <option value="{{ $discount->id }}" {{ isset($request) && $request->discount_category_id == $discount->id ? 'selected' : '' }}>{{ $discount->name }}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>--}}
                                    <div class="col-sm-6 col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select  name="status"
                                                     class="form-control form-select select2" >
                                                <option value="" selected="selected">All</option>
                                                <option value="Active" {{ isset($request) && $request->status == 'Active' ? 'selected' : '' }}>Active</option>
                                                <option value="Discontinue" {{ isset($request) && $request->status == 'Discontinue' ? 'selected' : '' }}>Discontinue</option>
                                                <option value="Inprogress" {{ isset($request) && $request->status == 'Inprogress' ? 'selected' : '' }}>Inprogress</option>

                                            </select>
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
                                            <a href="{{route('e_admin.product_management.product.index')}}" class="btn btn-secondary">Clear Filter</a>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body overflow-hidden">
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table">
                                    <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Sub Type</th>
                                        <th>Status</th>
                                        <th class="w-1">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($products as $product)
                                        <tr>
                                            <td>

                                                <div class="row">
                                                    <div class="col-auto">
                                                        <span class="avatar avatar-1" style="background-image: url({{$product->image}})"> </span>
                                                    </div>
                                                    <div class="col">
                                                        {{$product->product_code}}
                                                    </div>

                                                </div>
                                            </td>
                                            <td>{{$product->title}}</td>
                                            <td>{{$product->product_type}}</td>
                                            <td>{{$product->product_sub_type}}</td>
                                            <td>{{$product->status}}</td>

                                            <td>
                                                <a href="{{route('e_admin.product_management.product.edit',$product->id)}}" class="btn btn-sm btn-primary">Edit</a>
                                                <form action="{{ route('e_admin.product_management.product.delete', $product->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger delete-btn">Delete</button>
                                                </form>
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
                            {{$products->links()}}
                        </div>
                    </div>

                </div>
                <div class="col-12">
                    <div class="col-auto ms-auto d-print-none">
                        <select class="form-control form-select d-inline-block w-auto ms-2" name="download_format" id="download_format">
                            <option value="">Select Download Format</option>
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                        </select>
                        <button type="button" class="btn btn-secondary ms-2 downloadData">Download</button>
                    </div>
                </div>

            </div>
        </div>


    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $(".downloadData").click(function () {
                const format = document.getElementById('download_format').value;
                if (!format) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Please select a download format.',
                    });
                    return;
                }
                const form = document.getElementById('productFilterForm');
                // Create hidden input for format
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'download_format';
                hiddenInput.value = format;
                hiddenInput.id = 'hidden_download_format';
                form.appendChild(hiddenInput);

                const originalAction = form.action;
                form.action = '{{ route("e_admin.product_management.product.download") }}';
                form.submit();
                setTimeout(() => {
                    form.action = originalAction;
                    hiddenInput.remove();
                }, 100);
            });
            if (window.location.search) {
                window.history.replaceState(null, "", window.location.pathname);
            }
        });

    </script>
@endsection

