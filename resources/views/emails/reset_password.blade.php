@extends('emails.layout')

@section('content')
    <h2>Hello, {{ $notifiable->name }}</h2>
    <p>You are receiving this email because we received a password reset request for your account.</p>
    <p>
        <a href="{{ $url }}">Click here to reset your password</a>
    </p>
    <p>If you did not request a password reset, no further action is required.</p>

    <p>Regards,<br>E-Metrotel</p>
@endsection
