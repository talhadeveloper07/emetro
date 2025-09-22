@extends('layouts.admin')

@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Import Data
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
                    <form action="{{ route('import.product') }}" method="POST" enctype="multipart/form-data">                        @csrf
                        @csrf
                        <div class="card-header">
                            <h3>Import Products</h3>
                        </div>
                        <div class="card-body">
                            <div class="row row-cards">
                                <div class="col-lg-12">

                                    <div class="mb-3">
                                        <label  class="form-label required">CSV File</label>
                                        <input type="file" name="csv_product"  class="form-control" accept=".csv" required>
                                        <small class="form-text text-muted">Only CSV files are allowed.</small>

                                        @error('csv_product')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div>
                                        <button type="submit" id="submitPayment" class="btn btn-primary ms-auto">
                                            Import
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                    </div>

                </div>
                <div class="col-12">
                    <div class="card">
                    <form action="{{ route('import.org') }}" method="POST" enctype="multipart/form-data">                        @csrf
                        @csrf
                        <div class="card-header">
                            <h3>Import Organizations</h3>
                        </div>
                        <div class="card-body">
                            <div class="row row-cards">
                                <div class="col-lg-12">

                                    <div class="mb-3">
                                        <label  class="form-label required">XLSX File</label>
                                        <input type="file" name="csv_org"  class="form-control" accept=".xlsx,.xls" required>
                                        <small class="form-text text-muted">Only XLSX files are allowed.</small>

                                        @error('csv_org')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div>
                                        <button type="submit" id="submitPayment" class="btn btn-primary ms-auto">
                                            Import
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                    </div>

                </div>
                <div class="col-12">
                    <div class="card">
                    <form action="{{ route('import.org_doc') }}" method="POST" enctype="multipart/form-data">                        @csrf
                        @csrf
                        <div class="card-header">
                            <h3>Import Organizations Documents</h3>
                        </div>
                        <div class="card-body">
                            <div class="row row-cards">
                                <div class="col-lg-12">

                                    <div class="mb-3">
                                        <label  class="form-label required">XLSX File</label>
                                        <input type="file" name="org_doc"  class="form-control" accept=".xlsx,.xls" required>
                                        <small class="form-text text-muted">Only XLSX files are allowed.</small>

                                        @error('org_doc')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div>
                                        <button type="submit" id="submitPayment" class="btn btn-primary ms-auto">
                                            Import
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                    <form action="{{ route('import.org_notification') }}" method="POST" enctype="multipart/form-data">                        @csrf
                        @csrf
                        <div class="card-header">
                            <h3>Import Organizations (Assurance Notifications)</h3>
                        </div>
                        <div class="card-body">
                            <div class="row row-cards">
                                <div class="col-lg-12">

                                    <div class="mb-3">
                                        <label  class="form-label required">XLSX File</label>
                                        <input type="file" name="org_notification"  class="form-control" accept=".xlsx,.xls" required>
                                        <small class="form-text text-muted">Only XLSX files are allowed.</small>

                                        @error('org_notification')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div>
                                        <button type="submit" id="submitPayment" class="btn btn-primary ms-auto">
                                            Import
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                    <form action="{{ route('import.org_setting') }}" method="POST" enctype="multipart/form-data">                        @csrf
                        @csrf
                        <div class="card-header">
                            <h3>Import Organizations Settings (Payment methods ,HW/SW Fulfillment)</h3>
                        </div>
                        <div class="card-body">
                            <div class="row row-cards">
                                <div class="col-lg-12">

                                    <div class="mb-3">
                                        <label  class="form-label required">Csv File</label>
                                        <input type="file" name="org_setting"  class="form-control" accept=".csv" required>
                                        <small class="form-text text-muted">Only CSV files are allowed.</small>

                                        @error('org_setting')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div>
                                        <button type="submit" id="submitPayment" class="btn btn-primary ms-auto">
                                            Import
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                    </div>

                </div>
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('import.org_user') }}" method="POST" enctype="multipart/form-data">                        @csrf
                            @csrf
                            <div class="card-header">
                                <h3>Import Organizations User</h3>
                            </div>
                            <div class="card-body">
                                <div class="row row-cards">
                                    <div class="col-lg-12">

                                        <div class="mb-3">
                                            <label  class="form-label required">XLSX File</label>
                                            <input type="file" name="org_user"  class="form-control" accept=".xlsx,.xls" required>
                                            <small class="form-text text-muted">Only XLSX files are allowed.</small>

                                            @error('org_user')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>
                                        <div>
                                            <button type="submit" id="submitPayment" class="btn btn-primary ms-auto">
                                                Import
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('import.odr_header') }}" method="POST" enctype="multipart/form-data">                        @csrf
                            @csrf
                            <div class="card-header">
                                <h3>Import Order Header</h3>
                            </div>
                            <div class="card-body">
                                <div class="row row-cards">
                                    <div class="col-lg-12">

                                        <div class="mb-3">
                                            <label  class="form-label required">XLSX File</label>
                                            <input type="file" name="odr_header"  class="form-control" accept=".xlsx,.xls" required>
                                            <small class="form-text text-muted">Only XLSX files are allowed.</small>

                                            @error('odr_header')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>
                                        <div>
                                            <button type="submit" id="submitPayment" class="btn btn-primary ms-auto">
                                                Import
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('import.odr_details') }}" method="POST" enctype="multipart/form-data">                        @csrf
                            @csrf
                            <div class="card-header">
                                <h3>Import Order Details</h3>
                            </div>
                            <div class="card-body">
                                <div class="row row-cards">
                                    <div class="col-lg-12">

                                        <div class="mb-3">
                                            <label  class="form-label required">XLSX File</label>
                                            <input type="file" name="odr_details"  class="form-control" accept=".xlsx,.xls" required>
                                            <small class="form-text text-muted">Only XLSX files are allowed.</small>

                                            @error('odr_details')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>
                                        <div>
                                            <button type="submit" id="submitPayment" class="btn btn-primary ms-auto">
                                                Import
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('import.odr_hardware') }}" method="POST" enctype="multipart/form-data">                        @csrf
                            @csrf
                            <div class="card-header">
                                <h3>Import Order Hardware</h3>
                            </div>
                            <div class="card-body">
                                <div class="row row-cards">
                                    <div class="col-lg-12">

                                        <div class="mb-3">
                                            <label  class="form-label required">XLSX File</label>
                                            <input type="file" name="odr_hardware"  class="form-control" accept=".xlsx,.xls" required>
                                            <small class="form-text text-muted">Only XLSX files are allowed.</small>

                                            @error('odr_hardware')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>
                                        <div>
                                            <button type="submit" id="submitPayment" class="btn btn-primary ms-auto">
                                                Import
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('import.old_product_discount') }}" method="POST" enctype="multipart/form-data">                        @csrf
                            @csrf
                            <div class="card-header">
                                <h3>Import Product Discount Mapping</h3>
                            </div>
                            <div class="card-body">
                                <div class="row row-cards">
                                    <div class="col-lg-12">

                                        <div class="mb-3">
                                            <label  class="form-label required">XLSX File</label>
                                            <input type="file" name="old_product_discount"  class="form-control" accept=".xlsx,.xls" required>
                                            <small class="form-text text-muted">Only XLSX files are allowed.</small>

                                            @error('old_product_discount')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>
                                        <div>
                                            <button type="submit" id="submitPayment" class="btn btn-primary ms-auto">
                                                Import
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
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

        });
    </script>
@endsection
