@extends('layouts.admin')

@section('content')

    <style>
        .ts-dropdown.single {
            background: white;
        }
    </style>

    <div class="container-xl">

        <!-- Page Header -->
        <div class="page-header d-print-none mb-3">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        <a href="{{ route('provisioning.index') }}">
                            <!-- Back Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icon-tabler-chevron-left">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M15 6l-6 6l6 6" />
                            </svg>
                        </a>
                        Infinity 3065
                    </h2>
                </div>
                <div class="col-auto ms-auto">
                    <div class="btn-list">
                        <button type="button" class="btn btn-primary" id="createBtn">Add New</button>
                        <button type="button" class="btn btn-danger" id="bulkDeleteBtn">Delete Selected</button>
                        <a href="javascript:void(0)" id="exportCsv" class="btn btn-success">Export CSV</a>
                        <a href="{{ route('provisioning.softphones.xml') }}" target="_blank" class="btn btn-info">Download XML</a>

                    </div>

                </div>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="card mb-3">
            <form id="filterForm">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Organization</label>
                            <select name="org_id" class="form-control">
                                <option value="">All</option>
                                @foreach($organizations as $org)
                                    <option value="{{ $org->id }}" {{ request('org_id') == $org->id ? 'selected' : '' }}>
                                        {{ $org->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Phone Type</label>
                            <input type="text" name="phone_type" value="{{ request('phone_type') }}" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Device ID</label>
                            <input type="text" name="device_id" value="{{ request('device_id') }}" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">S1 IP</label>
                            <input type="text" name="s1_ip" value="{{ request('s1_ip') }}" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">S2 IP</label>
                            <input type="text" name="s2_ip" value="{{ request('s2_ip') }}" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">UCX Serial Number</label>
                            <input type="text" name="slno" value="{{ request('slno') }}" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control select2">
                                <option value="">All</option>
                                <option value="Available" {{ request('status') == 'Available' ? 'selected' : '' }}>Available
                                </option>
                            </select>
                        </div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            @if(collect(request()->except('_token'))->filter()->isNotEmpty())
                                <a href="{{ route('provisioning.infinity3065') }}" class="btn btn-secondary">Clear Filter</a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- DataTable -->
        <div class="card mb-3">
            <div class="table-responsive">
                <table id="infinity3065-table" class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="allSelect"></th>
                            <th>Device ID</th>
                            <th>User</th>
                            <th>Serial Number</th>
                            <th>Device Type</th>
                            <th>S1 Info</th>
                            <th>Organization</th>
                            <th>Status</th>
                            <th>Updated</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>

    <!-- Multi-Step Modal -->
    <div class="modal fade" id="crudModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <form id="crudForm">
                    <input type="hidden" name="id" id="recordId">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Create Infinity3065</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="stepper">
                            <!-- Step 1: Profile -->
                            <div class="step" data-step="1">
                                <h4>Profile</h4>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <input type="hidden" name="form_mode" value="create">
                                        <label class="form-label">UCX Serial Number</label>
                                        <!-- <input type="text" name="slno" class="form-control" required> -->
                                        <select name="slno" id="slno" class="form-select" required></select>

                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">S1 IP</label>
                                        <input type="text" id="s1_ip" name="s1_ip" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">S1 Port</label>
                                        <input type="number" name="s1_port" value="7000" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">S1 Retries</label>
                                        <input type="number" name="s1_retry_number" value="1" class="form-control">
                                    </div>
                                </div>
                                <div class="row g-3 mt-2">
                                    <div class="col-md-4">
                                        <label class="form-label">S2 IP</label>
                                        <input type="text" id="s2_ip" name="s2_ip" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">S2 Port</label>
                                        <input type="number" name="s2_port" value="7000" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">S2 Retries</label>
                                        <input type="number" name="s2_retry_number" value="1" class="form-control">
                                    </div>
                                </div>
                            </div> <!-- Close Step 1 -->

                            <!-- Step 2: User -->
                            <div class="step d-none" data-step="2">
                                <h4>User</h4>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">First Name</label>
                                        <input type="text" name="first_name" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" name="last_name" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">UCX Extension</label>
                                        <input type="text" name="extension" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Mobile Number</label>
                                        <input type="text" name="mobile" class="form-control">
                                    </div>
                                </div>
                            </div> <!-- Close Step 2 -->

                            <!-- Step 3: Services -->
                            <div class="step d-none" data-step="3">
                                <h4>Services</h4>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">SMS 1</label>
                                        <select name="sms_did1" class="form-control select2">
                                            <option value="">Select</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">SMS 2</label>
                                        <select name="sms_did2" class="form-control select2">
                                            <option value="">Select</option>
                                        </select>
                                    </div>
                                </div>
                            </div> <!-- Close Step 3 -->

                            <!-- Step 4: Review -->
                            <div class="step d-none" data-step="4">
                                <h4>Review & Submit</h4>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Please review your information</h5>
                                        <div id="reviewContent">
                                            <!-- Review content will be populated by JavaScript -->
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- Close Step 4 -->
                        </div> <!-- Close stepper -->

                        <div class="mt-3 text-end">
                            <button type="button" class="btn btn-secondary" id="prevStep">Previous</button>
                            <button type="button" class="btn btn-primary" id="nextStep">Next</button>
                            <button type="submit" class="btn btn-success d-none" id="submitBtn">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>


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
    <script>
        $(function () {
            $('.select2').select2();

            // -------- DataTable --------
            const table = $('#infinity3065-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('provisioning.infinity3065.data') }}",
                    type: "GET",
                    data: function (d) {
                        // Add filter form data to the request
                        d.org_id = $('select[name="org_id"]').val();
                        d.phone_type = $('input[name="phone_type"]').val();
                        d.phone_serial_number = $('input[name="phone_serial_number"]').val();
                        d.device_id = $('input[name="device_id"]').val();
                        d.s1_ip = $('input[name="s1_ip"]').val();
                        d.s2_ip = $('input[name="s2_ip"]').val();
                        d.slno = $('input[name="slno"]').val();
                        d.status = $('select[name="status"]').val();
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [
                    { data: 'checkbox', orderable: false, searchable: false },
                    { data: 'device_id' },
                    { data: 'full_name' },
                    { data: 'serial_number' },
                    { data: 'device_type' },
                    { data: 's1_info' },
                    { data: 'reseller_id' },
                    { data: 'device_current_status' },
                    { data: 'updated' },
                    { data: 'actions', orderable: false, searchable: false }
                ]
            });

            $('#exportCsv').on('click', function () {
                table.button('.buttons-csv').trigger();
            });

            // Submit filter form
            $('#filterForm').on('submit', function (e) {
                e.preventDefault();
                $('#loader_overlay').hide();
                table.ajax.reload();
            });


            $('#allSelect').change(function () {
                $('.single-select').prop('checked', $(this).prop('checked'));
            });

            // -------- Multi-Step Modal --------
            let step = 1, totalSteps = 4;
            const showStep = s => {
                $('.step').addClass('d-none');
                $(`.step[data-step="${s}"]`).removeClass('d-none');

                const isEditMode = $('#modalTitle').text().includes('Edit');

                $('#prevStep').toggle(s > 1);
                $('#nextStep').toggle(s < totalSteps);

                // Step 4
                if (s === totalSteps) {
                    $('#submitBtn').removeClass('d-none');
                    // Change button text based on mode
                } else {
                    $('#submitBtn').addClass('d-none');
                }

                // Update modal title
                const action = isEditMode ? 'Edit' : 'Create';
                $('#modalTitle').text(`${action} Infinity3065 - Step ${s} of ${totalSteps}`);

                // If it's the review step (step 4), populate the review content
                if (s === 4) {
                    populateReviewContent();
                }
            };


            // Function to populate review content
            function populateReviewContent() {
                let reviewHTML = '<div class="row">';

                // Profile information
                reviewHTML += '<div class="col-md-6"><h6>Profile Information:</h6><ul class="list-unstyled">';
                reviewHTML += `<li><strong>UCX Serial Number:</strong> ${$('select[name="slno"]').val() || 'N/A'}</li>`;
                reviewHTML += `<li><strong>S1 IP:</strong> ${$('input[name="s1_ip"]').val() || 'N/A'}</li>`;
                reviewHTML += `<li><strong>S1 Port:</strong> ${$('input[name="s1_port"]').val() || 'N/A'}</li>`;
                reviewHTML += `<li><strong>S2 IP:</strong> ${$('input[name="s2_ip"]').val() || 'N/A'}</li>`;
                reviewHTML += '</ul></div>';

                // User information
                reviewHTML += '<div class="col-md-6"><h6>User Information:</h6><ul class="list-unstyled">';
                reviewHTML += `<li><strong>Email:</strong> ${$('input[name="email"]').val() || 'N/A'}</li>`;
                reviewHTML += `<li><strong>First Name:</strong> ${$('input[name="first_name"]').val() || 'N/A'}</li>`;
                reviewHTML += `<li><strong>Last Name:</strong> ${$('input[name="last_name"]').val() || 'N/A'}</li>`;
                reviewHTML += `<li><strong>UCX Extension:</strong> ${$('input[name="extension"]').val() || 'N/A'}</li>`;
                reviewHTML += '</ul></div>';

                reviewHTML += '</div>';

                $('#reviewContent').html(reviewHTML);
            }

            showStep(step);

            $('#nextStep').click(() => {
                let valid = true;
                $(`.step[data-step="${step}"] input[required]`).each(function () {
                    if (!$(this).val()) {
                        valid = false;
                        $(this).addClass('is-invalid');
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                if (!valid) {
                    Swal.fire('Error', 'Please fill all required fields', 'error');
                    return;
                }

                if (step < totalSteps) {
                    step++;
                    showStep(step);
                }
            });

            $('#prevStep').click(() => {
                if (step > 1) {
                    step--;
                    showStep(step);
                }
            });

            // -------- CRUD --------
            $('#createBtn').click(() => {
                $('#crudForm')[0].reset();
                $('#modalTitle').text('Create Infinity3065 - Step 1 of 4');
                step = 1;
                let slnoSelect = document.querySelector('#slno').tomselect;
                    if (slnoSelect) {
                        slnoSelect.clear();       // clears selected value
                        slnoSelect.clearOptions(); // optional: clears loaded options
                    }
                showStep(step);
                $('#crudModal').modal('show');
            });

            $(document).on('click', '.editBtn', function () {
                const slno = $(this).data('id');
                $.get(`/provisioning/infinity3065/edit/${slno}`, function (res) {
                    if (res.success) {
                        const data = res.data;

                        // Map all fields manually
                        const select = document.querySelector('select[name="slno"]');
                        const tomSelect = select.tomselect;

                        // Clear old value
                        tomSelect.clear();

                        // Add option if not already in list
                        tomSelect.addOption({ id: data.slno, text: data.slno });

                        // Set selected value
                        tomSelect.setValue(data.slno, true);

                        $('[name="form_mode"]').val('edit');
                        $('[name="device_id"]').val(data.device_id);
                        $('[name="first_name"]').val(data.first_name);
                        $('[name="last_name"]').val(data.last_name);
                        $('[name="extension"]').val(data.extension);
                        $('[name="email"]').val(data.email);
                        $('[name="mobile"]').val(data.mobile);
                        $('[name="notification_method"]').val(data.notification_method);
                        $('#s1_ip').val(data.s1_ip);
                        $('[name="s1_port"]').val(data.s1_port);
                        $('[name="s1_retry_number"]').val(data.s1_retry_number);
                        $('#s2_ip').val(data.s2_ip);
                        $('[name="s2_port"]').val(data.s2_port);
                        $('[name="s2_retry_number"]').val(data.s2_retry_number);
                        $('[name="allow_multiple_profile"]').prop('checked', data.allow_multiple_profile == 1);
                        $('[name="allow_changes_default_profile"]').prop('checked', data.allow_changes_to_default_profile == 1);
                        $('[name="profile_update_frequency"]').val(data.profile_update_frequency);
                        $('[name="infinityone_url"]').val(data.infinityone_url);
                        // $('[name="sms_did1"]').val(data.sms_did1).trigger('change');
                        // $('[name="sms_did2"]').val(data.sms_did2).trigger('change');
                        $('[name="reseller_name"]').val(data.reseller_id);
                        $('[name="device_type"]').val(data.device_type);
                        $('[name="device_current_status"]').val(data.device_current_status);
                        $('[name="config_file"]').val(data.config_file);
                        $('[name="activation_timestamp"]').val(data.activation_timestamp);

                        // Open modal at step 1
                        $('#modalTitle').text('Edit Infinity3065 - Step 1 of 4');
                        step = 1;
                        showStep(step);
                        $('#crudModal').modal('show');
                    } else {
                        $('#loader_overlay').hide();
                        $('form')[0].reset();
                        Swal.fire('Error', 'Failed to load record data', 'error');
                    }
                }).fail(function () {
                    $('#loader_overlay').hide();
                    $('form')[0].reset();
                    Swal.fire('Error', 'Failed to load record data', 'error');
                });
            });


            $(document).on('submit', '#crudForm', function (e) {
                e.preventDefault();

                let formData = $(this).serialize();
                let mode = $('[name="form_mode"]').val();
                let slno = $('select[name="slno"]').val();

                if (mode === 'create') {

                    $.post({
                        url: '{{ route("provisioning.infinity3065.store") }}',
                        data: formData + '&_token={{ csrf_token() }}',
                        success: function (res) {
                            $('#loader_overlay').hide();
                            $('#filterForm')[0].reset();
                            Swal.fire('Success', res.message, 'success');
                            $('#crudModal').modal('hide');
                            table.ajax.reload();
                        },
                        error: function (xhr) {
                            handleErrors(xhr);
                            $('#filterForm')[0].reset();
                            $('#loader_overlay').hide();

                        }
                    });
                } else if (mode === 'edit') {

                    $.ajax({
                        url: `/provisioning/infinity3065/update/${slno}`,
                        type: 'POST',   // still POST, but we spoof PUT
                        data: formData,
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        success: function (res) {
                            $('#loader_overlay').hide();
                            $('#filterForm')[0].reset();
                            Swal.fire('Updated', res.message, 'success');
                            $('#crudModal').modal('hide');
                            table.ajax.reload();
                        },
                        error: function (xhr) {
                            handleErrors(xhr);
                            $('#filterForm')[0].reset();
                            $('#loader_overlay').hide();
                        }
                    });
                }
            });

            // common error handler
            function handleErrors(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMsg = '';
                    $.each(errors, function (key, value) {
                        errorMsg += value[0] + '\n';
                    });
                    Swal.fire('Validation Error', errorMsg, 'error');
                } else {
                    Swal.fire('Error', 'Something went wrong', 'error');
                }
            }


            $(document).on('click', '.deleteBtn', function () {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This record will be deleted!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post('{{ route("provisioning.infinity3065.delete") }}',
                            { id: id, _token: '{{ csrf_token() }}' },
                            function (response) {
                                $('#loader_overlay').hide();
                                Swal.fire('Deleted!', 'Record has been deleted.', 'success');
                                table.ajax.reload();
                            }
                        ).fail(function () {
                            $('#loader_overlay').hide();
                            Swal.fire('Error', 'Failed to delete record', 'error');
                        });
                    }
                });
            });

            // -------- Bulk Delete --------
            $('#bulkDeleteBtn').click(() => {
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
                        $.post('{{ route("provisioning.infinity3065.bulkDelete") }}',
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
    <style>
        #infinity3065-table_wrapper {
            padding: 10px !important;
        }

        #infinity3065-table {
            padding-top: 10px !important;
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }

        #reviewContent ul {
            margin-bottom: 15px;
        }

        #reviewContent li {
            margin-bottom: 8px;
            padding-bottom: 8px;
            border-bottom: 1px solid #eee;
        }
    </style>
@endsection