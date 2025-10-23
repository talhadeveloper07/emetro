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
                            </svg></a> Extensions
                    </h2>
                            <ul class="nav nav-tabs card-header-tabs nav-fill my-3" data-bs-toggle="tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a  href="{{ route('provisioning.templates') }}"  class="nav-link" 
                                        aria-selected="true" role="tab">Templates</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a  href="{{ route('provisioning.mac') }}"  class="nav-link"  aria-selected="false"
                                        >MAC</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="{{ route('provisioning.extensions') }}" class="nav-link active"  aria-selected="false"
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
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Extension</label>
                                            <input type="text" name="extension" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">MAC</label>
                                            <input type="text" name="mac" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Site Name</label>
                                            <input type="text" name="site_name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Port</label>
                                            <input type="text" name="port" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Server Address</label>
                                            <input type="text" name="server_address" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">UCX Serial Number</label>
                                            <input type="text" name="ucx_slno" class="form-control">
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
                        <table id="extension" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll"></th>
                        <th>Extension</th>
                        <th>MAC</th>
                        <th>Vendor</th>
                        <th>Model</th>
                        <th>Template</th>
                        <th>UCX SN</th>
                        <th>Site Name</th>
                        <th>Server Address</th>
                        <th>Last Push</th>
                    </tr>
                </thead>
            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6">
                    <button class="btn btn-primary" id="deleteSelectedBtn">PUSH CONFIGURATION TO PUBLIC SERVER</button>
                </div>
                <div class="col-md-6 text-end">
                    <button class="btn btn-danger" id="deleteSelectedBtn">Delete</button>
                </div>
            </div>

            <div class="row row-deck row-cards mt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h2 class="text-lime mb-0">Import Extensions</h2>
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
                                        <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Server Address</label>
                                            <input type="text" name="server_address" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">UCX Serial Number</label>
                                            <input type="text" name="ucx_slno" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Port</label>
                                            <input type="text" name="port" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Select CSV File to Upload</label>
                                            <input type="file" name="extension_file" class="form-control">
                                            <span style="font-size: 11px;">Use the CSV file exported from: <b>PBX > Batch Configuration > Batch of Extensions</b><br>
                                            Only entries with Tech=sip are imported. Existing entries are overwritten.
                                            </span>
                                        </div>
                                    </div>

                                        <div class="col-sm-12 col-md-12 text-end">
                                            <button type="submit" class="btn btn-primary">Import</button>
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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
$(document).ready(function() {
    let table = $('#extension').DataTable({
        ajax: "{{ route('provisioning.extensions.data') }}",
        columns: [
            { data: 'checkbox', orderable: false, searchable: false },
            { data: 'extension' },
            { data: 'mac_id' },
            { data: 'vendor' },
            { data: 'model' },
            { data: 'template_name' },
            { data: 'ucx_sn' },
            { data: 'site_name' },
            { data: 'server_address' },
            { data: 'last_push' },
        ],
        order: [[1, 'asc']],
        columnDefs: [
            { targets: 0, className: 'text-center', width: '5%' },
        ],
        processing: true,
        serverSide: false, // since you’re returning JSON manually
        responsive: true,
        createdRow: function(row, data) {
            $(row).find('td:first').addClass('text-center');
        },
        searching: false,
    lengthChange: false,
    info: false,
    });

    // ✅ Select All checkbox
    $('#selectAll').on('click', function() {
        const isChecked = $(this).prop('checked');
        $('.record-checkbox').prop('checked', isChecked);
    });

      // ✅ Handle MAC dropdown change dynamically

$(document).on('change', '.mac-select', function () {
    const macId = $(this).val();
    const extensionId = $(this).data('extension');
    const $row = $(this).closest('tr');
    const row = table.row($row);

    if (!row.node()) return;

    $.ajax({
        url: "{{ route('provisioning.extensions.updateMac') }}",
        method: "POST",
        data: {
            _token: '{{ csrf_token() }}',
            mac_id: macId,
            extension_id: extensionId,
        },
        success: function (res) {
            if (res.success) {
                // ✅ Update the row instantly
                const rowData = row.data();
                rowData.vendor = res.vendor;
                rowData.model = res.model;
                rowData.template_name = res.template_name;
                row.data(rowData).invalidate().draw(false);

                // ✅ Keep the MAC selected
                setTimeout(() => {
                    $(`#mac_select_${extensionId}`).val(macId);
                }, 100);

                // ✅ Highlight success
                $row.addClass('table-success');
                setTimeout(() => $row.removeClass('table-success'), 800);
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
        },
    });
});



});
</script>

@endsection
@endsection