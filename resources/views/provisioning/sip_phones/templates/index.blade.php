@extends('layouts.admin')

@section('content')
<style>
    .nav-fill .nav-item,
    .nav-fill > .nav-link {
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

    #selectedCountBadge {
        font-size: 0.8em;
    }
</style>

<div class="container-xl">
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">
                    <a href="{{ route('provisioning.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M15 6l-6 6l6 6" />
                        </svg>
                    </a> Templates
                </h2>

                <ul class="nav nav-tabs card-header-tabs nav-fill my-3" data-bs-toggle="tabs" role="tablist">
                    <li class="nav-item">
                        <a href="{{ route('provisioning.templates') }}" class="nav-link active">Templates</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('provisioning.mac') }}" class="nav-link">MAC</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('provisioning.extensions') }}" class="nav-link">Extensions</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Help</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">

        {{-- Filter Form --}}
        <div class="card mb-3">
            <form id="filterForm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 col-md-2">
                            <label class="form-label">Organization</label>
                            <select name="organization" class="form-control select2">
                                <option value="">All</option>
                                @foreach($organizations as $org)
                                    <option value="{{ $org->id }}">{{ $org->name }}</option>
                                @endforeach
                            </select>
                        </div>

                      <div class="col-md-3 col-sm-6">
                      <label class="form-label">Vendor</label>
                        <select id="vendor_filter" name="vendor" class="form-control vendor-select">
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
                       <select id="model_filter" name="model" class="form-control model-select">
                            <option value="">Select Model</option>
                        </select>

                       </div>

                        <div class="col-sm-6 col-md-2">
                            <label class="form-label">Template Name</label>
                            <input type="text" name="template_name" class="form-control">
                        </div>

                        <div class="col-sm-12 col-md-12 text-end mt-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <button type="button" id="clearFilters" class="btn btn-secondary">Clear</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Templates Table --}}
        <div class="card">
            <div class="table-responsive">
                <table id="templates-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>Template Name</th>
                            <th>Vendor</th>
                            <th>Model</th>
                            <th>Last Modified</th>
                            <th>Is Default</th>
                            <th>Download</th>
                        </tr>
                    </thead>
                </table>
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
                            <h2 class="text-lime mb-0">Upload Template</h2>
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
                                        <div class="col-md-3 col-sm-6">
                                            <label class="form-label">Vendor</label>
                                            <select id="vendor_upload" name="vendor" class="form-control vendor-select">
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
                                        <select id="model_upload" name="model" class="form-control model-select">
                                            <option value="">Select Model</option>
                                        </select>
                                        </div>
                                        <div class="col-sm-6 col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Template Name</label>
                                                <input type="text" name="template_name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Select Template File for Upload</label>
                                                <input type="file" name="template_file" class="form-control">
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
@endsection


@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    const table = $('#templates-table').DataTable({
        ajax: {
            url: "{{ route('provisioning.templates.data') }}",
            type: "GET",
            data: function (d) {
                d.vendor = $('select[name="vendor"]').val();
                d.organization = $('select[name="organization"]').val();
                d.model = $('select[name="model"]').val();
                d.template_name = $('input[name="template_name"]').val();
            },
            dataSrc: "data",
        },
        columns: [
            {
            data: 'id',
            orderable: false,
            searchable: false,
            render: function (data, type, row) {
                return `<input type="checkbox" class="row-checkbox" value="${data}">`;
            }
        },
            { data: 'template_name' },
            { data: 'vendor' },
            { data: 'model' },
            { data: 'modified_date' },
            { data: 'is_default' },
            { data: 'actions', orderable: false, searchable: false }
        ],
        columnDefs: [
            { targets: [0, 5, 6], className: 'text-center' }
        ],
        createdRow: function(row, data) {
            $(row).find('td:eq(0), td:eq(5), td:eq(6)').addClass('text-center');
        },  searching: false,
    lengthChange: false,
    info: false,
    });

    $('#selectAll').on('click', function() {
        let checked = $(this).is(':checked');
        $('.row-checkbox').prop('checked', checked);
    });

    // ✅ Delete Selected Rows
    $('#deleteSelected').on('click', function() {
        let selected = $('.row-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (selected.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Templates Selected',
                text: 'Please select at least one template to delete.'
            });
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: "This action will permanently delete selected templates.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Delete!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('provisioning.templates.bulkDelete') }}",
                    method: "POST",
                    data: {
                        ids: selected,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        $('#selectAll').prop('checked', false);
                        table.ajax.reload(null, false);
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to delete templates.'
                        });
                    }
                });
            }
        });
    });

    // Filter submit
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        $('#loader_overlay').hide();
        table.ajax.reload();
    });

    // Clear filters
    $('#clearFilters').on('click', function() {
        $('#filterForm')[0].reset();
        $('#loader_overlay').hide();
        table.ajax.reload();
    });

    // ✅ Select All functionality
    $('#selectAll').on('change', function () {
        const isChecked = $(this).is(':checked');
        $('.row-checkbox').prop('checked', isChecked);
    });
});

</script>

<script>
$(document).on('change', '.vendor-select', function() {
    let vendor = $(this).val();
    let modelSelect = $(this).closest('.row').find('.model-select');

    modelSelect.html('<option>Loading...</option>');

    if (vendor) {
        $.get('/provisioning/get-models/' + vendor, function(data) {
            modelSelect.empty().append('<option value="">Select Model</option>');
            $.each(data, function(key, value) {
                modelSelect.append('<option value="' + key + '">' + value + '</option>');
            });
        });
    } else {
        modelSelect.empty().append('<option value="">Select Model</option>');
    }
});
</script>
<script>
$(document).ready(function() {
    $('#deviceForm').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('provisioning.templates.store') }}",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#loader_overlay').hide();
                Swal.fire({
                    title: 'Uploading...',
                    text: 'Please wait while we upload your template.',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });
            },
            success: function(response) {
                Swal.close();

                if (response.success) {
                $('#loader_overlay').hide();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // Optional: Reset form
                    $('#deviceForm')[0].reset();
                    $('.select2').val(null).trigger('change');
                } else {
                $('#loader_overlay').hide();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong!',
                    });
                }
            },
            error: function(xhr) {
                Swal.close();
                $('#loader_overlay').hide();
                let message = 'Something went wrong!';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    message = Object.values(xhr.responseJSON.errors).join('<br>');
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: message,
                });
            }
        });
    });
});
</script>

@endsection
