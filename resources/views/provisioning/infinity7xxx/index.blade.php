@extends('layouts.admin')

@section('content')
    <style>
        .nav-fill .nav-item, .nav-fill>.nav-link {
            height: 60px;
        }
        .nav-fill .nav-item .nav-link, .nav-justified .nav-item .nav-link {
            width: 100%;
            height: 100%;
        }
    </style>
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        <a href="{{route('provisioning.index')}}"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg></a>   Infinity 7XXX
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">


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
                        <form action="{{ route('provisioning.infinity7') }}" method="get">
                            <div class="card-body">
                                <div class="row row-cards">

                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Organization</label>
                                            <select id="organization" name="org_id"
                                                    class="form-control mb-3 select2">
                                                <option value="">All</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Phone Type</label>
                                            <input type="text" name="phome_type" class="form-control">
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



                                    <div class="col-sm-12 col-md-12  text-end">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        @php
                                            $hasFilters = collect(request()->except('_token'))->filter()->isNotEmpty();
                                        @endphp

                                        @if($hasFilters)
                                            <a href="{{ route('provisioning.infinity7') }}" class="btn btn-secondary">Clear Filter</a>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-selectable card-table table-vcenter text-nowrap datatable">
                                <thead>
                                <tr>
                                    <th class="w-1">
                                        <input class="form-check-input m-0 align-middle all-select" type="checkbox" aria-label="Select all">
                                    </th>
                                    <th>Serial Number</th>
                                    <th>MAC Address</th>
                                    <th>Phone Type</th>
                                    <th>UCX SN</th>
                                    <th>S1 Ip and Port</th>
                                    <th>S2 Ip and Port</th>
                                    <th>Organization</th>
                                    <th>Status</th>
                                    <th>Site Name</th>
                                    <th>Last modified Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <input class="form-check-input m-0 align-middle table-selectable-check single-select" type="checkbox" aria-label="Select">
                                    </td>
                                    <td><a href="{{route('provisioning.infinity7_details','2504058165')}}">2504058165</a></td>
                                    <td>00:1A:2B:3C:4D:5E</td>
                                    <td>HPINFC-7004</td>
                                    <td>2504058165</td>
                                    <td>192.168.1.1:80</td>
                                    <td>192.168.1.1:80</td>
                                    <td>E-MetroTel America</td>
                                    <td>Registered</td>
                                    <td>E-MetroTel Europe</td>
                                    <td>7/26/2025</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <button class="btn btn-primary me-3" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#updateCardContent"
                                    aria-expanded="true" aria-controls="updateCardContent">
                                <!-- Plus icon shown by default -->
                                <svg id="iconPlus" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-plus m-0">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                <!-- Minus icon hidden initially -->
                                <svg id="iconMinus" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-minus m-0" style="display:none;">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M5 12l14 0" />
                                </svg>
                            </button>
                            <h2 class="text-lime mb-0">Update Selected Entries</h2>

                        </div>
                        <div id="updateCardContent" class="collapse ">
                         <form action="#">
                            <div class="card-body">
                                <ul class="nav nav-tabs card-header-tabs nav-fill mb-4" data-bs-toggle="tabs"
                                    role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a href="#tabs-porfile" class="nav-link active" data-bs-toggle="tab"
                                           aria-selected="true" role="tab">Profile</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a href="#tabs-network" class="nav-link" data-bs-toggle="tab"
                                           aria-selected="false" role="tab" tabindex="-1">Network</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a href="#tabs-services" class="nav-link" data-bs-toggle="tab"
                                           aria-selected="false" role="tab" tabindex="-1">Services</a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a href="#tabs-updates" class="nav-link" data-bs-toggle="tab"
                                           aria-selected="false" role="tab" tabindex="-1">Updates</a>
                                    </li>

                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane active show" id="tabs-porfile" role="tabpanel">
                                        <h2 class="text-lime">System Details</h2>
                                        <div class="row">

                                            <div class="col-md-3 col-sm-12 mb-3">
                                                <label class="form-label required">UCX Serial Number</label>
                                                <input  type="text" id="edit-slno" name="parent_slno" value="" class="form-control">
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-12 mb-3">
                                                <label class="form-label">Hostname/IP 1</label>
                                                <input  type="text" id="edit-s1-ip" name="s1_ip" value="" class="form-control">
                                            </div>
                                            <div class="col-md-2 col-sm-12 mb-3">
                                                <label class="form-label">S1 Port</label>
                                                <input  type="number" step="1" min="0" name="s1_port" value="7000" class="form-control">
                                            </div>
                                            <div class="col-md-2 col-sm-12 mb-3">
                                                <label class="form-label">S1 Retries</label>
                                                <input  type="number" step="1" min="0" name="s1_retry_number" value="1" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-12 mb-3">
                                                <label class="form-label">Hostname/IP  2</label>
                                                <input  type="text" id="edit-s2-ip" name="s2_ip" value="" class="form-control">
                                            </div>
                                            <div class="col-md-2 col-sm-12 mb-3">
                                                <label class="form-label">S2 Port</label>
                                                <input  type="number" step="1" min="0" name="s2_port" value="7000" class="form-control">
                                            </div>
                                            <div class="col-md-2 col-sm-12 mb-3">
                                                <label class="form-label">S2 Retries</label>
                                                <input  type="number" step="1" min="0"  name="s2_retry_number" value="1" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-12 mb-3">
                                                <label class="form-label ">Allow Multiple Profile</label>
                                                <div>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input"  type="radio" name="allow_multiple_profile" value="1" >
                                                        <span class="form-check-label">Yes</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="allow_multiple_profile" value="0" checked>
                                                        <span class="form-check-label">No</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12 mb-3">
                                                <label class="form-label ">Allow Changes to Default Profile</label>

                                                <div>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="allow_changes_to_default_profile" value="1">
                                                        <span class="form-check-label">Yes</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="allow_changes_to_default_profile" value="0" checked>
                                                        <span class="form-check-label">No</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            {{--                                        <h2 class="text-lime">Applications</h2>--}}
                                            <div class="col-md-3 col-sm-12 mb-3">
                                                <label class="form-label">Infinity One URL</label>
                                                <input id="edit-infinityone-url" name="infinityone_url"  type="text" value=""
                                                       size="60" maxlength="128" class="form-control">
                                            </div>

                                        </div>
                                    </div>

                                    <div class="tab-pane" id="tabs-network" role="tabpanel">
                                        <div class="row">
                                            <div class="col-12 mb-3 ">
                                                <h2 class="text-lime">Network Setting</h2>
                                            </div>
                                            <!-- Ethernet IP Assignment -->
                                            <div class="col-12 mb-4 p-0">
                                                <div class="col-3">
                                                    <label for="network_ip_assignment">Ethernet IP</label>
                                                    <select id="network_ip_assignment" name="network_ip_assignment" class="form-control form-select">
                                                        <!--                          <option value="">(Select)</option>-->
                                                        <option value="DHCP" selected>DHCP</option>
                                                        <option value="Static">Static</option>
                                                    </select>
                                                </div>


                                                <div id="network_ip_fields" class="row mt-3 d-none">
                                                    <div class="col-md-4 col-sm-12 mb-3">
                                                        <label for="network_ip_address">IP Address</label>
                                                        <input type="text" id="network_ip_address" name="network_ip_address" class="form-control" />
                                                    </div>

                                                    <div class="col-md-4 col-sm-12 mb-3">
                                                        <label for="network_subnet_mask">Subnet Mask</label>
                                                        <input type="text" id="network_subnet_mask" name="network_subnet_mask" class="form-control" />
                                                    </div>

                                                    <div class="col-md-4 col-sm-12 mb-3">
                                                        <label for="network_gateway">Gateway</label>
                                                        <input type="text" id="network_gateway" name="network_gateway" class="form-control" />
                                                    </div>

                                                    <div class="col-md-4 col-sm-12 mb-3">
                                                        <label for="network_dns_primary">Primary DNS</label>
                                                        <input type="text" id="network_dns_primary" name="network_dns_primary" class="form-control" />
                                                    </div>

                                                    <div class="col-md-4 col-sm-12 mb-3">
                                                        <label for="network_dns_secondary">Secondary DNS</label>
                                                        <input type="text" id="network_dns_secondary" name="network_dns_secondary" class="form-control" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-sm-12 mb-3">
                                                <label class="form-label">VLAN ID</label>
                                                <input type="text" name="vlan_id" value="" class="form-control">
                                            </div>
                                            <div class="col-md-3 col-sm-12 mb-3">
                                                <label class="form-label">VLAN Priority</label>
                                                <input type="text" name="vlan_priority" value="" class="form-control">
                                            </div>
                                            <div class="col-md-6 col-sm-12"></div>
                                            <div class="col-md-3 col-sm-12 mb-3">
                                                <label class="form-label">Wifi</label>
                                                <select name="wifi" class="form-control form-select">
                                                    <option value="">(Select)</option>
                                                    <option value="ON">ON</option>
                                                    <option value="OFF" >OFF</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-sm-12 mb-3">
                                                <label class="form-label">Bluetooth</label>
                                                <select name="bluetooth" class="form-control form-select">
                                                    <option value="">(Select)</option>
                                                    <option value="ON">ON</option>
                                                    <option value="OFF" >OFF</option>
                                                </select>
                                            </div>
                                            <!-- WiFi IP Assignment -->
                                            <div class="col-12 mb-4 p-0">
                                                <div class="col-3">
                                                    <label for="wifi_ip_assignment">WiFi IP</label>
                                                    <select id="wifi_ip_assignment" name="wifi_ip_assignment" class="form-control  form-select">
                                                        <!--                          <option value="">(Select)</option>-->
                                                        <option value="DHCP" selected>DHCP</option>
                                                        <option value="Static">Static</option>
                                                    </select>
                                                </div>
                                                <div id="wifi_ip_fields" class="row mt-3 d-none">
                                                    <div class="col-md-4 col-sm-12 mb-3">
                                                        <label for="wifi_ip_address">IP Address</label>
                                                        <input type="text" id="wifi_ip_address" name="wifi_ip_address" class="form-control" />
                                                    </div>

                                                    <div class="col-md-4 col-sm-12 mb-3">
                                                        <label for="wifi_subnet_mask">Subnet Mask</label>
                                                        <input type="text" id="wifi_subnet_mask" name="wifi_subnet_mask" class="form-control" />
                                                    </div>

                                                    <div class="col-md-4 col-sm-12 mb-3">
                                                        <label for="wifi_gateway">Gateway</label>
                                                        <input type="text" id="wifi_gateway" name="wifi_gateway" class="form-control" />
                                                    </div>

                                                    <div class="col-md-4 col-sm-12 mb-3">
                                                        <label for="wifi_dns_primary">Primary DNS</label>
                                                        <input type="text" id="wifi_dns_primary" name="wifi_dns_primary" class="form-control" />
                                                    </div>

                                                    <div class="col-md-4 col-sm-12 mb-3">
                                                        <label for="wifi_dns_secondary">Secondary DNS</label>
                                                        <input type="text" id="wifi_dns_secondary" name="wifi_dns_secondary" class="form-control" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12" style="padding: 0">
                                                <div id="wifi-rows-wrapper">
                                                    <div class="wifi-row row align-items-end mb-3">
                                                        <div class="col-md-1 col-sm-12 mb-3 text-center">
                                                            <span class="row-number d-block pt-2 fw-bold">1.</span>
                                                        </div>
                                                        <div class="col-md-3 col-sm-12 mb-3">
                                                            <label class="form-label">SSID</label>
                                                            <input type="text" name="wifi_ssid[]" value="" class="form-control">
                                                        </div>
                                                        <div class="col-md-3 col-sm-12 mb-3">
                                                            <label class="form-label">Security Mode</label>
                                                            <select name="wifi_security_mode[]" class="form-control form-select">
                                                                <option value="" >(Select)</option>
                                                                <option value="WEP mode">WEP mode</option>
                                                                <option value="WPA PSK mode">WPA PSK mode</option>
                                                                <option value="WPA2 PSK mode" >WPA2 PSK mode</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 col-sm-12 mb-3">
                                                            <label class="form-label">Password</label>
                                                            <input type="text" name="wifi_password[]" value="" class="form-control">
                                                        </div>
                                                        <div class="col-md-1 col-sm-12 mb-3 text-center">
                                                            <button type="button" class="btn btn-danger remove-wifi-row mt-4" title="Remove Row">
                                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash m-0"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-12">
                                                    <button type="button" id="add-wifi-row" class="btn btn-primary mt-2">
                                                        + Add Wifi
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabs-services" role="tabpanel">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <h2 class="text-lime">SMS</h2>
                                            </div>
                                            <div class="col-md-3 col-sm-12 mb-3">
                                                <label class="form-label">SMS 1</label>
                                                <select id="sms_did1" name="sms_did1" class="form-control form-select  w-100">
                                                    <option value="">(Select)</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-sm-12 mb-3">
                                                <label class="form-label">SMS 2</label>
                                                <select id="sms_did2" name="sms_did2" class="form-control form-select  w-100">
                                                    <option value="">(Select)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="tabs-updates" role="tabpanel">
                                        <div class="row">
                                            {{--                                        <h2 class="text-lime">Maintenance</h2>--}}
                                            <div class="col-md-3 col-sm-12 mb-3">
                                                <label class="form-label">FW Update Frequency</label>
                                                <select name="swupdate_frequency" class="form-control form-select">
                                                    <option value="" >(Select)</option>
                                                    <option value="Daily" >Daily</option>
                                                    <option value="Weekly" >Weekly</option>
                                                    <option value="Monthly" selected >Monthly</option>
                                                    <option value="Off" >Off</option>

                                                </select>
                                            </div>
                                            <div class="col-md-3 col-sm-12 mb-3">
                                                <label class="form-label">Start Hour</label>
                                                <select name="swupdate_start_hr" class="form-control form-select">
                                                    <option value="">(Select)</option>
                                                    <?php
                                                    for ($i = 0; $i < 24; $i++) {
                                                        $hour = sprintf('%02d', $i); // Format as two-digit string
                                                        $selected = ($hour=="03") ? 'selected' : '';
                                                        print "<option value=\"$hour\" $selected>$hour</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-sm-12 mb-3">
                                                <label class="form-label">End Hour</label>
                                                <select name="swupdate_end_hr" class="form-control form-select">
                                                    <option value="" >(Select)</option>
                                                    <?php
                                                    for ($i = 0; $i < 24; $i++) {
                                                        $hour = sprintf('%02d', $i); // Format as two-digit string
                                                        $selected = ($hour=="04") ? 'selected' : '';
                                                        print "<option value=\"$hour\" $selected>$hour</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mt-3">
                                        <button type="submit" class="btn btn-primary UpdateButton">Update</button>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get DOM elements
            const selectAllCheckbox = document.querySelector('.all-select');
            const singleCheckboxes = document.querySelectorAll('.single-select');
            const updateForm = document.querySelector('.UpdateButton').closest('form');
            const loaderOverlay = document.querySelector('#loader_overlay');

            // Array to store selected row IDs
            let selectedRows = [];

            // Select All checkbox handler
            selectAllCheckbox.addEventListener('change', function() {
                const isChecked = this.checked;

                // Update all single checkboxes
                singleCheckboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                    updateSelectedRows(checkbox);
                });
            });

            // Single checkbox handler
            singleCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateSelectedRows(this);
                    // Update Select All checkbox state
                    updateSelectAllState();
                });
            });

            // Function to update selected rows array
            function updateSelectedRows(checkbox) {
                const row = checkbox.closest('tr');
                const serialNumber = row.querySelector('td:nth-child(2) a').textContent;

                if (checkbox.checked) {
                    if (!selectedRows.includes(serialNumber)) {
                        selectedRows.push(serialNumber);
                    }
                } else {
                    selectedRows = selectedRows.filter(id => id !== serialNumber);
                }
            }

            // Function to update Select All checkbox state
            function updateSelectAllState() {
                const allChecked = Array.from(singleCheckboxes).every(checkbox => checkbox.checked);
                const anyChecked = Array.from(singleCheckboxes).some(checkbox => checkbox.checked);

                selectAllCheckbox.checked = allChecked;
                selectAllCheckbox.indeterminate = anyChecked && !allChecked;
            }

            // Form submission handler
            updateForm.addEventListener('submit', function(e) {
                if (selectedRows.length === 0) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Selection',
                        text: 'You should select at least one serial number',
                        // confirmButtonColor: '#3085d6',
                    });
                    return ;
                }

                // Add hidden input with selected rows to form
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'selected_rows';
                hiddenInput.value = JSON.stringify(selectedRows);
                this.appendChild(hiddenInput);
                $('#loader_overlay').show();

            });
        });
        $(document).ready(function () {

            function updateRowNumbers() {
                $('#wifi-rows-wrapper .wifi-row').each(function (index) {
                    $(this).find('.row-number').text((index + 1) + '.');
                });
            }

            $('#add-wifi-row').on('click', function () {
                const rows = $('.wifi-row');
                if (rows.length >= 3) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Limit Reached',
                        text: 'You can only add up to 3 SSID entries.',
                        // confirmButtonColor: '#3085d6',
                    });
                    return;
                }

                const clone = rows.first().clone();
                clone.find('input').val('');
                clone.find('select').val('');

                $('#wifi-rows-wrapper').append(clone);
                updateRowNumbers();
            });

            $('#wifi-rows-wrapper').on('click', '.remove-wifi-row', function () {
                const rows = $('.wifi-row');
                if (rows.length > 1) {
                    $(this).closest('.wifi-row').remove();
                    updateRowNumbers();
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Action Not Allowed',
                        text: 'At least one SSID row must remain.',
                        // confirmButtonColor: '#3085d6',
                    });
                }
            });

            updateRowNumbers();


            const $networkSelect = $('#network_ip_assignment');
            const $wifiSelect = $('#wifi_ip_assignment');
            const $networkFields = $('#network_ip_fields');
            const $wifiFields = $('#wifi_ip_fields');

            function toggleFields($selectElement, $fieldsContainer) {
                if ($selectElement.val() === 'Static') {
                    $fieldsContainer.removeClass('d-none').addClass('d-flex');
                } else {
                    $fieldsContainer.removeClass('d-flex').addClass('d-none');
                }
            }

            // Initial state
            toggleFields($networkSelect, $networkFields);
            toggleFields($wifiSelect, $wifiFields);

            // Event listeners
            $networkSelect.on('change', function () {
                toggleFields($networkSelect, $networkFields);
            });

            $wifiSelect.on('change', function () {
                toggleFields($wifiSelect, $wifiFields);
            });

        });

    </script>
@endsection
