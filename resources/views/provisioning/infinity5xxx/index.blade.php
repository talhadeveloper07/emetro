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
                            </svg></a> Infinity 5XXX
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <button class="btn btn-primary d-none" id="editSelectedBtn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                <path d="M16 5l3 3" />
                            </svg>
                            Edit Selected
                        </button>
                        <button class="btn btn-danger d-none" id="deleteSelectedBtn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
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
                                            <select id="organization" name="org_id" class="form-control mb-3 select2">
                                                <option value="">All</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Phone Type</label>
                                            <input type="text" name="phone_type" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Phone Serial Number</label>
                                            <input type="text" name="phone_serial_number" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">MAC Address</label>
                                            <input type="text" name="mac_address" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">S1 Ip</label>
                                            <input type="text" name="s1_ip" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">S2 Ip</label>
                                            <input type="text" name="s2_ip" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">UCX Serial Number</label>
                                            <input type="text" name="ucx_serial_number" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select id="edit-status" name="status"
                                                class="form-control form-select select2">
                                                <option value="" selected="selected">(Select)</option>
                                                <option value="Sold To">Sold</option>
                                                <option value="Assigned">Assigned</option>
                                                <option value="Registered">Registered</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 text-end">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <button type="button" id="clearFilters" class="btn btn-secondary">Clear Filter</button>
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
                                id="infinity5xxx_table">
                                <thead>
                                    <tr>
                                        <th class="w-1">
                                            <input class="form-check-input m-0 align-middle all-select" type="checkbox"
                                                aria-label="Select all">
                                        </th>
                                        <th>Phone SN</th>
                                        <th>MAC Address</th>
                                        <th>Phone Type</th>
                                        <th>UCX SN</th>
                                        <th>Organization</th>
                                        <th>Status</th>
                                        <th>Site Name</th>
                                        <th>Last modified Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Infinity 5XXX Record</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form id="editForm">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label required">Serial Number</label>
                                            <input type="text" id="edit-slno" name="slno" class="form-control"
                                                readonly>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">MAC Address</label>
                                            <input type="text" id="edit-mac-address" name="mac_address_0"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Phone Type</label>
                                            <input type="text" id="edit-product-code" name="product_code"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Reseller</label>
                                            <input type="text" id="edit-reseller" name="re_seller"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Status</label>
                                            <select id="edit-status-modal" name="status"
                                                class="form-control form-select">
                                                <option value="Sold To">Sold</option>
                                                <option value="Assigned">Assigned</option>
                                                <option value="Registered">Registered</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">UCX Serial Number</label>
                                            <input type="text" id="edit-parent-slno" name="parent_slno"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Site Name</label>
                                            <input type="text" id="edit-site-name" name="site_name"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Installed By</label>
                                            <input type="text" id="edit-installed-by" name="installed_by"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">S1 IP</label>
                                            <input type="text" id="edit-s1-ip" name="s1_ip" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">S2 IP</label>
                                            <input type="text" id="edit-s2-ip" name="s2_ip" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Update Record</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- COMPREHENSIVE UPDATE FORM SECTION -->
            <div class="row row-deck row-cards mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <button class="btn btn-primary me-3" type="button" data-bs-toggle="collapse"
                                data-bs-target="#updateCardContent" aria-expanded="false"
                                aria-controls="updateCardContent">
                                <svg id="iconPlus" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icon-tabler-plus m-0">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                <svg id="iconMinus" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icon-tabler-minus m-0" style="display:none;">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M5 12l14 0" />
                                </svg>
                            </button>
                            <h2 class="text-lime mb-0">Update Selected Entries 
                                <span id="selectedCountBadge" class="badge bg-primary ms-2 d-none">0 selected</span>
                            </h2>
                        </div>
                        
                        <div id="updateCardContent" class="collapse">
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
                                        <div class="col-md-3 col-sm-12 mb-3">
                                            <label class="form-label">UCX Serial Number</label>
                                            <input type="text" name="parent_slno" class="form-control">
                                        </div>

                                        <div class="col-md-3 col-sm-12 mb-3">
                                            <label class="form-label">Status</label>
                                            <input type="text" readonly name="status" class="form-control">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 col-sm-12 mb-3">
                                            <label class="form-label">Hostname/IP 1</label>
                                            <input type="text" name="s1_ip" class="form-control"
                                                >
                                        </div>
                                        <div class="col-md-2 col-sm-12 mb-3">
                                            <label class="form-label">S1 Port</label>
                                            <input type="number" step="1" min="0" name="s1_port" class="form-control"
                                              >
                                        </div>
                                        <div class="col-md-2 col-sm-12 mb-3">
                                            <label class="form-label">S1 Retries</label>
                                            <input type="number" step="1" min="0" name="s1_retry_number"
                                                class="form-control">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 col-sm-12 mb-3">
                                            <label class="form-label">Hostname/IP 2</label>
                                            <input type="text" name="s2_ip" class="form-control"
                                                >
                                        </div>
                                        <div class="col-md-2 col-sm-12 mb-3">
                                            <label class="form-label">S2 Port</label>
                                            <input type="number" step="1" min="0" name="s2_port" class="form-control"
                                                >
                                        </div>
                                        <div class="col-md-2 col-sm-12 mb-3">
                                            <label class="form-label">S2 Retries</label>
                                            <input type="number" step="1" min="0" name="s2_retry_number"
                                                class="form-control">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 col-sm-12 mb-3">
                                            <label class="form-label">Site Name</label>
                                            <input type="text" name="site_name" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-sm-12 mb-3">
                                            <label class="form-label">Installed By</label>
                                            <input type="text" name="installed_by" class="form-control">
                                        </div>

                                    </div>
                                </div>

                                <!-- Network Tab -->
                                <div class="tab-pane" id="tabs-network" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-2 col-sm-12 mb-3">
                                            <label class="form-label">DHCP VLAN</label>
                                            <select name="dhcp_vlan" id="dhcp_vlan" class="form-control">
                                                <option selected>(Select)</option>
                                                <option value="enable">Enable</option>
                                                <option value="disable">Disable</option>
                                            </select>
                                        </div>
                                        <h3 class="text-lime">VLAN WAN Port</h3>
                                        <div class="col-md-2 col-sm-12 mb-3">
                                            <label class="form-label">Active</label>
                                            <select name="vlan_wan_port" id="vlan_wan_port" class="form-control">
                                                <option selected>(Select)</option>
                                                <option value="enable">Enable</option>
                                                <option value="disable">Disable</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-sm-12 mb-3">
                                            <label class="form-label">VID</label>
                                            <input type="text" name="vlan_id" class="form-control">
                                        </div>
                                        <div class="col-md-2 col-sm-12 mb-3">
                                            <label class="form-label">Priority</label>
                                            <input type="text" name="vlan_priority" class="form-control">
                                        </div>
                                        <h3 class="text-lime">VLAN PC Port</h3>
                                        <div class="col-md-2 col-sm-12 mb-3">
                                            <label class="form-label">Active</label>
                                            <select name="vlan_wan_port" id="vlan_wan_port" class="form-control">
                                                <option selected>(Select)</option>
                                                <option value="enable">Enable</option>
                                                <option value="disable">Disable</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-sm-12 mb-3">
                                            <label class="form-label">VID</label>
                                            <input type="text" name="vlan_id" class="form-control">
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
                                            <select name="wifi_active" id="wifi_active" class="form-control">
                                                <option selected>(Select)</option>
                                                <option value="manual">Manual</option>
                                                <option value="provision">Provision</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-sm-12 mb-3">
                                            <label class="form-label">SSID</label>
                                            <input type="text" name="wifi_ssid" class="form-control">
                                        </div>
                                        <div class="col-md-2 col-sm-12 mb-3">
                                            <label class="form-label">Security Mode</label>
                                            <select name="wifi" class="form-control form-select">
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
                                            <select name="auto_firmware_upgrade" class="form-control form-select">
                                                <option value="">(Select)</option>
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-sm-12 mb-3">
                                            <label class="form-label">Upgrade EXP Firmware</label>
                                            <select name="auto_firmware_upgrade" class="form-control form-select">
                                                <option value="">(Select)</option>
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-sm-12 mb-3">
                                            <label class="form-label">Check for upgrade every(minutes)</label>
                                            <input type="text" name="check_for_upgrades" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-sm-12 mb-3">
                                            <label class="form-label mb-0">Screen Saver Server URL</label>
                                            <span>(e.g. tftp://192.168.1.200/image.jpg)</span>
                                            <input type="text" name="screen_saver_server_url" class="form-control">
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
                                            <input type="password" name="admin_password" class="form-control">
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
                                    
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary btn-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-refresh">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"/>
                                                    <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"/>
                                                </svg>
                                                Update Selected Records
                                            </button>
                                            <button type="button" id="clearFormBtn" class="btn btn-secondary btn-lg ms-2">
                                                Clear Form
                                            </button>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
// Add this function to hide loader
function hideLoader() {
    // Hide any existing loaders
    $('.spinner-border').hide();
    $('.btn:disabled').prop('disabled', false);
    
    // If you have a specific loader overlay, hide it
    $('#loader_overlay').hide();
    
    // Reset button texts
    $('button[type="submit"]').each(function() {
        const originalText = $(this).data('original-text');
        if (originalText) {
            $(this).html(originalText);
        }
    });
}


        $(function() {
            const table = $('#infinity5xxx_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('provisioning.infinity5xxx.data') }}",
                    type: "GET",
                    data: function(d) {
                        d.org_id = $('select[name="org_id"]').val();
                        d.phone_type = $('input[name="phone_type"]').val();
                        d.phone_serial_number = $('input[name="phone_serial_number"]').val();
                        d.mac_address = $('input[name="mac_address"]').val();
                        d.s1_ip = $('input[name="s1_ip"]').val();
                        d.s2_ip = $('input[name="s2_ip"]').val();
                        d.ucx_serial_number = $('input[name="ucx_serial_number"]').val();
                        d.status = $('select[name="status"]').val();
                    }
                },
                columns: [{
                        data: 'checkbox',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'slno'
                    },
                    {
                        data: 'mac_address_0'
                    },
                    {
                        data: 'product_code'
                    },
                    {
                        data: 'parent_slno'
                    },
                    {
                        data: 're_seller'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'site_name'
                    },
                    {
                        data: 'updated'
                    },
                    {
                        data: 'actions',
                        orderable: false,
                        searchable: false,
                        className: 'action-buttons'
                    }
                ],
                lengthChange: false,
                searching: false,
                info: false
            });

            // Multiple selection functionality
            let selectedRows = [];

            // Select all functionality
            $('.all-select').on('change', function() {
                const isChecked = $(this).prop('checked');
                $('.single-select').prop('checked', isChecked);
                updateSelectedRows();
                toggleUpdateSection();
            });

            // Individual checkbox functionality
            $(document).on('change', '.single-select', function() {
                updateSelectedRows();
                toggleUpdateSection();
                updateSelectAllState();
            });

            function updateSelectedRows() {
                selectedRows = [];
                $('.single-select:checked').each(function() {
                    selectedRows.push($(this).val());
                });
                updateSelectedDisplay();
            }

            function toggleUpdateSection() {
                if (selectedRows.length > 0) {
                    // Show the update section
                    $('#updateCardContent').collapse('show');
                    // Update button icons
                    $('#iconPlus').hide();
                    $('#iconMinus').show();
                } else {
                    // Hide the update section if no rows selected
                    $('#updateCardContent').collapse('hide');
                    $('#iconPlus').show();
                    $('#iconMinus').hide();
                }
            }

            function updateSelectedDisplay() {
                const selectedCount = selectedRows.length;
                $('#selectedCountBadge').text(selectedCount + ' selected');
                
                if (selectedCount > 0) {
                    $('#selectedCountBadge').removeClass('d-none');
                    // Show first 5 serial numbers
                    const displayText = selectedRows.slice(0, 5).join(', ') + 
                                       (selectedCount > 5 ? ' and ' + (selectedCount - 5) + ' more...' : '');
                    $('#selectedSerialNumbersList').text(displayText);
                } else {
                    $('#selectedCountBadge').addClass('d-none');
                    $('#selectedSerialNumbersList').text('No records selected');
                }
            }

            function updateSelectAllState() {
                const totalCheckboxes = $('.single-select').length;
                const checkedCheckboxes = $('.single-select:checked').length;
                const selectAll = $('.all-select');

                if (checkedCheckboxes === 0) {
                    selectAll.prop('checked', false);
                    selectAll.prop('indeterminate', false);
                } else if (checkedCheckboxes === totalCheckboxes) {
                    selectAll.prop('checked', true);
                    selectAll.prop('indeterminate', false);
                } else {
                    selectAll.prop('checked', false);
                    selectAll.prop('indeterminate', true);
                }
            }

            // Toggle collapse icons
            $('#updateCardContent').on('show.bs.collapse', function () {
                $('#iconPlus').hide();
                $('#iconMinus').show();
            });

            $('#updateCardContent').on('hide.bs.collapse', function () {
                $('#iconPlus').show();
                $('#iconMinus').hide();
            });

            // Comprehensive Form Submission
            $('#comprehensiveUpdateForm').on('submit', function(e) {
                e.preventDefault();
                
                if (selectedRows.length === 0) {
                    Swal.fire('Warning', 'Please select at least one record to update', 'warning');
                    return;
                }

                const formData = $(this).serializeArray();
                const data = {};
                
                // Only include fields that have values
                formData.forEach(field => {
                    if (field.value.trim() !== '') {
                        data[field.name] = field.value;
                    }
                });
                
                data.selected_rows = selectedRows;

                console.log('Sending update data:', data);

                // Show loading state
                const submitBtn = $(this).find('button[type="submit"]');
                const originalText = submitBtn.html();
                submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...');

                $.ajax({
                    url: "{{ route('provisioning.infinity5xxx.update.multiple') }}",
                    type: "PUT",
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                          hideLoader(); // Hide loader on success
                        Swal.fire('Success', response.success, 'success');
                        table.ajax.reload();
                        // Reset form and selection
                        $('#comprehensiveUpdateForm')[0].reset();
                        selectedRows = [];
                        updateSelectedDisplay();
                        toggleUpdateSection();
                    },
                    error: function(xhr) {
                        console.error('Update error:', xhr.responseJSON);
                        Swal.fire('Error', xhr.responseJSON?.error || 'Update failed', 'error');
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false).html(originalText);
                    }
                });
            });

            // Clear form button
            $('#clearFormBtn').on('click', function() {
                $('#comprehensiveUpdateForm')[0].reset();
            });

            // Filter form submission
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                table.ajax.reload();
            });

            $('#clearFilters').on('click', function() {
                $('#filterForm')[0].reset();
                $('.select2').val(null).trigger('change');
                table.ajax.reload();
            });

            // Single record edit functionality
            $(document).on('click', '.edit-btn', function() {
                const id = $(this).data('id');
                const url = "{{ route('provisioning.infinity5xxx.get', ['id' => ':id']) }}".replace(':id', id);

                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(response) {
                          hideLoader(); // Hide loader on success
                        $('#edit-slno').val(response.slno);
                        $('#edit-mac-address').val(response.mac_address_0);
                        $('#edit-product-code').val(response.product_code);
                        $('#edit-reseller').val(response.re_seller);
                        $('#edit-status-modal').val(response.status === 'Activated' ? 'Registered' : response.status);
                        $('#edit-parent-slno').val(response.parent_slno || '');
                        $('#edit-site-name').val(response.site_name || '');
                        $('#edit-installed-by').val(response.installed_by || '');
                        $('#edit-s1-ip').val(response.s1_ip || '');
                        $('#edit-s2-ip').val(response.s2_ip || '');

                        $('#editForm').data('id', id);
                        $('#editModal').modal('show');
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Failed to load record data', 'error');
                    }
                });
            });

            // Single record update
            $('#editForm').on('submit', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const url = "{{ route('provisioning.infinity5xxx.update', ['id' => ':id']) }}".replace(':id', id);

                $.ajax({
                    url: url,
                    type: "PUT",
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                          hideLoader(); // Hide loader on success
                        $('#editModal').modal('hide');
                        Swal.fire('Success', response.success, 'success');
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        Swal.fire('Error', xhr.responseJSON?.error || 'Update failed', 'error');
                    }
                });
            });

           
        });
    </script>
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
@endsection