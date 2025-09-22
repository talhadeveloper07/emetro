@extends('layouts.admin')

@section('content')
    <style>

        .details-container {
            padding: 0.75rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 0.75rem;
        }
        .details-container .card {
            border: none;
            border-radius: 8px;
            height: 100%;
            width: 100%;
            box-sizing: border-box;
        }
        .details-container .card:hover {
        }
        .details-container .card-body {
            padding: 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            height: 100%;
            box-sizing: border-box;
        }
        .details-container .icon {
            width: 32px;
            height: 32px;
            margin-bottom: 0.75rem;
            color: var(--primary-color);
        }
        .details-container .card-title {
            font-size: 0.85rem;
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.4rem;
        }
        .details-container .card-text {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 0;
            word-break: break-word;
        }
        @media (max-width: 768px) {
            .details-container {
                grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
                padding: 0.5rem;
            }
            .details-container .card-body {
                padding: 0.75rem;
            }
            .details-container .icon {
                width: 28px;
                height: 28px;
                margin-bottom: 0.5rem;
            }
            .details-container .card-title {
                font-size: 0.8rem;
            }
            .details-container .card-text {
                font-size: 0.75rem;
            }
        }
        @media (max-width: 576px) {
            .details-container {
                grid-template-columns: 1fr;
            }
        }
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
                    <!-- Page pre-title -->

                    <h2 class="page-title">
                        <a href="{{route('provisioning.infinity7')}}"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg></a>   Phone Details
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
            <div class="details-container mb-3 mt-1">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">MAC Address</h5>
                        <p class="card-text">00:1A:2B:3C:4D:5E or 00-1A-2B-3C-4D-5E</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="row">
                    <div class="col-12 d-flex flex-column">
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
                                            <input  type="text" id="edit-slno" name="parent_slno" value="2504058165" class="form-control">
                                        </div>
                                        <div class="col-md-2 col-sm-12 mb-3">
                                            <label class="form-label">Status</label>
                                            <input type="text" value="Assigned" class="form-control" readonly disabled>
                                        </div>
                                        <div class="col-md-2 col-sm-12 mb-3">
                                            <label class="form-label">Registration</label>
                                            <input type="text"
                                                   value="{{ now()->format('d-m-Y H:i') }}"
                                                   class="form-control"
                                                   readonly
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-sm-12 mb-3">
                                            <label class="form-label">Hostname/IP 1</label>
                                            <input  type="text" id="edit-s1-ip" name="s1_ip" value="milanodemo.emetrotel.net" class="form-control">
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
                                            <input  type="text" id="edit-s2-ip" name="s2_ip" value="35.152.55.91" class="form-control">
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
                                      <h2 class="text-lime">Applications</h2>
                                        <div class="col-md-3 col-sm-12 mb-3">
                                            <label class="form-label">Infinity One URL</label>
                                            <input id="edit-infinityone-url" name="infinityone_url"  type="text" value="https://milanodemo.emetrotel.net:21326"
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
                                    <button type="button" class="btn btn-primary">Update</button>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
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
