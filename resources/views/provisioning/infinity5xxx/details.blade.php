@extends('layouts.admin')

@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        <a href="{{ route('provisioning.infinity5') }}">
                            <!-- Back Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M15 6l-6 6l6 6" />
                            </svg>
                        </a>
                        Details
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="details-container mb-3 mt-1">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Phone Details</h5>
                        <div class="d-flex gap-3 flex-wrap">
                            <span class="card-text"><strong>SN:</strong> {{ $record->product_slno ?? 'N/A' }}</span> |
                            <span class="card-text"><strong>MAC:</strong> {{ $record->mac_address_0 ?? 'N/A' }}</span> |
                            <span class="card-text">{{ $record->product_code ?? 'N/A' }}</span> |
                            <span class="card-text"><strong>UCX SN:</strong> {{ $record->ucx_sn ?? 'N/A' }}</span> |
                            <span class="card-text">{{ $record->site_name ?? 'N/A' }}</span>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card">

                <div id="updateCardContent">

                    <form id="comprehensiveUpdateForm">
                        <div class="card-body">
                            <ul class="nav nav-tabs card-header-tabs nav-fill mb-4" data-bs-toggle="tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a href="#tabs-profile" class="nav-link active" data-bs-toggle="tab"
                                        aria-selected="true" role="tab">Profile</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="#tabs-network" class="nav-link" data-bs-toggle="tab" aria-selected="false"
                                        role="tab">Network</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="#tabs-updates" class="nav-link" data-bs-toggle="tab" aria-selected="false"
                                        role="tab">Updates</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="#tabs-custom" class="nav-link" data-bs-toggle="tab" aria-selected="false"
                                        role="tab">Custom</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <!-- Profile Tab -->
                                <div class="tab-pane active show" id="tabs-profile" role="tabpanel">
                                    <div class="row">
                                        <!-- <div class="col-md-3 col-sm-12 mb-3">
                                            <label class="form-label">UCX Serial Number</label>
                                            <input type="text" name="parent_slno" class="form-control"
                                                value="{{ $record->ucx_sn ?? '' }}" readonly>
                                            <input type="hidden" name="slno" id="slno" value="{{ $record->product_slno }}">
                                        </div> -->
                                        <div class="col-md-3 col-sm-12 mb-3">
                                            <label class="form-label">Status</label>
                                            <input type="text"
                                                value="{{ $record->status === 'Activated' ? 'Registered' : $record->status }}"
                                                readonly name="status" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-sm-12 mb-3">
                                            <label class="form-label">Activation Date</label>
                                            <input type="text" name='activation_date' readonly value="{{ $record->activation_date }}" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-sm-12 mb-3">
                                            <label class="form-label">Expiry Date</label>
                                            <input type="text"name='expiry_date' readonly value="{{ $record->expiry_date }}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 col-sm-12 mb-3">
                                            <label class="form-label">Hostname/IP 1</label>
                                            <input type="text" name="s1_ip_address" class="form-control"
                                                value="{{ $record->s1_ip_address ?? '' }}">
                                        </div>
                                        <div class="col-md-2 col-sm-12 mb-3">
                                            <label class="form-label">S1 Port</label>
                                            <input type="number" step="1" min="0" name="s1_default_port"
                                                class="form-control" value="{{ $record->s1_default_port ?? 7000 }}">
                                        </div>
                                        <div class="col-md-2 col-sm-12 mb-3">
                                            <label class="form-label">S1 Retries</label>
                                            <input type="number" step="1" min="0" name="s1_retry_port" class="form-control"
                                                value="{{ $record->s1_retry_port ?? 1 }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 col-sm-12 mb-3">
                                            <label class="form-label">Hostname/IP 2</label>
                                            <input type="text" name="s2_ip_address" class="form-control"
                                                value="{{ $record->s2_ip_address ?? '' }}">
                                        </div>
                                        <div class="col-md-2 col-sm-12 mb-3">
                                            <label class="form-label">S2 Port</label>
                                            <input type="number" step="1" min="0" name="s2_default_port"
                                                class="form-control" value="{{ $record->s2_default_port ?? 7000 }}">
                                        </div>
                                        <div class="col-md-2 col-sm-12 mb-3">
                                            <label class="form-label">S2 Retries</label>
                                            <input type="number" step="1" min="0" name="s2_retry_port" class="form-control"
                                                value="{{ $record->s2_retry_port ?? 1 }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 col-sm-12 mb-3">
                                            <label class="form-label">Site Name</label>
                                            <input type="text" name="site_name" class="form-control"
                                                value="{{ $record->site_name ?? '' }}">
                                        </div>
                                        <div class="col-md-3 col-sm-12 mb-3">
                                            <label class="form-label">Installed By</label>
                                            <input type="text" name="installed_by" class="form-control"
                                                value="{{ $record->installed_by ?? '' }}">
                                        </div>

                                    </div>
                                </div>

                                <!-- Network Tab -->
                                <div class="tab-pane" id="tabs-network" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-2 col-sm-12 mb-3">
                                            <label class="form-label">DHCP VLAN</label>
                                            <select name="dhcp_vlan_active" id="dhcp_vlan" class="form-control">
                                                <option selected>(Select)</option>
                                                <option value="enable">Enable</option>
                                                <option value="disable">Disable</option>
                                            </select>
                                        </div>
                                        <h3 class="text-lime">VLAN WAN Port</h3>
                                        <div class="col-md-2 col-sm-12 mb-3">
                                            <label class="form-label">Active</label>
                                            <select name="wan_port_active" id="vlan_wan_port" class="form-control">
                                                <option selected>(Select)</option>
                                                <option value="enable">Enable</option>
                                                <option value="disable">Disable</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-sm-12 mb-3">
                                            <label class="form-label">VID</label>
                                            <input type="text" name="wan_port_vid" class="form-control"
                                                value="{{ $record->vlan_id ?? '' }}">
                                        </div>
                                        <div class="col-md-2 col-sm-12 mb-3">
                                            <label class="form-label">Priority</label>
                                            <input type="text" name="wan_port_priority" class="form-control"
                                                value="{{ $record->wan_port_priority ?? '' }}">
                                        </div>
                                        <h3 class="text-lime">VLAN PC Port</h3>
                                        <div class="col-md-2 col-sm-12 mb-3">
                                            <label class="form-label">Active</label>
                                            <select name="pc_port_active" id="pc_port_active" class="form-control">
                                                <option selected>(Select)</option>
                                                <option value="enable">Enable</option>
                                                <option value="disable">Disable</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-sm-12 mb-3">
                                            <label class="form-label">VID</label>
                                            <input type="text" name="pc_port_vid" class="form-control"
                                                value="{{ $record->pc_port_vid ?? '' }}">
                                        </div>
                                        <h3 class="text-lime">WIFI</h3>
                                        <div class="col-md-2 col-sm-12 mb-3">
                                            <label class="form-label">Active</label>
                                            <select name="wifi_active" id="wifi_active" class="form-control">
                                                <option selected>(Select)</option>
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-sm-12 mb-3">
                                            <label class="form-label">Mode</label>
                                            <select name="wifi_mode" id="wifi_mode" class="form-control">
                                                <option selected>(Select)</option>
                                                <option value="manual">Manual</option>
                                                <option value="provision">Provision</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-sm-12 mb-3">
                                            <label class="form-label">SSID</label>
                                            <input type="text" name="wifi_ssid" class="form-control"
                                                value="{{ $record->wifi_ssid ?? '' }}">
                                        </div>
                                        <div class="col-md-2 col-sm-12 mb-3">
                                            <label class="form-label">Security Mode</label>
                                            <select name="wifi_security_mode" class="form-control form-select">
                                                <option value="">(Select)</option>
                                                <option value="none">None</option>
                                                <option value="WEP mode">WEP mode</option>
                                                <option value="WEP PSK mode">WEP PSK mode</option>
                                                <option value="WEP mode">WEP mode</option>
                                                <option value="WPA2 PSK mode">WPA2 PSK mode</option>

                                            </select>
                                        </div>
                                        <div class="col-md-2 col-sm-12 mb-3">
                                            <label class="form-label">Password</label>
                                            <input type="text" name="wifi_password" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <!-- Services Tab -->
                                <div class="tab-pane" id="tabs-updates" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-12 mb-3">
                                            <label class="form-label">Firmware Upgrade Mode</label>
                                            <select name="firmware_upgrade_mode" class="form-control form-select">
                                                <option value="">(Select)</option>
                                                <option value="TFTP">TFTP</option>
                                                <option value="HTTP">HTTP</option>
                                                <option value="FTP">FTP</option>
                                                <option value="HTTPS">HTTPS</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-sm-12 mb-3">
                                            <label class="form-label mb-0">Firmware Server Path</label>
                                            <span>repo.uc-x.org/infinity.fw</span>
                                            <input type="text" name="firmwire_server_path" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-sm-12 mb-3">
                                            <label class="form-label mb-0">Configuration Server Path</label>
                                            <span>repo.uc-x.org/infinity.cfg</span>
                                            <input type="text" name="configuration_server_path" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-sm-12 mb-3">
                                            <label class="form-label">Auto Firmware Upgrade</label>
                                            <select name="auto_upgrade" class="form-control form-select">
                                                <option value="">(Select)</option>
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-sm-12 mb-3">
                                            <label class="form-label">Upgrade EXP Firmware</label>
                                            <select name="upgrade_exp_rom" class="form-control form-select">
                                                <option value="">(Select)</option>
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-sm-12 mb-3">
                                            <label class="form-label">Check for upgrade every(minutes)</label>
                                            <input type="text" name="check_upgrade_times" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-sm-12 mb-3">
                                            <label class="form-label mb-0">Screen Saver Server URL</label>
                                            <span>(e.g. tftp://192.168.1.200/image.jpg)</span>
                                            <input type="text" name="screansaver_server_url" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-sm-12 mb-3">
                                            <label class="form-label mb-0">Wallpaper Server URL</label>
                                            <span>(e.g. tftp://192.168.1.200/wallpaper.jpg)</span>
                                            <input type="text" name="wallpaper_server_url" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-sm-12 mb-3">
                                            <label class="form-label">Admin Password</label>
                                            <input type="password" name="admin_pass" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <!-- Updates Tab -->
                                <div class="tab-pane" id="tabs-custom" role="tabpanel">
                                    <div id="parameters-wrapper">
                                        <div class="row parameter-row">
                                            <div class="col-md-3 col-sm-12 mb-3">
                                                <label class="form-label">PCODE</label>
                                                <input type="text" name="pcode[]" class="form-control">
                                            </div>
                                            <div class="col-md-3 col-sm-12 mb-3">
                                                <label class="form-label">Value</label>
                                                <div class="input-group">
                                                    <input type="text" name="pcode_value[]" class="form-control">
                                                    <button type="button" class="btn btn-danger remove-row">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Add Button -->
                                    <div class="mb-3">
                                        <button type="button" id="add-parameter" class="btn btn-primary">
                                            +Add Parameter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row m-3">
                            <div class="col-md-6">
                                <a class="btn btn-secondary" href="{{ route('provisioning.infinity5') }}">
                                    Back
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                            <div class="col-md-6 text-end">
                            <a href="{{ route('provisioning.infinity5xxx.download', ['slno' => $record->product_slno ?? 'test']) }}" 
   class="btn btn-primary">
   Download XML
</a>

                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const wrapper = document.getElementById("parameters-wrapper");
            const addBtn = document.getElementById("add-parameter");

            // Add new row
            addBtn.addEventListener("click", function () {
                const row = document.createElement("div");
                row.classList.add("row", "parameter-row");
                row.innerHTML = `
                    <div class="col-md-3 col-sm-12 mb-3">
                        <label class="form-label">PCODE</label>
                        <input type="text" name="pcode[]" class="form-control">
                    </div>
                    <div class="col-md-3 col-sm-12 mb-3">
                        <label class="form-label">Value</label>
                        <div class="input-group">
                            <input type="text" name="pcode_value[]" class="form-control">
                            <button type="button" class="btn btn-danger remove-row">
                                <i class="ti ti-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
                wrapper.appendChild(row);
            });

            // Delete row (event delegation)
            wrapper.addEventListener("click", function (e) {
                if (e.target.closest(".remove-row")) {
                    e.target.closest(".parameter-row").remove();
                }
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#comprehensiveUpdateForm').on('submit', function (e) {
                e.preventDefault();

                const id = $('#slno').val();
                const url = "{{ route('provisioning.infinity5xxx.update', ':id') }}".replace(':id', id);

                $.ajax({
                    url: url,
                    type: "POST", // Laravel requires _method=PUT for updates
                    data: $(this).serialize() + "&_method=PUT",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {
                        console.log("Sending request..."); // debug
                    },
                    success: function (response) {
                        console.log(response);
                        Swal.fire('Success', response.success || 'Updated successfully', 'success');
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Error', xhr.responseJSON?.error || 'Update failed', 'error');
                    }
                });
            });
        });

    </script>

@endsection