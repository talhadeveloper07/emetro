<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorCode;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class TwoFactorController extends Controller
{
    public function show()
    {
        $userId = session('2fa_user_id');
        $user = \App\Models\User::find($userId);

        if (!$user || !$user->otp || !$user->pending_2fa) {
            return redirect()->route('login');
        }

        return view('auth.2fa');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ], [
            'otp.required' => 'Please enter the 6-digit verification code.',
            'otp.digits' => 'The verification code must be exactly 6 digits.',
        ]);

        $userId = session('2fa_user_id');
        $user = \App\Models\User::find($userId);

        if (!$user || !$user->otp || !$user->pending_2fa) {
            return redirect()->route('login');
        }

        // Check OTP and expiry
        if (Hash::check($request->otp, $user->otp) && $user->otp_expires_at && now()->lessThanOrEqualTo($user->otp_expires_at)) {
            $user->update([
                'otp' => null,
                'otp_expires_at' => null,
                'pending_2fa' => false,
                'last_2fa_verified_at' => now(),
            ]);

            Auth::login($user);
            $request->session()->forget('2fa_user_id');
            return redirect()->route('home');
        }

        return redirect()->back()->withErrors(['otp' => 'Invalid or expired OTP. Please try again or resend the code.']);
    }

    public function resend(Request $request)
    {
        $userId = session('2fa_user_id');
        $user = \App\Models\User::find($userId);

        if (!$user || !$user->pending_2fa) {
            return redirect()->route('login');
        }

        // Generate and store new OTP
        $otp = generateOtp();
        $user->update([
            'otp' => Hash::make($otp),
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        // Send OTP via email
        Mail::to($user->email)->send(new TwoFactorCode($otp));

        return redirect()->route('2fa.verify')->with('status', 'A new OTP has been sent to your email.');
    }
}
