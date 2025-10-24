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
                                    <label class="form-label">Organization</label>
                                    <select name="reseller" class="form-control select2">
                                        <option value="">All</option>
                                        @foreach($organizations as $org)
                                            <option value="{{ $org->id }}">{{ $org->name }}</option>
                                        @endforeach
                                    </select>
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
                                    <label class="form-label">Template Name</label>
                                    <input type="text" name="template_name" class="form-control">
                                </div>
                                <div class="col-sm-12 col-md-12 text-end mt-3">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <button type="button" id="clearFilters" class="btn btn-secondary">Clear</button>
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
                    <button class="btn btn-danger" id="deleteSelected">Delete</button>
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
                                <form id="deviceForm" method="POST" action="{{ route('provisioning.mac.store') }}">
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
$(document).ready(function () {
    $('#addMacForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('provisioning.mac.store') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    // reset form
                    $('#addMacForm')[0].reset();

                    // reload datatable if exists
                    if ($.fn.DataTable.isDataTable('#macTable')) {
                        $('#macTable').DataTable().ajax.reload(null, false);
                    }
                    $('#successToast .toast-body').text(response.message);
                    new bootstrap.Toast(document.getElementById('successToast')).show();
                }
            },
            error: function (xhr) {
                let message = "Something went wrong!";
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    message = Object.values(errors).map(arr => arr.join(' ')).join("\n");
                }
                $('#errorToast .toast-body').text(message);
                new bootstrap.Toast(document.getElementById('errorToast')).show();
            }
        });
    });
});
</script>

<script>
$(document).ready(function() {

     $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

     const table = $('#macTable').DataTable({
        ajax: {
            url: '{{ route("provisioning.mac.data") }}',
            data: d => {
                d.vendor = $('#vendor').val();
                d.model = $('#model').val();
                d.reseller = $('select[name="reseller"]').val();
                d.template_name = $('input[name="template_name"]').val();
            },
            dataSrc: json => Array.isArray(json) ? json : (json.data ?? [])
        },
        columns: [
            { data: 'id', orderable: false, render: data => `<input type="checkbox" class="row-checkbox" value="${data}">` },
            { data: 'mac_name' },
            { data: 'vendor' },
            { data: 'model' },
            { data: 'template_name' },
            { data: 're_seller' },
            { data: 'modified_date' },
   ],
        paging: true,
        searching: false,
        lengthChange: false,
        info: false
    });

     table.on('processing.dt', (e, settings, processing) => {
        if (processing) $('#loader_overlay').fadeIn(100);
        else $('#loader_overlay').fadeOut(300);
    });

// ✅ Delegated event to handle "Select All" properly
    $(document).on('change', '#selectAll', function () {
        const checked = $(this).prop('checked');
        $('#macTable').find('.row-checkbox').prop('checked', checked);
    });

     $('#filterForm').on('submit', e => {
        e.preventDefault();
        $('#loader_overlay').fadeIn(100);
        table.ajax.reload(() => $('#loader_overlay').fadeOut(300));
    });

    // ✅ Clear filters
    $('#clearFilters').on('click', () => {
        $('#filterForm')[0].reset();
        $('#model').html('<option value="">Select Model</option>');
        $('#loader_overlay').fadeIn(100);
        table.ajax.reload(() => $('#loader_overlay').fadeOut(300));
    });

    // ✅ Bulk Delete Button Click
    $(document).on('click', '#deleteSelected', function () {
        let selectedIds = [];
        $('#macTable').find('.row-checkbox:checked').each(function () {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length === 0) {
            Swal.fire('No Selection', 'Please select at least one record.', 'warning');
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: 'Selected records will be permanently deleted.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('provisioning.mac.bulkDelete') }}",
                    method: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        ids: selectedIds
                    },
                    success: function (response) {
                        Swal.fire('Deleted!', response.message, 'success');
                        table.ajax.reload(null, false);
                        $('#selectAll').prop('checked', false); // Uncheck after reload
                    },
                    error: function (xhr) {
                        Swal.fire('Error', xhr.responseJSON.message || 'Something went wrong.', 'error');
                    }
                });
            }
        });
    });

$(document).on('change', '.template-select', function () {
    const macId = $(this).data('mac-id');
    const templateName = $(this).val();

    $.ajax({
        url: "{{ route('provisioning.mac.updateTemplate') }}",
        method: "POST",
        data: {
            _token: '{{ csrf_token() }}',
            mac_id: macId,
            template_name: templateName,
        },
        success: function (res) {
            if (res.success) {
                console.log("Template updated successfully!");
            }
        },
    });
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