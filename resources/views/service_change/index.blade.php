@extends('layouts.admin')

@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Service Change
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
                            <form action="{{route('service_change.index')}}" method="get">
                                <div class="card-body">
                                    <div class="row row-cards">

                                        <div class="col-sm-6 col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label required">Enter Serial Number</label>
                                                <input type="text" name="product_code" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">&nbsp;</label>
                                                <button type="submit" class="btn btn-primary">Proceed</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

            </div>
        </div>


    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            $('.toggle-advanced-filters').on('click', function() {
                $('.advanced-filters').slideToggle(300, function() {
                    // Update button text after animation completes
                    var $button = $('.toggle-advanced-filters');
                    if ($('.advanced-filters').is(':visible')) {
                        $button.text('Hide Advanced Filters');
                    } else {
                        $button.text('Show Advanced Filters');
                    }
                });
            });
        });
    </script>
@endsection
