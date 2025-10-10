@extends('layouts.admin')

@section('content')

    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        <a href="{{ route('provisioning.dect') }}"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M15 6l-6 6l6 6" />
                            </svg></a>Station Details
                    </h2>
                </div>
                <!-- Page title actions -->

            </div>
        </div>
    </div>
    <div class="page-body">

        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h2>Station Details</h2>
                        </div>
                        <div class="card-body">

                            <div id="updateCardContent">

                                <div class="card-body">
                                    <ul class="nav nav-tabs card-header-tabs nav-fill mb-4" data-bs-toggle="tabs"
                                        role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a href="#tabs-server" class="nav-link active" data-bs-toggle="tab"
                                                aria-selected="true" role="tab">Server</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a href="#tabs-extensions" class="nav-link" data-bs-toggle="tab"
                                                aria-selected="false" role="tab">Extensions</a>
                                        </li>
                                    </ul>

                                    <div class="tab-content">
                                        <!-- Profile Tab -->
                                        <div class="tab-pane active show" id="tabs-server" role="tabpanel">
                                            <form action="" id="dectEditForm" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $dectData->id }}">
                                                <div class="row">
                                                    <div class="col-md-3 col-sm-12 mb-3">
                                                        <label class="form-label">Mac Address</label>
                                                        <input type="text" name="mac_address" class="form-control"
                                                            value="{{ $dectData->mac }}" readonly>
                                                        <input type="hidden" name="slno" id="slno">
                                                    </div>
                                                    <div class="col-md-3 col-sm-12 mb-3">
                                                        <label class="form-label">UCX SN</label>
                                                        <input type="text" readonly name="ucs_sn" class="form-control"
                                                            value="{{ $dectData->slno }}">
                                                    </div>
                                                    <div class="col-md-3 col-sm-12 mb-3">
                                                        <label class="form-label">Model</label>
                                                        <select id="edit-status" name="model"
                                                            class="form-control form-select">
                                                            <option value="" selected="selected">(Select Model)</option>
                                                            <option value="AP500D/AP510D" {{ $dectData->model == "AP500D/AP510D" ? 'selected' : '' }}>AP500D/AP510D</option>
                                                            <option value="AP500M/AP510M" {{ $dectData->model == "AP500M/AP510M" ? 'selected' : '' }}>AP500M/AP510M</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-3 col-sm-12 mb-3">
                                                        <label class="form-label">SIP Mode</label>
                                                        <select id="edit-status" name="sip_mode"
                                                            class="form-control form-select">
                                                            <option value="udp" selected="selected">UDP</option>
                                                            <option value="tcp">TCP</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 col-sm-12 mb-3">
                                                        <label class="form-label">SIP Server Address</label>
                                                        <input type="number" step="1" min="0" name="sip_server_address"
                                                            value="{{ $dectData->sip_server_address }}"
                                                            class="form-control">
                                                    </div>
                                                    <div class="col-md-3 col-sm-12 mb-3">
                                                        <label class="form-label">SIP Server Port</label>
                                                        <input type="number" step="1" min="0" name="sip_server_port"
                                                            value="{{ $dectData->sip_server_port }}" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3 col-sm-12 mb-3">
                                                        <label class="form-label">Time Server</label>
                                                        <input type="number" step="1" min="0" name="time_server"
                                                            value="{{ $dectData->time_server }}" class="form-control">
                                                    </div>
                                                    <div class="col-md-3 col-sm-12 mb-3">
                                                        <label class="form-label">Country</label>
                                                        <select name="country" id="country" class="form-control">
                                                            <option value="">Select Country</option>
                                                            @foreach($countryRowOptions as $country => $code)
                                                                <option value="{{ $code }}" {{ $dectData->country == $code ? 'selected' : '' }}>{{ $country }}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                    <div class="col-md-3 col-sm-12 mb-3">
                                                        <label class="form-label">Region</label>
                                                        <select name="region" id="region" class="form-control">
                                                            <option value="">Select Region</option>
                                                            @if(!empty($dectData->country) && isset($regionOptions[$dectData->country]))
                                                                @foreach($regionOptions[$dectData->country] as $region => $code)
                                                                    <option value="{{ $code }}" {{ old('region', $dectData->region ?? '') == $code ? 'selected' : '' }}>{{ $region }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-3 col-sm-12 mb-3">
                                                        <label class="form-label">Primary MAC</label>
                                                        <input type="text" name="s2_ip_address" class="form-control"
                                                            value="{{ $dectData->primary_mac }}">
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </form>
                                        </div>

                                        <!-- Network Tab -->
                                        <div class="tab-pane" id="tabs-extensions" role="tabpanel">
                                            <div class="row">
                                                <div class="col-md-2 col-sm-12 mb-3">
                                                    <label class="form-label">Select CSV file for upload</label>
                                                    <input type="file" style="border:1px solid lightgray;padding:10px;">
                                                </div>
                                            </div>
                                            <div class="row mt-4 align-items-end">
                                                <div class="col-md-6"><strong>Total no of extensions: 2</strong></div>
                                                <div class="col-md-6 text-end">
                                                    <button type="button" class="btn btn-primary">
                                                        UPDATE Index
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table id="dect_table"
                                                            class="table table-bordered table-striped w-100">
                                                            <thead>
                                                                <tr>
                                                                    <th class="w-1">
                                                                        <input class="all-select" type="checkbox"
                                                                            aria-label="Select all">
                                                                    </th>
                                                                    <th>Extension</th>
                                                                    <th>Secret</th>
                                                                    <th>Display Name</th>
                                                                    <th>Index</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
                                                        <button type="submit" class="btn btn-danger" id="delete-selected">
                                                            DELETE selected extensions
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>


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
                const table = $('#dect_table').DataTable({
                    ajax: '{{ route("provisioning.dect.details", $dectId) }}',
                    columns: [
                        { data: "checkbox", title: '<input type="checkbox" class="form-check-input all-select" />', orderable: false },
                        { data: "extension", title: "Extension" },
                        { data: "secret", title: "Secret" },
                        { data: "display_name", title: "Display Name" },
                        { data: "port", title: "Index" }
                    ],
                    paging: true,
                    searching: false,
                    ordering: true,
                    info: false,
                });

                // Select all checkboxes
                $(document).on('change', '.all-select', function () {
                    $('.row-select').prop('checked', this.checked);
                });

                // 🔥 Update index on change
                $(document).on('change', '.dect_ports', function () {
                    let index = $(this).val();
                    let dectExtensionId = $(this).data('dect-extension');

                    $.ajax({
                        url: '{{ route("provisioning.dect.updateExtensionIndex") }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            dect_extension_id: dectExtensionId,
                            index: index
                        },
                        success: function (response) {
                            if (response.status === 'success') {
                                Swal.fire('Success', response.message || 'Index Updated successfully', 'success');

                            } else {
                                Swal.fire('Error', response.message || 'Update failed', 'error');
                            }
                        },
                        error: function (xhr) {
                            Swal.fire('Error', 'Something went wrong', 'error');

                        }
                    });
                });

                // ✅ Select/Deselect All
                $('#dect_table').on('change', '.all-select', function () {
                    const isChecked = $(this).prop('checked');
                    $('#dect_table tbody .row-select').prop('checked', isChecked);
                });

                // ✅ Uncheck "Select All" if any single checkbox is unchecked
                $('#dect_table').on('change', '.row-select', function () {
                    const total = $('#dect_table tbody .row-select').length;
                    const checked = $('#dect_table tbody .row-select:checked').length;
                    $('.all-select').prop('checked', total === checked);
                });



                $('#delete-selected').on('click', function (e) {
                    e.preventDefault();

                    const selectedIds = $('.row-select:checked').map(function () {
                        return $(this).data('id');
                    }).get();

                    if (selectedIds.length === 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'No selection',
                            text: 'Please select at least one extension to delete.',
                            confirmButtonColor: '#3085d6',
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this action!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete them!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route("provisioning.dect.deleteExtensions") }}',
                                method: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    ids: selectedIds
                                },
                                success: function (response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: response.message,
                                        timer: 1500,
                                        showConfirmButton: false
                                    });
                                    table.ajax.reload();
                                    $('.all-select').prop('checked', false);
                                },
                                error: function (xhr) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Something went wrong while deleting extensions.'
                                    });
                                    console.error(xhr.responseText);
                                }
                            });
                        }
                    });
                });
            });
        </script>

        <script>
            const regionOptions = @json($regionOptions);

            $('#country').on('change', function () {
                let countryCode = $(this).val();
                let regionSelect = $('#region');
                regionSelect.empty().append('<option value="">Select Region</option>');

                if (countryCode && regionOptions[countryCode]) {
                    $.each(regionOptions[countryCode], function (regionName, code) {
                        regionSelect.append(`<option value="${code}">${regionName}</option>`);
                    });
                }
            });
        </script>

<script>
$(document).ready(function() {
    $('#dectEditForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('provisioning.dect.update', $dectData->id) }}", // your update route
            method: "POST",
            data: $(this).serialize(),
            beforeSend: function() {
                // Optional: show loading state
                Swal.fire({
                    title: 'Updating...',
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
                        title: 'Updated!',
                        text: 'Record updated successfully!',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
        $('#loader_overlay').hide();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Update failed.'
                    });
                }
            },
            error: function(xhr) {
                Swal.close();
        $('#loader_overlay').hide();

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong while updating.'
                });
            }
        });
    });
});
</script>



    @endsection
@endsection