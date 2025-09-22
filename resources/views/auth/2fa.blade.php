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
                <h2 class="h2 text-center mb-4">Authenticate Your Account</h2>
                <p class="my-4 text-center">Please confirm your account by entering the authorization code sent to you email</p>
                <form method="POST" id="login_form" action="{{ route('2fa.verify.post') }}"  autocomplete="off" >
                    @csrf
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($errors->has('throttle'))
                        <div class="alert alert-danger" role="alert">
                            {{ $errors->first('throttle') }}
                        </div>
                    @endif
                    <div class="my-5">
                            <div class="row g-4">
                                <div class="col">
                                    <div class="row g-2">
                                        <div class="col">
                                            <input type="text" class="form-control form-control-lg text-center px-3 py-3" maxlength="1" inputmode="numeric" pattern="[0-9]*" data-code-input>
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control form-control-lg text-center px-3 py-3" maxlength="1" inputmode="numeric" pattern="[0-9]*" data-code-input>
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control form-control-lg text-center px-3 py-3" maxlength="1" inputmode="numeric" pattern="[0-9]*" data-code-input>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="row g-2">
                                        <div class="col">
                                            <input type="text" class="form-control form-control-lg text-center px-3 py-3" maxlength="1" inputmode="numeric" pattern="[0-9]*" data-code-input>
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control form-control-lg text-center px-3 py-3" maxlength="1" inputmode="numeric" pattern="[0-9]*" data-code-input>
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control form-control-lg text-center px-3 py-3" maxlength="1" inputmode="numeric" pattern="[0-9]*" data-code-input>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <input type="hidden" name="otp" id="otp">
                        @if ($errors->has('otp'))

                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('otp') }}</strong>
                                    </span>
                        @endif
                    </div>


                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Verify</button>

                    </div>
                </form>
            </div>
        </div>
            <div class="text-center text-muted mt-3">
                It may take a minute to receive your code. Haven't received it? <a href="" tabindex="-1" onclick="event.preventDefault(); document.getElementById('resendForm').submit();">Resend a new code.</a>
            </div>
        <form method="POST" id="resendForm" action="{{ route('2fa.resend') }}" class="d-none">
            @csrf
            <button type="submit" class="btn btn-primary">Resend a new code.</button>
        </form>

    </div>


@endsection
@section('scripts')

    <script>
        $(document).ready(function () {
            const inputs = document.querySelectorAll('[data-code-input]');
            const hiddenOtpInput = document.getElementById('otp');

            // Update hidden OTP input with combined value
            const updateOtpValue = () => {
                const otp = Array.from(inputs).map(input => input.value).join('');
                hiddenOtpInput.value = otp;
            };

            // Focus next input
            const focusNext = (currentInput) => {
                const currentIndex = Array.from(inputs).indexOf(currentInput);
                if (currentIndex < inputs.length - 1) {
                    inputs[currentIndex + 1].focus();
                }
            };

            // Focus previous input
            const focusPrevious = (currentInput) => {
                const currentIndex = Array.from(inputs).indexOf(currentInput);
                if (currentIndex > 0) {
                    inputs[currentIndex - 1].focus();
                }
            };

            // Handle input events
            inputs.forEach((input, index) => {
                // Handle keydown for digits and backspace
                input.addEventListener('keydown', (e) => {
                    if (e.key >= '0' && e.key <= '9') {
                        e.preventDefault();
                        input.value = e.key;
                        updateOtpValue();
                        focusNext(input);
                    } else if (e.key === 'Backspace') {
                        e.preventDefault();
                        input.value = '';
                        updateOtpValue();
                        focusPrevious(input);
                    }
                });

                // Handle paste on first input
                if (index === 0) {
                    input.addEventListener('paste', (e) => {
                        e.preventDefault();
                        const pastedData = e.clipboardData.getData('text').trim();
                        if (/^\d{6}$/.test(pastedData)) {
                            pastedData.split('').forEach((char, i) => {
                                if (inputs[i]) {
                                    inputs[i].value = char;
                                }
                            });
                            updateOtpValue();
                            inputs[inputs.length - 1].focus();
                        }
                    });
                }
            });

            // Prevent non-numeric input
            inputs.forEach(input => {
                input.addEventListener('input', () => {
                    input.value = input.value.replace(/[^0-9]/g, '');
                    updateOtpValue();
                });
            });
        })
    </script>
@endsection
