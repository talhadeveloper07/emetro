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
                    <button class="btn btn-danger" id="deleteSelectedBtn">Delete</button>
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
                                        <div class="col-sm-6 col-md-2">
                                            <label class="form-label">Vendor</label>
                                            <select name="vendor" class="form-control select2">
                                                <option value="">All</option>
                                                <option value="Yealink">Yealink</option>
                                                <option value="Grandstream">Grandstream</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6 col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Model</label>
                                                <select id="edit-status" name="model" class="form-control form-select">
                                                    <option value="" selected="selected">(Select Model)</option>
                                                    <option value="AP500D/AP510D">AP500D/AP510D</option>
                                                    <option value="AP500M/AP510M">AP500M/AP510M</option>
                                                </select>
                                            </div>
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

<script>
$(document).ready(function() {
    const table = $('#templates-table').DataTable({
        ajax: {
            url: "{{ route('provisioning.templates.data') }}",
            type: "GET",
            data: function (d) {
                d.vendor = $('select[name="vendor"]').val();
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
