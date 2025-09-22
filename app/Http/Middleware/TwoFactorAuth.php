<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\TwoFactorCode;

class TwoFactorAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user) {
            $currentIp = $request->ip();
            $currentDeviceId = md5(($request->header('User-Agent') ?? 'unknown') . ($request->header('Accept-Language') ?? ''));

            // Check if 2FA is pending
            if ($user->pending_2fa) {
                // Ensure OTP exists, regenerate if expired
                if (!$user->otp || ($user->otp_expires_at && now()->greaterThan($user->otp_expires_at))) {
                    $otp = generateOtp();
                    $user->update([
                        'otp' => Hash::make($otp),
                        'otp_expires_at' => now()->addMinutes(10),
                    ]);
                    Mail::to($user->email)->send(new TwoFactorCode($otp));
                }

                $request->session()->put('2fa_user_id', $user->id);
                return redirect()->route('2fa.verify');
            }

            $requires2FA = false;

            // Check if first login (no last_2fa_verified_at)
            if (!$user->last_2fa_verified_at) {
                $requires2FA = true;
            }
            // Check if different device or IP
            elseif ($user->last_login_device_id !== $currentDeviceId || $user->last_login_ip !== $currentIp) {
                $requires2FA = true;
            }
            // Check if 30 days have passed since last 2FA
            elseif ($user->last_2fa_verified_at && now()->diffInDays($user->last_2fa_verified_at) >= 30) {
                $requires2FA = true;
            }

            if ($requires2FA) {
                // Generate and store OTP
                $otp = generateOtp();
                $user->update([
                    'otp' => Hash::make($otp),
                    'otp_expires_at' => now()->addMinutes(10),
                    'pending_2fa' => true,
                    'last_login_ip' => $currentIp,
                    'last_login_device_id' => $currentDeviceId,
                ]);

                // Send OTP via email
                Mail::to($user->email)->send(new TwoFactorCode($otp));

                $request->session()->put('2fa_user_id', $user->id);
                return redirect()->route('2fa.verify');
            }

            // Update login metadata if no 2FA is required
            $user->update([
                'last_login_ip' => $currentIp,
                'last_login_device_id' => $currentDeviceId,
            ]);
        }

        return $next($request);
    }
}
