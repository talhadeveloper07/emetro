<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>

    <style>
        @font-face {
            font-family: 'Montserrat';
            src: url("{{ storage_path('fonts/Montserrat-Regular.ttf') }}") format('truetype');
        }
        body {font-family: 'Montserrat', sans-serif;font-size: 10px; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        h1 { text-align: center; font-size: 18px; }
        .text-wrap{
            white-space: normal !important;
        }
    </style>
</head>
<body>
<h1>@yield('title')</h1>
@yield('content')
</body>
</html>
