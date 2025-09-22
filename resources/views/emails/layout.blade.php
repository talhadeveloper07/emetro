<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? env('APP_NAME') }}</title>
    <link href="{{asset('')}}dist/css/bootstrap_5_3.min.css" rel="stylesheet"/>
    <style>
        body{
            margin: 0;
            padding: 10px 0px;
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        h2{
            color: #333;
            margin-bottom: 20px;
        }
        p{
            color: #666;
            margin-bottom: 20px;
        }
        @media only screen and (max-width: 600px) {
            body{
                margin: 0;
                padding: 0;
            }
            .container { width: 100% !important; }
            .table { font-size: 12px !important; }
        }
    </style>
</head>
<body>
<table cellpadding="0" cellspacing="0" width="100%" style="background-color: #f4f4f4; padding: 20px;">
    <tr>
        <td align="center">
            <table cellpadding="0" cellspacing="0" width="600" class="container" style="background-color: #ffffff; border-radius: 5px; overflow: hidden;">
                <tr>
                    <td style="background-color: #ffffff; padding: 20px; text-align: center; border-bottom: 1px solid #eee;">
                        @if(env('APP_LOGO'))
{{--                            <img src="{{ asset('images/logo.png') }}" alt="E-Metrotel" style="max-width: 200px; height: auto;">--}}
                            <img src="https://portal.emetrotel.com/sites/all/themes/emetro/logo.png" alt="E-Metrotel" style="max-width: 200px; height: auto;">
                        @else
                            <h2>{{env('APP_NAME')}}</h2>
                        @endif
                    </td>
                </tr>

                <!-- Content -->
                <tr>
                    <td style="padding: 30px;">
                        @yield('content')
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background-color: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; color: #666;">
                        <p>&copy; {{ date('Y') }} E-MetroTel. All rights reserved.</p>
                        <p>This is an automated email, please do not reply directly to this message.</p>
{{--                        <p>For inquiries, contact us at <a href="mailto:payment@emetrotel.com" style="color: #7ead21;">payment@emetrotel.com</a></p>--}}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
