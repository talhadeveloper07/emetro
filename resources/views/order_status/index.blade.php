@extends('layouts.admin')

@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Order Status
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
                            <form action="{{route('order_status.index')}}" method="get">
                                <div class="card-body">
                                    <div class="row row-cards">

                                        <div class="col-sm-6 col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">Organization</label>
                                                <select id="organization" name="org_id"
                                                        class="form-control mb-3 select2">
                                                    <option value="">All</option>
                                                    <option value="1421">E-MetroTel (Italy)</option>
                                                    <option value="485">E-MetroTel Americas</option>
                                                    <option value="1995">E-MetroTel Australia</option>
                                                    <option value="868">E-MetroTel Canada</option>
                                                    <option value="1036">E-MetroTel Design</option>
                                                    <option value="1173">E-MetroTel Direct</option>
                                                    <option value="1269">E-MetroTel Guest (Canada)</option>
                                                    <option value="1635">E-MetroTel POC</option>
                                                    <option value="1181">E-MetroTel Test (US)</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">Order Id</label>
                                                <input type="text" name="order_id" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">Type</label>
                                                <select id="type" name="type" class="form-control mb-3 select2">
                                                    <option value="" selected="selected" >All</option>
                                                    <option value="product">Buy Online</option>
                                                    <option value="misc">Miscellaneous</option>
                                                    <option value="newsip">New SIP Configuration</option>
                                                    <option value="new','newapp">New System - Appliance</option>
                                                    <option value="cloud','mincloud">New System - UCX-Cloud</option>
                                                    <option value="virtual_new">New System - Virtualization</option>
                                                    <option value="portsip">SIP Port Configuration</option>
                                                    <option value="assurance">Software Subscription and Hardware Warranty Renewal</option>
                                                    <option value="pick">UCX Product Order</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">PO #</label>
                                                <input type="text" name="po_no" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">Tracking</label>
                                                <input type="text" name="tracking" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">Status</label>
                                                <select id="status" name="status"
                                                        class="form-control form-select select2">
                                                    <option value="" selected="selected">All</option>
                                                    <option value="Received">Received</option>
                                                    <option value="In Progress">In Progress</option>
                                                    <option value="Complete">Complete</option>
                                                    <option value="Abandoned">Abandoned</option>
                                                    <option value="Partial">Partial</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row row-cards">


                                    <div class="col-sm-12 col-md-12  text-end">

                                        <button type="submit" class="btn btn-primary">Filter</button>
                                            @php
                                                $hasFilters = collect(request()->except('_token'))->filter()->isNotEmpty();
                                            @endphp

                                            @if($hasFilters)
                                                <a href="{{ route('order_status.index') }}" class="btn btn-secondary">Clear Filter</a>
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
                                    <th>Order Id</th>
                                    <th>PO #</th>
                                    <th>Date</th>
                                    <th>Organization</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th class="w-1">Details</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>61570</td>
                                    <td></td>
                                    <td>05-22-2025</td>
                                    <td>E-MetroTel Americas</td>
                                    <td>TopUp</td>
                                    <td>Received</td>
                                    <td>
                                        <a href="{{route('order_status.details',1)}}" class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>61569</td>
                                    <td></td>
                                    <td>05-22-2025</td>
                                    <td>E-MetroTel Americas</td>
                                    <td>TopUp</td>
                                    <td>Received</td>
                                    <td>
                                        <a href="{{route('order_status.details',1)}}" class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>61568</td>
                                    <td></td>
                                    <td>04-30-2025</td>
                                    <td>E-MetroTel Direct</td>
                                    <td>New System - Appliance</td>
                                    <td>Received</td>
                                    <td>
                                        <a href="{{route('order_status.details',1)}}" class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>61567</td>
                                    <td></td>
                                    <td>04-30-2025</td>
                                    <td>E-MetroTel Americas</td>
                                    <td>New System - Appliance</td>
                                    <td>Received</td>
                                    <td>
                                        <a href="{{route('order_status.details',1)}}" class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>61562</td>
                                    <td></td>
                                    <td>04-24-2025</td>
                                    <td>E-MetroTel Americas</td>
                                    <td>Software Subscription and Hardware Warranty Renewal</td>
                                    <td>Received</td>
                                    <td>
                                        <a href="{{route('order_status.details',1)}}" class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>61561</td>
                                    <td></td>
                                    <td>04-24-2025</td>
                                    <td>E-MetroTel Americas</td>
                                    <td>Software Subscription and Hardware Warranty Renewal</td>
                                    <td>Received</td>
                                    <td>
                                        <a href="{{route('order_status.details',1)}}" class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>61547</td>
                                    <td></td>
                                    <td>04-14-2025</td>
                                    <td>E-MetroTel Americas</td>
                                    <td>New System - Appliance</td>
                                    <td>Partial</td>
                                    <td>
                                        <a href="{{route('order_status.details',1)}}" class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>61524</td>
                                    <td></td>
                                    <td>04-13-2025</td>
                                    <td>E-MetroTel Americas</td>
                                    <td>New System - UCX-Cloud</td>
                                    <td>Received</td>
                                    <td>
                                        <a href="{{route('order_status.details',1)}}" class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>61518</td>
                                    <td></td>
                                    <td>04-12-2025</td>
                                    <td>E-MetroTel Design</td>
                                    <td>New System - Appliance</td>
                                    <td>Partial</td>
                                    <td>
                                        <a href="{{route('order_status.details',1)}}" class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>61509</td>
                                    <td></td>
                                    <td>04-11-2025</td>
                                    <td>E-MetroTel Americas</td>
                                    <td>New System - Appliance</td>
                                    <td>Received</td>
                                    <td>
                                        <a href="{{route('order_status.details',1)}}" class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>61480</td>
                                    <td></td>
                                    <td>04-08-2025</td>
                                    <td>E-MetroTel Americas</td>
                                    <td>TopUp</td>
                                    <td>Received</td>
                                    <td>
                                        <a href="{{route('order_status.details',1)}}" class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>61479</td>
                                    <td></td>
                                    <td>04-08-2025</td>
                                    <td>E-MetroTel Americas</td>
                                    <td>TopUp</td>
                                    <td>Received</td>
                                    <td>
                                        <a href="{{route('order_status.details',1)}}" class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>61474</td>
                                    <td></td>
                                    <td>04-08-2025</td>
                                    <td>E-MetroTel Americas</td>
                                    <td>TopUp</td>
                                    <td>Received</td>
                                    <td>
                                        <a href="{{route('order_status.details',1)}}" class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>61461</td>
                                    <td></td>
                                    <td>04-03-2025</td>
                                    <td>E-MetroTel Americas</td>
                                    <td>New System - Appliance</td>
                                    <td>Received</td>
                                    <td>
                                        <a href="{{route('order_status.details',1)}}" class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>61455</td>
                                    <td></td>
                                    <td>04-03-2025</td>
                                    <td>E-MetroTel Americas</td>
                                    <td>New System - Appliance</td>
                                    <td>Received</td>
                                    <td>
                                        <a href="{{route('order_status.details',1)}}" class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center">
{{--                            {{$transactions->links()}}--}}
                            <ul class="pagination m-0 ms-auto">

                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M15 6l-6 6l6 6"></path>
                                        </svg>

                                    </a>
                                </li>
                                <li class="page-item active"><a class="page-link">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">4</a></li>
                                <li class="page-item"><a class="page-link" href="#">5</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9 6l6 6l-6 6"></path>
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
