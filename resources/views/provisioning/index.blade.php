@extends('layouts.admin')

@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Provisioning
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
                    <div class="">
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 ">
                            <div class="col">
                                <a class="w-100" href="{{ route('provisioning.infinity3065') }}" >
                                    <div class="dashboard-card">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-mobile"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 5a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2v-14z" /><path d="M11 4h2" /><path d="M12 17v.01" /></svg>
                                        <h5>Infinity 3065</h5>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a class="w-100" href="{{ route('provisioning.dect') }}" >
                                    <div class="dashboard-card">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-landline-phone"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 3h-2a2 2 0 0 0 -2 2v14a2 2 0 0 0 2 2h2a2 2 0 0 0 2 -2v-14a2 2 0 0 0 -2 -2z" /><path d="M16 4h-11a3 3 0 0 0 -3 3v10a3 3 0 0 0 3 3h11" /><path d="M12 8h-6v3h6z" /><path d="M12 14v.01" /><path d="M9 14v.01" /><path d="M6 14v.01" /><path d="M12 17v.01" /><path d="M9 17v.01" /><path d="M6 17v.01" /></svg>
                                        <h5>Infinity DECT</h5>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a class="w-100"  href="{{ route('provisioning.infinity5') }}" >
                                    <div class="dashboard-card">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-phone"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" /></svg>
                                        <h5>Infinity 5XXX</h5>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a class="w-100" href="#" >
                                    <div class="dashboard-card">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-phone-call"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" /><path d="M15 7a2 2 0 0 1 2 2" /><path d="M15 3a6 6 0 0 1 6 6" /></svg>
                                        <h5>SIP Phones</h5>
                                    </div>
                                </a>
                            </div>

                            <div class="col">
                                <a class="w-100" href="#" >
                                    <div class="dashboard-card">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-landline-phone"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 3h-2a2 2 0 0 0 -2 2v14a2 2 0 0 0 2 2h2a2 2 0 0 0 2 -2v-14a2 2 0 0 0 -2 -2z" /><path d="M16 4h-11a3 3 0 0 0 -3 3v10a3 3 0 0 0 3 3h11" /><path d="M12 8h-6v3h6z" /><path d="M12 14v.01" /><path d="M9 14v.01" /><path d="M6 14v.01" /><path d="M12 17v.01" /><path d="M9 17v.01" /><path d="M6 17v.01" /></svg>
                                        <h5>FXS</h5>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a class="w-100" href="{{ route('provisioning.infinity7') }}" >
                                    <div class="dashboard-card">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-landline-phone"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 3h-2a2 2 0 0 0 -2 2v14a2 2 0 0 0 2 2h2a2 2 0 0 0 2 -2v-14a2 2 0 0 0 -2 -2z" /><path d="M16 4h-11a3 3 0 0 0 -3 3v10a3 3 0 0 0 3 3h11" /><path d="M12 8h-6v3h6z" /><path d="M12 14v.01" /><path d="M9 14v.01" /><path d="M6 14v.01" /><path d="M12 17v.01" /><path d="M9 17v.01" /><path d="M6 17v.01" /></svg>
                                        <h5>Infinity 7XXX</h5>
                                    </div>
                                </a>
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
