@extends('emails.layout')

@section('content')
    <h2>Your Two-Factor Authentication Code</h2>
    <p>Please use the following code to complete your login:</p>
    <h2>{{ $otp }}</h2>
    <p>This code will expire in 10 minutes.</p>
    <p>If you did not attempt to log in, please secure your account immediately.</p>
    <p>Regards,<br>{{env('APP_NAME')}}</p>
@endsection
