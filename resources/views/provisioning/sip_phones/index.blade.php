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
                            </svg></a> SIP Phones
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
                                            <label class="form-label">Vendor</label>
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
                                            <label class="form-label">Template Name</label>
                                            <input type="text" name="template_name" class="form-control">
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
                    <button id="pushSelected" class="btn btn-primary">Push Configuration To Public Server</button>
                </div>
                <div class="col-md-6 text-end">
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


@endsection