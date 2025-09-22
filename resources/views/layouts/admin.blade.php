<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>{{env('APP_NAME')}}</title>
    <!-- CSS files -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{asset('')}}dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="{{asset('')}}dist/css/tabler-flags.min.css" rel="stylesheet"/>
    <link href="{{asset('')}}dist/css/tabler-payments.min.css" rel="stylesheet"/>
    <link href="{{asset('')}}dist/css/tabler-vendors.min.css" rel="stylesheet"/>
    <link href="{{asset('')}}dist/css/demo.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://richtexteditor.com/richtexteditor/rte_theme_default.css" />
    <link rel="shortcut icon" type="image/png" href="{{asset('')}}static/logo-small.png"/>
    <link href='https://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/css/datepicker.css">
    <link rel="stylesheet" href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome-font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('dist/css/app.css')}}?v={{time()}}">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }

        /* Apply to all elements */
        * {
            font-family: 'Montserrat', sans-serif !important;
        }
        #loader_overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(29, 39, 59, 0.24);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            -webkit-backdrop-filter: blur(4px);
            backdrop-filter: blur(4px);
        }

        .loader_spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: custom-loader-spin 1s linear infinite;
        }
        .select2-container--default .select2-selection--single,.select2-container--default .select2-selection--multiple {
            background-color: #fff;
            border: 1px solid #e6e7e9;
            border-radius: 4px;
        }
        .select2-container--default.select2-container--disabled .select2-selection--single,.select2-container--default.select2-container--disabled .select2-selection--multiple {
            background-color: #f1f5f9;
            cursor: default;
        }

        @keyframes custom-loader-spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        @media (min-width: 1400px) {
            .container, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl {
                max-width: 1420px;
            }
        }
        .imageProductPreview{
            position: absolute;
            top: -14px;
            left: -33px;
        }
    </style>
    @yield('styles')

</head>
<body class="antialiased">
<div class="wrapper">
    <div id="loader_overlay" style="display: none;">
        <div class="loader_spinner"></div>
    </div>
{{--    @include('layouts.sidenav')--}}
    @include('layouts.header')

    <div class="page-wrapper">


        @yield('content')

        @include('layouts.footer')
    </div>
</div>
<!-- Libs JS -->
<script src="{{asset('')}}dist/libs/apexcharts/dist/apexcharts.min.js"></script>
<script src="{{asset('')}}dist/libs/jsvectormap/dist/js/jsvectormap.min.js?1668287865" defer></script>
<script src="{{asset('')}}dist/libs/jsvectormap/dist/maps/world.js?1668287865" defer></script>
<script src="{{asset('')}}dist/libs/jsvectormap/dist/maps/world-merc.js?1668287865" defer></script>
{{--<script src="{{asset('')}}dist/libs/nouislider/distribute/nouislider.min.js"></script>--}}
<script src="{{asset('')}}dist/libs/litepicker/dist/litepicker.js"></script>
{{--<script src="{{asset('')}}dist/libs/choices.js/public/assets/scripts/choices.js"></script>--}}
<!-- Tabler Core -->
<script src="{{asset('')}}dist/js/tabler.min.js"></script>
<script src="{{asset('')}}dist/libs/litepicker/dist/litepicker.js" defer=""></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>



<script type="text/javascript" src="https://richtexteditor.com/richtexteditor/rte.js"></script>
<script type="text/javascript" src='https://richtexteditor.com/richtexteditor/plugins/all_plugins.js'></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : false,
        "positionClass": "toast-bottom-center",
    }
    @if(Session::has('success'))
    toastr.success("{{ session('success') }}");
    @endif
    @if(Session::has('error'))
    toastr.error("{{ session('error') }}");
    @endif
    @if(Session::has('info'))
    toastr.info("{{ session('info') }}");
    @endif

    @if(Session::has('warning'))
    toastr.warning("{{ session('warning') }}");
    @endif


    $(document).on("click", ".delete-btn", function (e) {
        e.preventDefault(); // Prevent default form submission

        let $form = $(this).closest("form"); // Get the closest form

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to undo this action!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $form.submit(); // Submit the form if confirmed
            }
        });
    });
    $(document).on('keydown', 'input[type="number"]', function (e) {
        const allowedKeys = [
            'Backspace', 'Tab', 'Delete','ArrowUp','ArrowDown', 'ArrowLeft', 'ArrowRight', 'Home', 'End'
        ];

        if (allowedKeys.includes(e.key) || e.ctrlKey || e.metaKey) return;

        const isNumber = /^[0-9]$/.test(e.key);
        const isDot = e.key === '.';
        const hasDot = this.value.includes('.');

        // Block invalid input
        if (!isNumber && !(isDot && !hasDot)) {
            e.preventDefault();
        }
    });

    // Only sanitize pasted or autofilled content — DO NOT interfere with natural typing
    $(document).on('blur', 'input[type="number"]', function () {
        let val = this.value;

        // Remove any non-numeric/non-dot characters
        val = val.replace(/[^0-9.]/g, '');

        // Keep only the first dot
        const parts = val.split('.');
        if (parts.length > 2) {
            val = parts[0] + '.' + parts[1]; // truncate after first dot
        }

        this.value = val;
    });
</script>


<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
{{--<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/super-build/ckeditor.js"></script>--}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/jscolor/2.4.0/jscolor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/datepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/i18n/datepicker.en.js"></script>
<script>
    $(document).ready(function () {
        $('form').on('submit', function (e) {
            if (e.isDefaultPrevented()) {
                return; // Don't show loader if form is cancelled
            }
            $('#loader_overlay').show();
        });
        $('.collapse').each(function() {
            var $collapseElement = $(this);
            var targetId = '#' + $collapseElement.attr('id');
            var $btn = $('button[data-bs-target="' + targetId + '"]');

            if ($btn.length === 0) return; // no button, skip

            var $iconPlus = $btn.find('.icon-tabler-plus');
            var $iconMinus = $btn.find('.icon-tabler-minus');

            // Set initial icon state
            if ($collapseElement.hasClass('show')) {
                $iconPlus.hide();
                $iconMinus.show();
            } else {
                $iconPlus.show();
                $iconMinus.hide();
            }

            // Listen to Bootstrap collapse events
            $collapseElement.on('shown.bs.collapse', function () {
                $iconPlus.hide();
                $iconMinus.show();
            });

            $collapseElement.on('hidden.bs.collapse', function () {
                $iconPlus.show();
                $iconMinus.hide();
            });
        });

        $('.select2').select2();
        $('#goBack').on('click', function() {
            window.history.back();
        });
        if ($("#datepicker-icon").length && window.Litepicker) {
            new Litepicker({
                element: $("#datepicker-icon")[0], // Get raw DOM element
                buttonText: {
                    previousMonth: `
	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1"><path d="M15 6l-6 6l6 6" /></svg>`,
                    nextMonth: `
	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1"><path d="M9 6l6 6l-6 6" /></svg>`,
                },
            });
        }
        $('.summernote').summernote();
        $('.logout-App').on('click', function (event) {
            event.preventDefault();
            $('#logoutForm').submit();
        });
    });
</script>
@yield('scripts')
</body>
</html>
