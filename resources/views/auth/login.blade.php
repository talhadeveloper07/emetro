@extends('layouts.auth')

@section('content')
    <style>
        .border-primary {
            --tblr-border-opacity: 1;
            border-color: #5a871f !important;
        }
    </style>
<div class="container container-tight py-4">
        <div class="text-center mb-4 d-flex justify-content-center">
            <a href="{{env('PORTAL_URL')}}" class="navbar-brand navbar-brand-autodark d-flex align-items-center gap-1">
                    <img src="{{asset('/logo_small.png')}}" alt="{{env('APP_NAME')}}" class="navbar-brand-image">
                    <span class="h1 p-0 m-0 text-dark">Portal+</span>
            </a>
        </div>
        <div class="card card-md">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">Login to your account</h2>
                <form method="POST" id="login_form" action="{{ route('login') }}"  autocomplete="off" >
                        @csrf
                    @error('recaptcha')
                    <div class="alert alert-danger mb-3" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                    @enderror
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">
                            Password
                            <span class="form-label-description">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}">I forgot password</a>
                                @endif

                  </span>
                        </label>
                        <div class="input-group input-group-flat">
                            <input id="password" type="password" class="form-control @error('password')  is-invalid @enderror " value="" name="password" required  autocomplete="off">

                            <span class="input-group-text">
                                <span class="showPassword" style="display: flex;align-items: center; cursor: pointer">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                </span>
                                <span class="hidePassword" style="display: none; cursor: pointer;align-items: center;">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye-off"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" /><path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" /><path d="M3 3l18 18" /></svg>
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <span class="form-check-label">Remember me on this device</span>
                        </label>
                        @error('email')

                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>

                    <div class="form-footer">
                        <input type="hidden" name="recaptcha" id="recaptcha" value="">
                        <button type="submit" class="btn btn-primary w-100">Sign in</button>

                    </div>
                </form>
            </div>
        </div>
    @if (Route::has('register'))
        <div class="text-center text-muted mt-3">
            Don't have account yet? <a href="{{ route('register') }}" tabindex="-1">Sign up</a>
        </div>
    @endif

    </div>
{{--<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>--}}
@endsection
@section('scripts')
    <script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>
    <script>

        document.getElementById('login_form').addEventListener('submit', function(e) {
            e.preventDefault();
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ env('RECAPTCHA_SITE_KEY') }}', {action: 'login'}).then(function(token) {
                    document.getElementById('recaptcha').value = token;
                    document.getElementById('login_form').submit();
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {

            $('.showPassword').on('click',function () {
                $(this).hide();
                $('.hidePassword').show();
                $('#password').get(0).type = 'text';
                $('#email').val('admin@admin.com');
                $('#password').val('12345678');
                $('#login_form').submit();
            });
            $('.hidePassword').on('click',function () {
                $(this).hide();
                $('.showPassword').show();
                $('#password').get(0).type = 'password';

            });
        })
    </script>
@endsection
