@extends('layouts.admin')

@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Registration
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="#" class="btn btn-primary"> Child Serial Number Hardware Upload</a>

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
                            <form action="{{route('registration.index')}}" method="get">
                                <div class="card-body">
                                    <div class="row row-cards">

                                        <div class="col-sm-6 col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">Organization</label>
                                                <select id="organization" name="org_id"
                                                        class="form-control mb-3 select2">
                                                    <option value="">All</option>
                                                    <option value="1421">E-MetroTel (Italy)</option>
                                                    <option value="485">E-MetroTel Americas</option>
                                                    <option value="1995">E-MetroTel Australia</option>
                                                    <option value="868">E-MetroTel Canada</option>
                                                    <option value="1036">E-MetroTel Design</option>
                                                    <option value="1173">E-MetroTel Direct</option>
                                                    <option value="1269">E-MetroTel Guest (Canada)</option>
                                                    <option value="1635">E-MetroTel POC</option>
                                                    <option value="1181">E-MetroTel Test (US)</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">Product Code</label>
                                                <input type="text" name="product_code" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label"> Serial Number</label>
                                                <input type="text" name="serial_number" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">PO #</label>
                                                <input type="text" name="po_number" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">Customer Name</label>
                                                <input type="text" name="customer_name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-2  text-end">
                                            <label class="form-label">&nbsp;</label>
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            @php
                                                $hasFilters = collect(request()->except('_token'))->filter()->isNotEmpty();
                                            @endphp

                                            @if($hasFilters)
                                                <a href="{{ route('registration.index') }}" class="btn btn-secondary">Clear Filter</a>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Unregistered Software</h3>
                        </div>
                        <div class="table-responsive table-scrollable">
                            <table class="table table-selectable card-table table-vcenter text-nowrap datatable">
                                <thead>
                                <tr>
                                    <th class="w-1"><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></th>
                                    <th>Serial Number</th>
                                    <th>Code</th>
                                    <th>PO #</th>
                                    <th class="w-1">Customer Name</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox" aria-label="Select invoice"></td>
                                    <td ><a href="#">2504058165</a>
                                    </td>
                                    <td>SXEXPN-MINI</td>
                                    <td></td>
                                    <td>Shabeer P</td>
                                </tr>
                                <tr>
                                    <td><input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox" aria-label="Select invoice"></td>
                                    <td><a href="#">2504058148</a></td>
                                    <td>SXUCCN-BLK</td>
                                    <td></td>
                                    <td>Feb. 18, Pick list</td>
                                </tr>
                                <tr>
                                    <td><input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox" aria-label="Select invoice"></td>
                                    <td><a href="#">2504058148</a></td>
                                    <td>SXUCCN-BLK</td>
                                    <td></td>
                                    <td>Feb. 18, Pick list</td>
                                </tr>
                                <tr>
                                    <td><input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox" aria-label="Select invoice"></td>
                                    <td><a href="#">2504058148</a></td>
                                    <td>SXUCCN-BLK</td>
                                    <td></td>
                                    <td>Feb. 18, Pick list</td>
                                </tr>
                                <tr>
                                    <td><input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox" aria-label="Select invoice"></td>
                                    <td><a href="#">2504058148</a></td>
                                    <td>SXUCCN-BLK</td>
                                    <td></td>
                                    <td>Feb. 18, Pick list</td>
                                </tr>
                                <tr>
                                    <td><input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox" aria-label="Select invoice"></td>
                                    <td><a href="#">2504058148</a></td>
                                    <td>SXUCCN-BLK</td>
                                    <td></td>
                                    <td>Feb. 18, Pick list</td>
                                </tr>
                                <tr>
                                    <td><input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox" aria-label="Select invoice"></td>
                                    <td><a href="#">2504058148</a></td>
                                    <td>SXUCCN-BLK</td>
                                    <td></td>
                                    <td>Feb. 18, Pick list</td>
                                </tr>
                                <tr>
                                    <td><input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox" aria-label="Select invoice"></td>
                                    <td><a href="#">2504058148</a></td>
                                    <td>SXUCCN-BLK</td>
                                    <td></td>
                                    <td>Feb. 18, Pick list</td>
                                </tr>
                                <tr>
                                    <td><input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox" aria-label="Select invoice"></td>
                                    <td><a href="#">2504058148</a></td>
                                    <td>SXUCCN-BLK</td>
                                    <td></td>
                                    <td>Feb. 18, Pick list</td>
                                </tr>
                                <tr>
                                    <td><input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox" aria-label="Select invoice"></td>
                                    <td><a href="#">2504058148</a></td>
                                    <td>SXUCCN-BLK</td>
                                    <td></td>
                                    <td>Feb. 18, Pick list</td>
                                </tr>
                                <tr>
                                    <td><input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox" aria-label="Select invoice"></td>
                                    <td><a href="#">2504058148</a></td>
                                    <td>SXUCCN-BLK</td>
                                    <td></td>
                                    <td>Feb. 18, Pick list</td>
                                </tr>
                                <tr>
                                    <td><input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox" aria-label="Select invoice"></td>
                                    <td><a href="#">2504058148</a></td>
                                    <td>SXUCCN-BLK</td>
                                    <td></td>
                                    <td>Feb. 18, Pick list</td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center">
                            {{--                            {{$transactions->links()}}--}}
                            <ul class="pagination m-0 ms-auto">

                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M15 6l-6 6l6 6"></path>
                                        </svg>

                                    </a>
                                </li>
                                <li class="page-item active"><a class="page-link">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">4</a></li>
                                <li class="page-item"><a class="page-link" href="#">5</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9 6l6 6l-6 6"></path>
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Unregistered Hardware</h3>
                        </div>
                        <div class="table-responsive table-scrollable">
                            <table class="table table-selectable card-table table-vcenter text-nowrap datatable">
                                <thead>
                                <tr>
                                    <th class="w-1"><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></th>
                                    <th>Serial Number</th>
                                    <th>Code</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox" aria-label="Select invoice"></td>
                                    <td ><a href="#">2502058117</a>
                                    </td>
                                    <td>HMGLXC-4S</td>
                                </tr>
                                <tr>
                                    <td><input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox" aria-label="Select invoice"></td>
                                    <td ><a href="#">2502058117</a>
                                    </td>
                                    <td>HMGLXC-4S</td>
                                </tr>
                                <tr>
                                    <td><input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox" aria-label="Select invoice"></td>
                                    <td ><a href="#">2502058117</a>
                                    </td>
                                    <td>HMGLXC-4S</td>
                                </tr>
                                <tr>
                                    <td><input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox" aria-label="Select invoice"></td>
                                    <td ><a href="#">2502058117</a>
                                    </td>
                                    <td>HMGLXC-4S</td>
                                </tr>
                                <tr>
                                    <td><input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox" aria-label="Select invoice"></td>
                                    <td ><a href="#">2502058117</a>
                                    </td>
                                    <td>HMGLXC-4S</td>
                                </tr>
                                <tr>
                                    <td><input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox" aria-label="Select invoice"></td>
                                    <td ><a href="#">2502058117</a>
                                    </td>
                                    <td>HMGLXC-4S</td>
                                </tr>


                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center">
                            {{--                            {{$transactions->links()}}--}}
                            <ul class="pagination m-0 ms-auto">

                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M15 6l-6 6l6 6"></path>
                                        </svg>

                                    </a>
                                </li>
                                <li class="page-item active"><a class="page-link">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">4</a></li>
                                <li class="page-item"><a class="page-link" href="#">5</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9 6l6 6l-6 6"></path>
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Assign To UCX Parent</h3>
                        </div>
                        <div class="card-body">
                            <div class="row row-cards">
                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Parent Serial Number</label>
                                        <input type="text" name="parent_sereal_number" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">&nbsp;</label>
                                        <button type="submit" class="btn btn-primary">Assign To UCX Parent</button>
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
