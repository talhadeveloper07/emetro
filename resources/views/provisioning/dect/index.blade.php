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
                            </svg></a> Dect Provisioning
                    </h2>
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
                                    <div class="col-sm-6 col-md-2">
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
                                    <div class="col-sm-6 col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">UCX Serial Number</label>
                                            <input type="text" name="ucx_sn" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Site Name</label>
                                            <input type="text" name="site_name" class="form-control">
                                        </div>
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
                                            <label class="form-label">Mac Address</label>
                                            <input type="text" name="mac_address" class="form-control">
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
                            <table class="table table-selectable card-table table-vcenter text-nowrap datatable"
                                id="dect_table">
                                <thead>
                                    <tr>
                                        <th class="w-1">
                                            <input class="form-check-input m-0 align-middle all-select" type="checkbox"
                                                aria-label="Select all" id="allSelect">
                                        </th>
                                        <th>MAC Address</th>
                                        <th>UCX SN</th>
                                        <th>Site Name</th>
                                        <th>Model</th>
                                        <th>Extensions</th>
                                        <th>Last Push</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Will be auto-filled by DataTables -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6">
                    <button class="btn btn-primary">Push Configuration To Public Server</button>
                </div>
                <div class="col-md-6 text-end">
                    <button class="btn btn-danger" id="deleteSelectedBtn">Delete</button>
                </div>
            </div>

            <div class="row row-deck row-cards mt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h2 class="text-lime mb-0">Add DECT</h2>
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
                                                <label class="form-label">UCX Serial Number</label>
                                                <select name="slno" id="slno" class="form-select" required></select>
                                            </div>
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
                                                <label class="form-label">Mac</label>
                                                <input type="text" name="mac" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 text-end">
                                            <button type="submit" class="btn btn-primary">Add</button>
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

    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

        <script>
$(document).ready(function() {
    let table = $('#dect_table').DataTable({
        ajax: {
            url: "{{ route('provisioning.dect') }}",
            data: function (d) {
                // Send filter data with request
                d.ucx_sn = $('input[name="ucx_sn"]').val();
                d.reseller = $('select[name="reseller"]').val();
                d.site_name = $('input[name="site_name"]').val();
                d.model = $('select[name="model"]').val();
                d.mac_address = $('input[name="mac_address"]').val();
            }
        },
        columns: [
            {
                data: null,
                render: function(data, type, row) {
                        return `<input type="checkbox" class="single-select form-check-input" name="ids[]" value="${row.id}"/>`;
                    },
                orderable: false
            },
            {
                data: 'mac_address',
                render: function(data, type, row) {
                    return `<a href="/provisioning/dect/dect-details/${row.id}">${data}</a>`;
                }
            },
            { data: 'ucx_sn' },
            { data: 'site_name' },
            { data: 'model' },
            { data: 'extensions' },
            { data: 'last_push_date' }
        ],
        paging: true,
        searching: false,
        lengthChange: false,
        ordering: true,
        info: false
    });

    // ✅ Filter form submit
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        table.ajax.reload();
        $('#loader_overlay').hide();
    });

    // ✅ Clear filters
    $('#clearFilters').on('click', function() {
        $('#filterForm')[0].reset();
        $('#loader_overlay').hide();
        table.ajax.reload(); // reload with no filters
    });

        $('#deviceForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('provisioning.dect.store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#loader_overlay').hide();
                        Swal.fire({
                            icon: 'success',
                            title: 'Added!',
                            text: 'Dect Record added Successfully',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        $('#deviceForm')[0].reset();
                        table.ajax.reload();
                    } else {
                        $('#loader_overlay').hide();
                        table.ajax.reload();
                        Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong while saving the record!'
                        });
                        
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMsg = '';
                    $.each(errors, function(key, value) {
                        errorMsg += value + "\n";
                    });
                    $('#loader_overlay').hide();
                    table.ajax.reload();
                    Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: errorMsg
                    });
                }
            });
        });


            $('#allSelect').change(function () {
                $('.single-select').prop('checked', $(this).prop('checked'));
            });

            // -------- Bulk Delete --------
            $('#deleteSelectedBtn').click(() => {
                let ids = [];
                $('.single-select:checked').each(function () {
                    ids.push($(this).val());
                });

                if (ids.length == 0) {
                    Swal.fire('Warning', 'Please select at least one record', 'warning');
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: `${ids.length} record(s) will be deleted!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete them!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post('{{ route("provisioning.dect.bulkDelete") }}',
                            { ids: ids, _token: '{{ csrf_token() }}' },
                            function (response) {
                                Swal.fire('Deleted!', `${ids.length} record(s) have been deleted.`, 'success');
                                table.ajax.reload();
                            }
                        ).fail(function () {
                            Swal.fire('Error', 'Failed to delete records', 'error');
                        });
                    }
                });
            });
    });
</script>

<script>
        new TomSelect("#slno", {
            valueField: "id",
            labelField: "text",
            searchField: "text",
            load: function (query, callback) {
                if (!query.length) return callback();
                fetch("{{ route('provisioning.serials.get') }}?q=" + encodeURIComponent(query))
                    .then(res => res.json())
                    .then(json => {
                        callback(json);
                    }).catch(() => {
                        callback();
                    });
            }, 
            onChange: function(value) {
                let option = this.options[value];
                if (option) {
                    if (option.hostname) {
                        document.querySelector("#s1_ip").value = option.hostname;
                        document.querySelector("#s2_ip").value = option.public_ip || '';
                    } else {
                        document.querySelector("#s1_ip").value = option.public_ip || '';
                        document.querySelector("#s2_ip").value = '';
                    }
                }
            }


        });
    </script>
    @endsection
@endsection