<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['detail' => 'Incorrect email or password'], 400);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'user'         => [
                'id'        => $user->id,
                'email'     => $user->email,
                'full_name' => $user->full_name,
                'role'      => $user->role,
            ]
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string|min:6',
            'full_name' => 'nullable|string',
        ]);

        $user = User::create([
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'full_name' => $request->full_name,
            'role'      => User::count() === 0 ? 'admin' : 'editor',
        ]);

        return response()->json($user, 201);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = strtolower(trim($request->email));
        $user  = User::where('email', $email)->first();

        // Admin-only & active check (Requirement 10)
        // Always respond the same way whether or not the email exists or is an admin,
        // so the endpoint cannot be used to enumerate registered admin accounts.
        if ($user && $user->role === 'admin' && $user->is_active) {
            $cooldownKey = 'otp_cd_' . $email;
            if (!cache()->has($cooldownKey)) {
                $otp = random_int(100000, 999999);
                cache()->put('otp_' . $email, $otp, 600); // 10 minutes
                cache()->put('otp_attempts_' . $email, 0, 600);
                cache()->put($cooldownKey, true, 60); // 60s cooldown

                $mailBody = "Hello,\n\n"
                    . "A password reset was requested for your Maha Construction Admin account.\n\n"
                    . "Your 6-digit verification code is: {$otp}\n\n"
                    . "This code is valid for 10 minutes. If you did not request this, please ignore this email and ensure your account remains secure.\n\n"
                    . "SECURITY NOTICE: Maha Construction will never ask you to share your verification code or password.\n\n"
                    . "Regards,\nMaha Construction Admin Team";

                try {
                    Mail::raw($mailBody, function ($message) use ($email) {
                        $fromAddress = config('mail.from.address') ?: 'mahaconstructions2013@gmail.com';
                        $fromName    = config('mail.from.name') ?: 'Maha Construction';
                        $message->from($fromAddress, $fromName)
                                ->to($email)
                                ->subject('Maha Construction - Admin Password Reset Code');
                    });
                } catch (\Throwable $e) {
                    Log::error('Password reset email could not be sent: ' . $e->getMessage());
                }
            }
        }

        return response()->json(['message' => 'If that email is registered, an OTP has been sent to it.']);
    }

    public function resetPassword(Request $request)
    {
        $rules = [
            'email'        => 'required|email',
            'otp'          => 'required|string',
            'new_password' => 'required|string|min:8',
        ];
        if ($request->has('new_password_confirmation')) {
            $rules['new_password'] .= '|confirmed';
        }
        $request->validate($rules, [
            'new_password.min'       => 'Password must be at least 8 characters.',
            'new_password.confirmed' => 'Passwords do not match.',
        ]);

        $email       = strtolower(trim($request->email));
        $otpKey      = 'otp_' . $email;
        $attemptsKey = 'otp_attempts_' . $email;
        $cooldownKey = 'otp_cd_' . $email;

        $cachedOtp = cache()->get($otpKey);
        $attempts  = (int) cache()->get($attemptsKey, 0);

        if (!$cachedOtp || $attempts >= 5) {
            if ($cachedOtp && $attempts >= 5) {
                cache()->forget($otpKey);
                cache()->forget($attemptsKey);
            }
            return response()->json(['detail' => 'Invalid or expired OTP', 'message' => 'Invalid or expired OTP.'], 400);
        }

        if ((string)$cachedOtp !== trim((string)$request->otp)) {
            cache()->put($attemptsKey, $attempts + 1, 600);
            if ($attempts + 1 >= 5) {
                cache()->forget($otpKey);
                cache()->forget($attemptsKey);
            }
            return response()->json(['detail' => 'Invalid or expired OTP', 'message' => 'Invalid or expired OTP.'], 400);
        }

        $user = User::where('email', $email)->first();
        if (!$user || $user->role !== 'admin' || !$user->is_active) {
            cache()->forget($otpKey);
            cache()->forget($attemptsKey);
            return response()->json(['detail' => 'Invalid or expired OTP', 'message' => 'Invalid or expired OTP.'], 400);
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        // Invalidate OTP immediately after successful reset (single-use)
        cache()->forget($otpKey);
        cache()->forget($attemptsKey);
        cache()->forget($cooldownKey);

        return response()->json(['message' => 'Password reset successfully.']);
    }

    // Admin web login
    public function adminLoginPage()
    {
        if (session('admin_authenticated')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function adminLoginPost(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required'    => 'Please enter your email address.',
            'email.email'       => 'Please enter a valid email address.',
            'password.required' => 'Please enter your password.',
        ]);

        $email = strtolower(trim($request->email));
        $user  = User::where('email', $email)->first();

        if (
            $user &&
            Hash::check($request->password, $user->password) &&
            $user->is_active &&
            $user->role === 'admin'
        ) {
            $request->session()->regenerate();
            session([
                'admin_authenticated' => true,
                'admin_email'         => $user->email,
                'admin_name'          => $user->full_name ?? 'Maha Admin',
            ]);

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid email or password.'])->withInput($request->except('password'));
    }

    public function adminLogout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
