@extends('layouts.admin')

@section('content')
    <style>

        .accordion-button::after {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='icon icon-tabler icons-tabler-outline icon-tabler-plus'%3e%3cpath stroke='none' d='M0 0h24v24H0z' fill='none'/%3e%3cpath d='M12 5l0 14'/%3e%3cpath d='M5 12l14 0'/%3e%3c/svg%3e");
        }
        .accordion-button:not(.collapsed)::after {
            background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='icon icon-tabler icons-tabler-outline icon-tabler-minus'%3e%3cpath stroke='none' d='M0 0h24v24H0z' fill='none'/%3e%3cpath d='M5 12l14 0'/%3e%3c/svg%3e");
        }
        /*.details-container {
            !*margin: 0 -5px;*!
        }
        .details-container .card {
            border: none;
            border-radius: 10px;
            background: white;
            !*box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);*!
            !*transition: transform 0.2s ease;*!
            height: 240px; !* Fixed height for all cards *!
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 15px;
            margin: 5px;
        }
        .details-container .card:hover {
            !*transform: translateY(-5px);*!
        }
        .details-container .card-body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 10px;
            width: 100%;
            height: 100%;
        }
        .details-container .logo-container {
            height: 30px; !* Fixed height for logo alignment *!
            margin-bottom: 10px;
        }
        .details-container .card-title {
            font-size: 1.1rem;
            color: #2c3e50;
            margin-bottom: 10px;
            font-weight: 600;
        }
        .details-container .card-text {
            font-size: 1rem;
            color: #7f8c8d;
            font-weight: 500;
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: normal;
            width: 100%;
            max-height: 120px; !* Limit text height to fit within card *!
            overflow-y: auto; !* Enable vertical scrolling *!
            padding: 5px;
        }
        .details-container .card svg {
            width: 24px;
            height: 24px;
            color: var(--primary-color);
            margin-bottom: 10px;
        }
        !* Custom scrollbar styling based on parent class *!
        .details-container .card-text::-webkit-scrollbar {
            width: 6px; !* Slim scrollbar *!
        }
        .details-container .card-text::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05); !* Light track background *!
            border-radius: 10px;
        }
        .details-container .card-text::-webkit-scrollbar-thumb {
            background: var(--primary-color); !* Match icon color *!
            border-radius: 10px;
        }
        .details-container .card-text::-webkit-scrollbar-thumb:hover {
            background: var(--primary-color); !* Slightly darker on hover *!
        }
        !* Remove scrollbar arrows in WebKit browsers *!
        .details-container .card-text::-webkit-scrollbar-button {
            display: none;
        }
        !* Firefox scrollbar styling *!
        .details-container .card-text {
            scrollbar-width: thin; !* Slim scrollbar *!
            scrollbar-color: var(--primary-color) rgba(0, 0, 0, 0.05); !* Thumb and track colors *!
        }
        @media (max-width: 768px) {
            .details-container .col-lg-2 {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }*/
        .details-container {
            padding: 1rem;
        }
        .details-container .card {
            border: none;
            border-radius: 10px;
            /*box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);*/
            height: 100%;
            /*transition: transform 0.3s ease, box-shadow 0.3s ease;*/
        }
        .details-container .card:hover {
            /*transform: translateY(-3px);*/
            /*box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);*/
        }
        .details-container .card-body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .details-container .icon {
            width: 40px;
            height: 40px;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }
        .details-container .card-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }
        .details-container .card-text {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 0;
            word-break: break-word;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .details-container .col-md-4 {
                padding: 0.5rem;
            }
            .details-container .card-body {
                padding: 1.25rem;
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
                        <a href="{{route('order_status.index')}}"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg></a>
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
            <div class="row justify-content-center g-4 details-container  mb-3 ">
                <div class="col-md-4 col-lg-2">
                    <div class="card">
                        <div class="card-body">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-hash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 9l14 0" /><path d="M5 15l14 0" /><path d="M11 4l-4 16" /><path d="M17 4l-4 16" /></svg>
                            <h5 class="card-title">Order ID</h5>
                            <p class="card-text">61547</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-2">
                    <div class="card">
                        <div class="card-body">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-category"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4h6v6h-6z" /><path d="M14 4h6v6h-6z" /><path d="M4 14h6v6h-6z" /><path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /></svg>
                            <h5 class="card-title">PO #</h5>
                            <p class="card-text"></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-2">
                    <div class="card">
                        <div class="card-body">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-packages"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 16.5l-5 -3l5 -3l5 3v5.5l-5 3z" /><path d="M2 13.5v5.5l5 3" /><path d="M7 16.545l5 -3.03" /><path d="M17 16.5l-5 -3l5 -3l5 3v5.5l-5 3z" /><path d="M12 19l5 3" /><path d="M17 16.5l5 -3" /><path d="M12 13.5v-5.5l-5 -3l5 -3l5 3v5.5" /><path d="M7 5.03v5.455" /><path d="M12 8l5 -3" /></svg>
                            <h5 class="card-title">Name</h5>
                            <p class="card-text">2323</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-2">
                    <div class="card">
                        <div class="card-body">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-building"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 21l18 0" /><path d="M9 8l1 0" /><path d="M9 12l1 0" /><path d="M9 16l1 0" /><path d="M14 8l1 0" /><path d="M14 12l1 0" /><path d="M14 16l1 0" /><path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16" /></svg>
                            <h5 class="card-title">Organization</h5>
                            <p class="card-text">E-MetroTel Americas</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-2">
                    <div class="card">
                        <div class="card-body">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-building"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 21l18 0" /><path d="M9 8l1 0" /><path d="M9 12l1 0" /><path d="M9 16l1 0" /><path d="M14 8l1 0" /><path d="M14 12l1 0" /><path d="M14 16l1 0" /><path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16" /></svg>
                            <h5 class="card-title">Organization Type</h5>
                            <p class="card-text">Reseller</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="row">
                    <div class="col-12 d-flex flex-column">
                        <div class="card-body">

                            <div class="row mb-3">

                                <div class="row align-items-center">
                                    <div class="col">
                                        <h2 class="text-lime">Order Items</h2>
                                    </div>
                                    <!-- Page title actions -->
                                    <div class="col-auto ms-auto d-print-none">
                                        <div class="btn-list">
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
                                </div>
                                <div class="accordion" id="accordion-default">
                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-1-default" aria-expanded="false">
                                                <div class="row w-100">
                                                    <div class="col-md-3">EVSPTN-MC</div>
                                                    <div class="col-md-3">PSTN SIP Channel. Qty 1 per Month</div>
                                                    <div class="col-md-3">QTY : 3</div>
                                                    <div class="col-md-3">
                                                        <div class="d-flex gap-1 align-items-center  pe-3">
                                                            <div>Tracking:</div>
                                                            <div>Electronic</div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </button>
                                        </div>
                                        <div id="collapse-1-default" class="accordion-collapse collapse" data-bs-parent="#accordion-default" style="">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-md-8 col-sm-12 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-4 col-sm-12 mb-3">
                                                                <label class="form-label">Serial Number</label>
                                                                <input  type="text" id="serial_number" name="serial_number" value="" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-12 mb-3">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-2-default" aria-expanded="false">
                                                <div class="row w-100">
                                                    <div class="col-md-3">EVDIDN-MC</div>
                                                    <div class="col-md-3">DID Number. Per month</div>
                                                    <div class="col-md-3">QTY : 1</div>
                                                    <div class="col-md-3">
                                                        <div class="d-flex gap-1 align-items-center  pe-3">
                                                            <div>Tracking:</div>
                                                            <div>Electronic</div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </button>
                                        </div>
                                        <div id="collapse-2-default" class="accordion-collapse collapse" data-bs-parent="#accordion-default" style="">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-md-8 col-sm-12 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-4 col-sm-12 mb-3">
                                                                <label class="form-label">Serial Number</label>
                                                                <input  type="text" id="serial_number" name="serial_number" value="" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-12 mb-3">

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-3-default" aria-expanded="false">
                                                <div class="row w-100">
                                                    <div class="col-md-3">ESGM2N-STD</div>
                                                    <div class="col-md-3">Software Support - Galaxy MINI. Standard</div>
                                                    <div class="col-md-3">QTY : 1</div>
                                                    <div class="col-md-3">
                                                        <div class="d-flex gap-1 align-items-center  pe-3">
                                                            <div>Tracking:</div>
                                                            <div>Electronic</div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </button>
                                        </div>
                                        <div id="collapse-3-default" class="accordion-collapse collapse" data-bs-parent="#accordion-default">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-md-8 col-sm-12 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-4 col-sm-12 mb-3">
                                                                <label class="form-label">Serial Number</label>
                                                                <input  type="text" id="serial_number" name="serial_number" value="" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-12 mb-3">

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-4-default" aria-expanded="false">
                                                <div class="row w-100">
                                                    <div class="col-md-3">EV911N-MC</div>
                                                    <div class="col-md-3">911 Listing. Per month</div>
                                                    <div class="col-md-3">QTY : 1</div>
                                                    <div class="col-md-3">
                                                        <div class="d-flex gap-1 align-items-center  pe-3">
                                                            <div>Tracking:</div>
                                                            <div>Electronic</div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </button>
                                        </div>
                                        <div id="collapse-4-default" class="accordion-collapse collapse" data-bs-parent="#accordion-default">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-md-8 col-sm-12 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-4 col-sm-12 mb-3">
                                                                <label class="form-label">Serial Number</label>
                                                                <input  type="text" id="serial_number" name="serial_number" value="" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-12 mb-3">

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <div class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-5" aria-expanded="false">
                                                <div class="row w-100">
                                                    <div class="col-md-3">HBGLXC-XPND</div>
                                                    <div class="col-md-3">11-slot chassis for Server and TDM cards</div>
                                                    <div class="col-md-3">QTY : 1</div>
                                                    <div class="col-md-3">
                                                        <div class="d-flex gap-1 align-items-center  pe-3">
                                                            <div>Tracking:</div>
                                                            <input  type="text" id="tracking" name="tracking" value="" class="form-control">
                                                        </div>

                                                    </div>
                                                </div>

                                            </button>
                                        </div>
                                        <div id="collapse-5" class="accordion-collapse collapse" data-bs-parent="#accordion-default">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-md-8 col-sm-12 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-4 col-sm-12 mb-3">
                                                                <label class="form-label">Serial Number</label>
                                                                <input  type="text" id="serial_number" name="serial_number" value="" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-12 mb-3">
                                                        <textarea class="form-control" name="" id="" cols="30" rows="5"></textarea>
                                                        <button type="button" class="btn btn-sm btn-primary mt-2">Auto fill</button>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12  text-end mt-3">
                                    <button type="button" class="btn btn-primary">Download Pdf</button>
                                    <button type="button" class="btn btn-primary">Send update</button>
                                    <button type="button" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <h2 class="text-lime">Address</h2>
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label">Attention</label>
                                    <input disabled type="text" id="attention" name="attention" value="Testing" class="form-control">
                                </div>

                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label">Shipping Address</label>

                                    <textarea class="form-control" name="shipping_address" id="shipping_address" cols="30" rows="6" disabled>
Shabeer P

1033 Long Prairie Rd (FM.2499)
Flower Mound
Texas
75022
                                    </textarea>
                                </div>
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <label class="form-label">Billing Address</label>
                                    <textarea class="form-control" name="billing_address" id="shipping_address" cols="30" rows="6" disabled>
Shabeer P

1033 Long Prairie Rd (FM.2499),
Flower Mound,
Texas,
75022
                                    </textarea>
                                </div>

                            </div>

                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
