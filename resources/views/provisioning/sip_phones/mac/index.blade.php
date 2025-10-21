@extends('layouts.admin')

@section('content')
    <style>
        .nav-fill .nav-item,
        .nav-fill>.nav-link {
            height: 60px;
        }

        .nav-fill .nav-item .nav-link,
        .nav-justified .nav-item .nav-link {
            width: 100%;
            height: 100%;
        }

        .action-buttons {
            white-space: nowrap;
        }

        .btn-list .btn {
            margin-left: 5px;
        }

        .collapse:not(.show) {
            display: none;
        }

        #selectedCountBadge {
            font-size: 0.8em;
        }
    </style>
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        <a href="{{ route('provisioning.index') }}"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M15 6l-6 6l6 6" />
                            </svg></a> MAC
                    </h2>
                            <ul class="nav nav-tabs card-header-tabs nav-fill my-3" data-bs-toggle="tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a  href="{{ route('provisioning.templates') }}"  class="nav-link" 
                                        aria-selected="true" role="tab">Templates</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a  href="{{ route('provisioning.mac') }}"  class="nav-link active"  aria-selected="false"
                                        >MAC</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="{{ route('provisioning.extensions') }}" class="nav-link"  aria-selected="false"
                                        >Extensions</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="#" class="nav-link"  aria-selected="false"
                                       >Help</a>
                                </li>
                            </ul>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <button class="btn btn-primary d-none" id="editSelectedBtn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                <path d="M16 5l3 3" />
                            </svg>
                            Edit Selected
                        </button>
                        <button class="btn btn-danger d-none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 7l16 0" />
                                <path d="M10 11l0 6" />
                                <path d="M14 11l0 6" />
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                            </svg>
                            Delete Selected
                        </button>
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
                        <form id="filterForm">
                            <div class="card-body">
                                <div class="row row-cards">
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Organization</label>
                                            <select name="reseller" class="form-control select2">
                                                <option value="">All</option>
                                                @foreach($organizations as $org)
                                                    <option value="{{ $org->id }}" {{ request('reseller') == $org->id ? 'selected' : '' }}>
                                                        {{ $org->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <label class="form-label">Vendor</label>
                                            <select id="vendor" name="vendor" class="form-control">
                                                    <option value="">Select Vendor</option>
                                                    <option value="Yealink">Yealink</option>
                                                    <option value="Grandstream">Grandstream</option>
                                                    <option value="Fanvil">Fanvil</option>
                                                    <option value="Snom">Snom</option>
                                                    <option value="Polycom">Polycom</option>
                                                </select>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <label class="form-label">Model</label>
                                            <select id="model" name="model" class="form-control">
                                                <option value="">Select Model</option>
                                            </select>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Template Name</label>
                                            <input type="text" name="template_name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 text-end">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <button type="button" id="clearFilters" class="btn btn-secondary">Clear
                                            Filter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="table-responsive">
                        <table id="macTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll"></th>
                        <th>MAC</th>
                        <th>Vendor</th>
                        <th>Model</th>
                        <th>Template Name</th>
                        <th>Re-seller</th>
                        <th>Modified Date</th>
                    </tr>
                </thead>
            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12 text-end">
                    <button class="btn btn-danger" id="deleteSelectedBtn">Delete</button>
                </div>
            </div>

            <div class="row row-deck row-cards mt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h2 class="text-lime mb-0">Import MAC</h2>
                        </div>
                        <div class="card-body">
                                <form id="deviceForm">
                                    @csrf
                                    <div class="row row-cards">
                                        <div class="col-sm-6 col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Organization</label>
                                                <select name="reseller" class="form-select select2">
                                                    <option value="">All</option>
                                                    @foreach($organizations as $org)
                                                        <option value="{{ $org->id }}" {{ request('reseller') == $org->id ? 'selected' : '' }}>
                                                            {{ $org->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                       <div class="row">
                                            <div class="col-sm-6 col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label">Select CSV File for Upload</label>
                                                    <input type="file" name="mac_file" class="form-control">
                                                    <span style="font-size:10px;">Supported fields in CSV file: MAC, Vendor, Model, Template</span>
                                                </div>
                                            </div>
                                       </div>
                                        <div class="col-sm-12 col-md-12 text-end">
                                            <button type="submit" class="btn btn-primary">Upload</button>
                                        </div>
                                    </div>
                                </form>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row row-deck row-cards mt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h2 class="text-lime mb-0">Add MAC</h2>
                        </div>
                        <div class="card-body">
                                <form id="deviceForm">
                                    @csrf
                                    <div class="row row-cards">
                                        <div class="row pt-3">
                                            <div class="col-sm-6 col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label">Organization</label>
                                                    <select name="reseller" class="form-select select2">
                                                        <option value="">All</option>
                                                        @foreach($organizations as $org)
                                                            <option value="{{ $org->id }}" {{ request('reseller') == $org->id ? 'selected' : '' }}>
                                                                {{ $org->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">MAC</label>
                                                <input type="text" name="mac" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-2">
                                            <label class="form-label">Vendor</label>
                                            <select name="vendor" class="form-control select2">
                                                <option value="">All</option>
                                                <option value="Yealink">Yealink</option>
                                                <option value="Grandstream">Grandstream</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6 col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">Model</label>
                                                <select id="edit-status" name="model" class="form-control form-select">
                                                    <option value="" selected="selected">(Select Model)</option>
                                                    <option value="AP500D/AP510D">AP500D/AP510D</option>
                                                    <option value="AP500M/AP510M">AP500M/AP510M</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">Template</label>
                                                <input type="text" name="template_name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 text-end">
                                            <button type="submit" class="btn btn-primary">Upload</button>
                                        </div>
                                    </div>
                                </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
$(document).ready(function() {
    const table = $('#macTable').DataTable({
    ajax: '{{ route('provisioning.mac.data') }}',
    columns: [
        {
            data: 'id',
            orderable: false,
            searchable: false,
            render: function (data, type, row) {
                return `<input type="checkbox" class="row-checkbox" value="${data}">`;
            }
        },
        { data: 'mac_name', title: 'MAC' },
        { data: 'vendor', title: 'Vendor' },
        { data: 'model', title: 'Model' },
        { data: 'template_name', title: 'Template' },
        { data: 're_seller', title: 'Reseller' },
        { data: 'modified_date', title: 'Modified Date' },
    ],
    paging: true,
    searching: false,
    lengthChange: false,
    info: false
});

// ✅ Select All functionality
$('#selectAll').on('change', function () {
    const isChecked = $(this).is(':checked');
    $('.row-checkbox').prop('checked', isChecked);
});

// ✅ Keep Select All synced if user manually toggles checkboxes
$('#macTable').on('change', '.row-checkbox', function () {
    const all = $('.row-checkbox').length;
    const checked = $('.row-checkbox:checked').length;
    $('#selectAll').prop('checked', all === checked);
});

});
</script>

<script>
$('#vendor').on('change', function() {
    let vendor = $(this).val();
    $('#model').html('<option>Loading...</option>');
    $.get('/provisioning/get-models/' + vendor, function(data) {
        $('#model').empty().append('<option value="">Select Model</option>');
        $.each(data, function(key, value) {
            $('#model').append('<option value="' + key + '">' + value + '</option>');
        });
    });
});
</script>

@endsection
@endsection