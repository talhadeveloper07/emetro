@extends('layouts.admin')

@section('content')
    <style>
        .select2-container{
            width: 100% !important;
        }
    </style>
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        <a href="{{ route('e_admin.product_management.product.index') }}" id="goBack"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6"/></svg></a>
                        Edit Product
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    @if ($errors->any())
                        <div class="alert alert-danger w-100">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <div class="col-12">
                    <form action="{{ route('e_admin.product_management.product.update', $product->id) }}" method="POST" class="space-y-3" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Product Type Card -->
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Product Details</h5>
                                <div class="row g-3">
                                    <div class="col-12 col-md-3">
                                        <label for="product_code" class="form-label required">Product Code</label>
                                        <input type="text" name="product_code" id="product_code" class="form-control" value="{{ old('product_code', $product->product_code) }}" required>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label required">Name</label>
                                        <input type="text" name="title" class="form-control" value="{{ old('title', $product->title) }}" >
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label ">Description</label>
                                        <input type="text" name="description" class="form-control" value="{{ old('description', $product->description) }}" >
                                    </div>
                                    {{--<div class="col-12 col-md-4">
                                       <label class="form-label ">Short Name</label>
                                       <input type="text" name="small_title" class="form-control" value="{{ old('small_title',$product->small_title) }}" >
                                   </div>--}}
                                    <div class="col-12 col-md-4">
                                        <label for="product_type" class="form-label required">Product Type </label>
                                        <select name="product_type" id="product_type" class="form-select">
                                            <option value="">-- Select Product Type --</option>
                                            <option value="Hardware" {{ old('product_type', $product->product_type) == 'Hardware' ? 'selected' : '' }}>Hardware</option>
                                            <option value="Software" {{ old('product_type', $product->product_type) == 'Software' ? 'selected' : '' }}>Software</option>
                                            <option value="Service" {{ old('product_type', $product->product_type) == 'Service' ? 'selected' : '' }}>Services</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-4" id="product_subtype_section">
                                        <label for="product_sub_type" class="form-label required">Product Subtype</label>
                                        <select name="product_sub_type" id="product_sub_type" class="form-select" {{ old('product_type', $product->product_type) == 'Service' ? 'required' : '' }}>
                                            <option value="">-- Select Subtype --</option>
                                            @php
                                                $subtypes = getProductSubTypes();
                                                $selectedType = old('product_type', $product->product_type);
                                                $selectedSubtype = old('product_sub_type', $product->product_sub_type);
                                            @endphp

                                            @if(isset($subtypes[$selectedType]))
                                                @foreach($subtypes[$selectedType] as $type)
                                                    <option value="{{ $type }}" {{ $selectedSubtype == $type ? 'selected' : '' }}>
                                                        {{ ucfirst($type) }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    {{-- Product linking --}}
                                    <div class="col-12 col-md-4 d-none" id="link_product">
                                        <label  for="linked_product_id"  class="form-label ">Link to Product</label>
                                        <select name="linked_product_id" class="form-control select2 w-100"></select>
                                    </div>


                                    <div class="col-12 col-md-4">
                                        <div class="row">
                                            <div class="col">
                                                <label class="form-label ">Image</label>
                                            </div>
                                            <div class="col-auto" style="position: relative;">
                                                <span  id="imagePreview"  data-bs-toggle="modal" data-bs-target="#previewModal" class=" avatar avatar-1 imageProductPreview cursor-pointer" @if($product->image) style="background-image: url('{{ $product->image }}')" @else style="display: none;" @endif > </span>
                                            </div>
                                        </div>
                                        <input type="file" name="image" id="imageInput" class="form-control" accept=".png,.jpg,.jpeg">
                                    </div>



                                    <div class="col-12 col-md-4" >
                                        <label for="status" class="form-label required">Status</label>
                                        <select name="status" id="status" class="form-select" >
                                            <option value="">-- Select --</option>
                                            <option value="Active" {{ old('status',$product->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="Discontinue" {{ old('status',$product->status) == 'Discontinue' ? 'selected' : '' }}>Discontinue</option>
                                            <option value="Inprogress" {{ old('status',$product->status) == 'Inprogress' ? 'selected' : '' }}>Inprogress</option>
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label ">Additional Help Information</label>
                                        <textarea name="additional_information" class="form-control" rows="5">{{ old('additional_information',$product->additional_information) }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <div class="row d-none" id="hw_dimensions_section">
                                            <div class="col-12">
                                                <h5 class="card-title fw-bold">Measurements</h5>
                                            </div>

                                            {{-- Dimension Units Selector --}}
                                            <div class="col-md-3">
                                                <label for="dimension_unit">Dimension Unit</label>
                                                <select name="dimension_unit" id="dimension_unit" class="form-control">
                                                    <option value="cm" {{ old('dimension_unit', $product->dimension_unit ?? 'cm') === 'cm' ? 'selected' : '' }}>Centimeters (CM)</option>
                                                    <option value="in" {{ old('dimension_unit', $product->dimension_unit ?? '') === 'in' ? 'selected' : '' }}>Inches (IN)</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label for="dimension_length">Length</label>
                                                <input type="number" step="0.01" name="dimension_length" id="dimension_length" class="form-control" value="{{ old('dimension_length', $product->dimension_length ?? '') }}">
                                            </div>

                                            <div class="col-md-3">
                                                <label for="dimension_width">Width</label>
                                                <input type="number" step="0.01" name="dimension_width" id="dimension_width" class="form-control" value="{{ old('dimension_width', $product->dimension_width ?? '') }}">
                                            </div>

                                            <div class="col-md-3">
                                                <label for="dimension_height">Height</label>
                                                <input type="number" step="0.01" name="dimension_height" id="dimension_height" class="form-control" value="{{ old('dimension_height', $product->dimension_height ?? '') }}">
                                            </div>

                                            {{-- Weight Unit Selector --}}
                                            <div class="col-md-3 mt-3">
                                                <label for="weight_unit">Weight Unit</label>
                                                <select name="weight_unit" id="weight_unit" class="form-control">
                                                    <option value="lb" {{ old('weight_unit', $product->weight_unit ?? 'lb') === 'lb' ? 'selected' : '' }}>Pounds (LB)</option>
                                                    <option value="kg" {{ old('weight_unit', $product->weight_unit ?? '') === 'kg' ? 'selected' : '' }}>Kilograms (KG)</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3 mt-3">
                                                <label for="net_weight">Net Weight</label>
                                                <input type="number" step="0.01" name="net_weight" id="net_weight" class="form-control" value="{{ old('net_weight', $product->net_weight ?? '') }}">
                                            </div>

                                            <div class="col-md-3 mt-3">
                                                <label for="gross_weight">Gross Weight</label>
                                                <input type="number" step="0.01" name="gross_weight" id="gross_weight" class="form-control" value="{{ old('gross_weight', $product->gross_weight ?? '') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Quote & Invoice Sort Order</h5>
                                <div class="col-12 col-md-4">
                                    <label class="form-label required">Sort Order</label>
                                    <input type="number" step=".01" name="sort_order" class="form-control" value="{{ old('sort_order', $product->sort_order) }}" required>
                                </div>
                            </div>
                        </div>
                        <!-- Product Price Card -->
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Product Price</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Region</th>
                                            <th>Price</th>
                                            <th>Product Availability</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($priceRegions as $priceRegion)
                                            @php
                                                $price = $product->productPrices->where('price_region_id', $priceRegion->id)->first();
                                            @endphp
                                            <tr>
                                                <td>{{ $priceRegion->name }}</td>
                                                <td>
                                                    <input type="number" step="0.01"
                                                           name="product_prices[{{ $priceRegion->id }}][price]"
                                                           id="product_price_{{ $priceRegion->id }}"
                                                           class="form-control"
                                                           value="{{ old('product_prices.' . $priceRegion->id . '.price', $price ? $price->price : '') }}">
                                                </td>
                                                <td>
                                                    <input type="date"
                                                           name="product_prices[{{ $priceRegion->id }}][availability]"
                                                           id="product_availability_{{ $priceRegion->id }}"
                                                           class="form-control"
                                                           value="{{ old('product_prices.' . $priceRegion->id . '.availability', $price ? $price->availability : '') }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- SW Subscription and HW Warranty Card -->
                        <div class="card" id="sw_hw_card" class="{{ !old('product_type', $product->product_type) || old('product_type', $product->product_type) == 'Service' ? 'd-none' : '' }}">
                            <div class="card-body">
                                <h5 class="card-title fw-bold" id="sw_hw_title">
                                    Warranty
{{--                                    {{ old('product_type', $product->product_type) == 'Software' ? 'SW Subscription' : (old('product_type', $product->product_type) == 'Hardware' ? 'HW Warranty' : 'SW Subscription and HW Warranty') }}--}}
                                </h5>
                                <div class="row g-3">
                                    <div class="col-md-12 {{ old('product_type', $product->product_type) == 'Software' ? '' : 'd-none' }}" id="sw_subscription_year">
{{--                                        <label for="sw_subscription_per_year_p" class="form-label">SW Subscription, per Year</label>--}}
{{--                                        <input type="text" name="sw_subscription_per_year_p" id="sw_subscription_per_year_p" class="form-control" value="{{ old('sw_subscription_per_year_p', $product->sw_subscription_per_year_p) }}">--}}
                                        @if ($product->linkedServices && $product->linkedServices->count())
                                            <div class="table-responsive">
                                                <table class="table mb-0">
                                                    <thead>
                                                    <tr>
                                                        <th>Code</th>
                                                        <th>Subtype</th>
                                                        <th class="w-1">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($product->linkedServices as $service)
                                                        <tr>
                                                            <td>{{ $service->product_code }}</td>
                                                            <td>{{ ucfirst($service->product_sub_type) }}</td>
                                                            <td>
                                                                <a href="{{ route('e_admin.product_management.product.edit', $service->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                                {{-- Optionally Add Delete/Unlink --}}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <p><b>Note:</b> For software subscription, you must create a dedicated Software Subscription Code and associate it with the corresponding product.</p>
                                        @endif

                                    </div>
                                    {{--<div class="col-md-6 {{ old('product_type', $product->product_type) == 'Software' ? '' : 'd-none' }}" id="sw_subscription_month">
                                        <label for="sw_subscription_per_month_p" class="form-label">SW Subscription, per Month</label>
                                        <input type="text"  name="sw_subscription_per_month_p" id="sw_subscription_per_month_p" class="form-control" value="{{ old('sw_subscription_per_month_p', $product->sw_subscription_per_month_p) }}">
                                    </div>--}}
                                    <div class="col-md-12 {{ old('product_type', $product->product_type) == 'Hardware' ? '' : 'd-none' }}" id="hw_warranty_year">
{{--                                        <label for="hw_warranty_per_year_price" class="form-label">HW Warranty, per Year</label>--}}
{{--                                        <input type="text"  name="hw_warranty_per_year_price" id="hw_warranty_per_year_price" class="form-control" value="{{ old('hw_warranty_per_year_price', $product->hw_warranty_per_year_price) }}">--}}
                                        @if ($product->linkedServices && $product->linkedServices->count())
                                            <div class="table-responsive">
                                                <table class="table mb-0">
                                                    <thead>
                                                    <tr>
                                                        <th>Code</th>
                                                        <th>Subtype</th>
                                                        <th class="w-1">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($product->linkedServices as $service)
                                                        <tr>
                                                            <td>{{ $service->product_code }}</td>
                                                            <td>{{ ucfirst($service->product_sub_type) }}</td>
                                                            <td>
                                                                <a href="{{ route('e_admin.product_management.product.edit', $service->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                                {{-- Optionally Add Delete/Unlink --}}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                        <p><b>Note:</b> For hardware warranty, you must create a dedicated Hardware Warranty Code and associate it with the corresponding hardware product.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Service Included Card -->
                        {{--<div class="card">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Assurance Renewal</h5>
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <label class="form-label ">Is it included in Assurance Renewal?</label>
                                        <select name="assurance_renewal" id="assurance_renewal" class="form-select">
                                            <option value="">-- None --</option>
                                            <option value="yes" {{ old('assurance_renewal', $product->assurance_renewal) == 'yes' ? 'selected' : '' }}>Yes</option>
                                            <option value="no" {{ old('assurance_renewal', $product->assurance_renewal) == 'no' ? 'selected' : '' }}>No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>--}}

                        <!-- Volume Based Discount Card -->
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Discount</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="discount_category_id" class="form-label">Discount Category</label>
                                        <select name="discount_category_id" id="discount_category_id" class="form-select">
                                            <option value="">-- None --</option>
                                            @foreach($discounts as $discount)
                                                <option value="{{ $discount->id }}" {{ old('discount_category_id', $product->discount_category_id) == $discount->id ? 'selected' : '' }}>{{ $discount->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Vendor Card -->
                        {{--<div class="card">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Vendor</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="vendor_id" class="form-label">Vendor</label>
                                        <select name="vendor_id" id="vendor_id" class="form-select">
                                            <option value="">-- None --</option>
                                            @foreach($vendors as $vendor)
                                                <option value="{{ $vendor->id }}" {{ old('vendor_id', $product->vendor_id) == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>--}}

                        <!-- Inventory Card -->
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Inventory</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="inventory_location" class="form-label">Inventory Location</label>
                                        <input type="text" name="inventory_location" id="inventory_location" class="form-control" value="{{ old('inventory_location', $product->inventory_location) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inventory_count" class="form-label">Inventory Count</label>
                                        <input type="number" name="inventory_count" id="inventory_count" class="form-control" value="{{ old('inventory_count', $product->inventory_count) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- BOM (Bill of Materials) Card -->
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">BOM</h5>
                                <div id="bom-container">
                                    @foreach($product->boms as $index => $bom)
                                        <div class="row g-3 bom-row mb-3" data-index="{{ $index }}">
                                            <div class="col-md-3">
                                                <label for="bom[{{ $index }}][name]" class="form-label ">Name</label>
                                                <input type="text" name="bom[{{ $index }}][name]" id="bom_{{ $index }}_name" class="form-control" value="{{ old('bom.' . $index . '.name', $bom->name) }}">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="bom[{{ $index }}][cost]" class="form-label ">Cost</label>
                                                <input type="number" min="0" step="0.01" name="bom[{{ $index }}][cost]" id="bom_{{ $index }}_cost" class="form-control" value="{{ old('bom.' . $index . '.cost', $bom->cost) }}">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="bom[{{ $index }}][tariff]" class="form-label">Tariff (%)</label>
                                                <input type="number" min="0" step="0.01" name="bom[{{ $index }}][tariff]" id="bom_{{ $index }}_tariff" class="form-control" value="{{ old('bom.' . $index . '.tariff', $bom->tariff) }}">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="bom[{{ $index }}][shipping]" class="form-label">Shipping</label>
                                                <input type="number" min="0" step="0.01" name="bom[{{ $index }}][shipping]" id="bom_{{ $index }}_shipping" class="form-control" value="{{ old('bom.' . $index . '.shipping', $bom->shipping) }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="bom[{{ $index }}][vendor]" class="form-label">Manufacturer</label>
                                                <select name="bom[{{ $index }}][vendor]" id="bom_{{ $index }}_vendor" class="form-select">
                                                    <option value="">-- None --</option>
                                                    @foreach($vendors as $vendor)
                                                        <option value="{{ $vendor->name }}" {{ old('bom.' . $index . '.vendor', $bom->vendor) == $vendor->name ? 'selected' : '' }}>
                                                            {{ $vendor->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label for="bom[{{ $index }}][hts]" class="form-label">HTS</label>
                                                <input type="text" name="bom[{{ $index }}][hts]" id="bom_{{ $index }}_hts" class="form-control" value="{{ old('bom.' . $index . '.hts', $bom->hts) }}">
                                            </div>

                                            <div class="col-md-3">
                                                <label for="bom[{{ $index }}][eccn]" class="form-label">ECCN</label>
                                                <input type="text" name="bom[{{ $index }}][eccn]" id="bom_{{ $index }}_eccn" class="form-control" value="{{ old('bom.' . $index . '.eccn', $bom->eccn) }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="bom[{{ $index }}][total]" class="form-label">Total</label>
                                                <input type="number" step="0.01" name="bom[{{ $index }}][total]" id="bom_{{ $index }}_total" class="form-control" value="{{ old('bom.' . $index . '.total', $bom->total) }}" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">&nbsp;</label>
                                                <button type="button" class="btn btn-danger delete-bom-row" data-index="{{ $index }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash m-0"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" id="add-bom-row" class="btn btn-sm btn-secondary mt-2">+ Add Row</button>
                                <div class="mt-3">
                                    <div>
                                        <strong>Total Cost: </strong><span id="total-cost">0.00</span>
                                    </div>
                                    <div>
                                        <strong>Total Tariff: </strong><span id="total-tariff">0.00</span>
                                    </div>
                                    <div>
                                        <strong>Total Shipping: </strong><span id="total-shipping">0.00</span>
                                    </div>
                                    <div>
                                        <strong>Overall Total: </strong><span id="overall-total">0.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Shipping Card -->
                        {{--<div class="card">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Shipping Cost</h5>
                                <div class="col-md-6">
                                    <label for="shipping_cost" class="form-label">Price</label>
                                    <input type="number" step="0.01" name="shipping_cost" id="shipping_cost" class="form-control" value="{{ old('shipping_cost', $product->shipping_cost) }}">
                                </div>
                            </div>
                        </div>

                        <!-- Product Unit Cost Card -->
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Product Unit Cost</h5>
                                <div class="col-md-6">
                                    <label for="product_unit_cost" class="form-label">Price</label>
                                    <input type="number" step="0.01" name="product_unit_cost" id="product_unit_cost" class="form-control" value="{{ old('product_unit_cost', $product->product_unit_cost) }}">
                                </div>
                            </div>
                        </div>--}}

                        <!-- Form Actions -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('e_admin.product_management.product.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="previewModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <img id="previewImage" src="{{ $product->image }}" alt="{{ $product->product_code }}" style="width: 100%;height: auto;">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Cancel
                        </a>
                    </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        const productSubTypes = @json(getProductSubTypes());
        const currentType = "{{ old('product_type', $product->product_type) }}";
        let currentSubtype = "{{ old('product_sub_type', $product->product_sub_type) }}";
        const currentLinkedProductId = "{{ old('linked_product_id', $product->linked_product_id) }}";

        $(document).ready(function() {
            const $productType = $('#product_type');
            const $productSubtypeSection = $('#product_subtype_section');
            const $productSubtype = $('#product_sub_type');
            const $swHwCard = $('#sw_hw_card');
            const $swHwTitle = $('#sw_hw_title');
            const $swSubscriptionYear = $('#sw_subscription_year');
            const $swSubscriptionMonth = $('#sw_subscription_month');
            const $hwWarrantyYear = $('#hw_warranty_year');
            const $linkProduct = $('#link_product'); // Will be used as the only dropdown
            const $linkProductSelect = $linkProduct.find('select');
            const $hwDimensionsSection = $('#hw_dimensions_section'); // Add this line near your other DOM selectors


            const $bomContainer = $('#bom-container');
            const $totalCost = $('#total-cost');
            const $totalTariff = $('#total-tariff');
            const $totalShipping = $('#total-shipping');
            const $overallTotal = $('#overall-total');
            let bomIndex = {{ $product->boms->count() - 1 }} || 0;
            function updateRowTotal($row) {
                const index = $row.data('index');
                const cost = parseFloat($row.find(`#bom_${index}_cost`).val()) || 0;
                const tariffPercent = parseFloat($row.find(`#bom_${index}_tariff`).val()) || 0;
                const shipping = parseFloat($row.find(`#bom_${index}_shipping`).val()) || 0;
                const tariff = (cost * tariffPercent) / 100;
                const total = cost + tariff + shipping;
                $row.find(`#bom_${index}_total`).val(total.toFixed(2));
                updateOverallTotal();
            }

            function updateOverallTotal() {
                let totalCost = 0;
                let totalTariff = 0;
                let totalShipping = 0;
                let overallTotal = 0;
                $('.bom-row').each(function() {
                    const index = $(this).data('index');
                    const cost = parseFloat($(this).find(`#bom_${index}_cost`).val()) || 0;
                    const tariffPercent = parseFloat($(this).find(`#bom_${index}_tariff`).val()) || 0;
                    const shipping = parseFloat($(this).find(`#bom_${index}_shipping`).val()) || 0;
                    const tariff = (cost * tariffPercent) / 100;
                    const total = cost + tariff + shipping;
                    totalCost += cost;
                    totalTariff += tariff;
                    totalShipping += shipping;
                    overallTotal += total;
                });
                $totalCost.text(totalCost.toFixed(2));
                $totalTariff.text(totalTariff.toFixed(2));
                $totalShipping.text(totalShipping.toFixed(2));
                $overallTotal.text(overallTotal.toFixed(2));
            }
            function populateSubtypes(type) {
                const selectedVal = $productSubtype.val() || currentSubtype;
                $productSubtype.empty().append('<option value="">-- Select Subtype --</option>');

                if (productSubTypes[type]) {
                    productSubTypes[type].forEach(sub => {
                        const selected = selectedVal === sub ? 'selected' : '';
                        $productSubtype.append(`<option value="${sub}" ${selected}>${sub.charAt(0).toUpperCase() + sub.slice(1)}</option>`);
                    });
                }
            }
            function toggleFields() {
                // Handle Product Subtype visibility and requirement
                const type = $productType.val();
                const subtype = $productSubtype.val() || currentSubtype;

                // Product Subtype visibility
                if (productSubTypes[type] && productSubTypes[type].length > 0) {
                    $productSubtypeSection.removeClass('d-none');
                    $productSubtype.prop('required', true);
                    populateSubtypes(type);
                } else {
                    $productSubtypeSection.addClass('d-none');
                    $productSubtype.prop('required', false).val('');
                }


                // Handle SW Subscription and HW Warranty Card
                if (!$productType.val() || $productType.val() === 'Service') {
                    $swHwCard.addClass('d-none');
                    $hwDimensionsSection.addClass('d-none');
                } else {
                    $swHwCard.removeClass('d-none');
                    if ($productType.val() === 'Software') {
                        $swHwTitle.text('SW Subscription');
                        $swSubscriptionYear.removeClass('d-none');
                        $swSubscriptionMonth.removeClass('d-none');
                        $hwWarrantyYear.addClass('d-none');
                        $hwDimensionsSection.addClass('d-none');
                    } else if ($productType.val() === 'Hardware') {
                        $swHwTitle.text('HW Warranty');
                        $swSubscriptionYear.addClass('d-none');
                        $swSubscriptionMonth.addClass('d-none');
                        $hwWarrantyYear.removeClass('d-none');
                        $hwDimensionsSection.removeClass('d-none');
                    }
                }

                // Handle Linkable Products
                $linkProduct.addClass('d-none');
                $linkProductSelect.empty();

                if (type === 'Service') {
                    let targetType = null;

                    if (subtype && subtype.startsWith('hardware')) targetType = 'Hardware';
                    else if (subtype && subtype.startsWith('software')) targetType = 'Software';

                    if (targetType) {
                        $.ajax({
                            url: "{{ route('e_admin.product_management.product.linkable') }}",
                            method: 'GET',
                            data: {
                                subtype: subtype,
                                current_linked_product_id: currentLinkedProductId
                            },
                            success: function (products) {
                                if (products.length > 0) {
                                    $linkProductSelect.append('<option value="">-- Select Product --</option>');
                                    products.forEach(p => {
                                        const selected = currentLinkedProductId == p.id ? 'selected' : '';
                                        $linkProductSelect.append(`<option value="${p.id}" ${selected}>${p.product_code}</option>`);
                                    });
                                    $linkProduct.removeClass('d-none');
                                }
                            },
                            error: function () {
                                console.error('Failed to load linkable products.');
                            }
                        });
                    }
                }
            }

            $('#add-bom-row').on('click', function() {
                bomIndex++;
                const newRow = `
                    <div class="row g-3 bom-row mb-3" data-index="${bomIndex}">
                        <div class="col-md-3">
                            <label for="bom[${bomIndex}][name]" class="form-label ">Name</label>
                            <input type="text" name="bom[${bomIndex}][name]" id="bom_${bomIndex}_name" class="form-control" value="{{ old('bom.${bomIndex}.name') }}" >
                        </div>
                        <div class="col-md-2">
                            <label for="bom[${bomIndex}][cost]" class="form-label ">Cost</label>
                            <input type="number" min="0" step="0.01" name="bom[${bomIndex}][cost]" id="bom_${bomIndex}_cost" class="form-control" value="{{ old('bom.${bomIndex}.cost') }}" >
                        </div>
                        <div class="col-md-2">
                            <label for="bom[${bomIndex}][tariff]" class="form-label">Tariff (%)</label>
                            <input type="number" min="0" step="0.01" name="bom[${bomIndex}][tariff]" id="bom_${bomIndex}_tariff" class="form-control" value="{{ old('bom.${bomIndex}.tariff') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="bom[${bomIndex}][shipping]" class="form-label">Shipping</label>
                            <input type="number" min="0" step="0.01" name="bom[${bomIndex}][shipping]" id="bom_${bomIndex}_shipping" class="form-control" value="{{ old('bom.${bomIndex}.shipping') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="bom[${bomIndex}][vendor]" class="form-label">Manufacturer</label>
                            <select name="bom[${bomIndex}][vendor]" id="bom_${bomIndex}_vendor" class="form-select">
                                <option value="">-- None --</option>
                                @foreach($vendors as $vendor)
                                    <option value="{{ $vendor->name }}" {{ old('bom.${bomIndex}.vendor') == $vendor->name ? 'selected' : '' }}>{{ $vendor->name }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-md-3">
                            <label for="bom[${bomIndex}][hts]" class="form-label">HTS</label>
                            <input type="text" name="bom[${bomIndex}][hts]" id="bom_${bomIndex}_hts" class="form-control" value="{{ old('bom.${bomIndex}.hts') }}">
                        </div>

                        <div class="col-md-3">
                            <label for="bom[${bomIndex}][eccn]" class="form-label">ECCN</label>
                            <input type="text" name="bom[${bomIndex}][eccn]" id="bom_${bomIndex}_eccn" class="form-control" value="{{ old('bom.${bomIndex}.eccn') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="bom[${bomIndex}][total]" class="form-label">Total</label>
                            <input type="number" step="0.01" name="bom[${bomIndex}][total]" id="bom_${bomIndex}_total" class="form-control" value="{{ old('bom.${bomIndex}.total') }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <button type="button" class="btn btn-danger delete-bom-row" data-index="${bomIndex}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash m-0"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                            </button>
                        </div>
                    </div>
                `;
                $bomContainer.append(newRow);
                updateRowTotal($('.bom-row').last());
            });

            $bomContainer.on('click', '.delete-bom-row', function() {
                if ($('.bom-row').length > 1) {
                    $(this).closest('.bom-row').remove();
                    updateOverallTotal();
                }
            });

            $bomContainer.on('input', '.bom-row :input', function() {
                const $row = $(this).closest('.bom-row');
                updateRowTotal($row);
            });

            $productType.on('change', function () {
                currentSubtype = ''; // reset currentSubtype when type is changed
                toggleFields();
            });
            $productSubtype.on('change', toggleFields);

            toggleFields();
            updateOverallTotal();
            function previewImage(event) {
                const file = event.target.files[0];
                const preview = document.getElementById('imagePreview');
                const previewImage = document.getElementById('previewImage');

                if (!file) {
                    preview.style.display = 'none';
                    previewImage.src = '{{$product->image}}';
                    preview.style.backgroundImage = url('{{$product->image}}');
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.style.display = 'block';
                    preview.style.backgroundImage = `url('${e.target.result}')`;
                    previewImage.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }

            document.getElementById('imageInput').addEventListener('change', previewImage);
        });
    </script>
@endsection
