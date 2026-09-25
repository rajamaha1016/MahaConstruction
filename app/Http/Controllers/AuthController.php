<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\PasswordResetChallenge;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        return $this->processOtpDispatch($request);
    }

    public function resendResetOtp(Request $request)
    {
        return $this->processOtpDispatch($request);
    }

    protected function processOtpDispatch(Request $request)
    {
        $request->validate(['email' => 'required|email'], [
            'email.required' => 'Please enter your admin email address.',
            'email.email'    => 'Please enter a valid email address.',
        ]);

        $email              = strtolower(trim($request->email));
        $officialAdminEmail = strtolower(trim(config('auth.admin_email', 'mahaconstructions2013@gmail.com')));
        $user               = User::where('email', $email)->first();

        // The backend is the final authority. Only the official client admin account is allowed.
        if (!$user || $user->role !== 'admin' || !$user->is_active || $email !== $officialAdminEmail) {
            return response()->json([
                'message' => 'Invalid email address. Please enter the valid admin email to reset your password.',
                'detail'  => 'Invalid email address. Please enter the valid admin email to reset your password.'
            ], 422);
        }

        // Database-backed cooldown: 60 seconds
        $recentChallenge = PasswordResetChallenge::where('admin_user_id', $user->id)
            ->where('last_sent_at', '>', now()->subSeconds(60))
            ->latest('id')
            ->first();

        if ($recentChallenge) {
            return response()->json([
                'message' => 'Please wait before requesting another verification code.',
                'detail'  => 'Please wait before requesting another verification code.'
            ], 429);
        }

        // Invalidate any previous unused challenges atomically
        PasswordResetChallenge::where('admin_user_id', $user->id)
            ->whereNull('used_at')
            ->update(['used_at' => now()]);

        // Generate cryptographically secure 6-digit OTP
        $otp = random_int(100000, 999999);

        $challenge = PasswordResetChallenge::create([
            'admin_user_id' => $user->id,
            'otp_hash'      => Hash::make((string)$otp),
            'expires_at'    => now()->addMinutes(10),
            'attempt_count' => 0,
            'max_attempts'  => 5,
            'last_sent_at'  => now(),
            'request_ip'    => $request->ip(),
        ]);

        $mailBody = "Hello,\n\n"
            . "A password reset was requested for your Maha Construction Admin account.\n\n"
            . "Your 6-digit verification code is: {$otp}\n\n"
            . "This code is valid for 10 minutes. If you did not request this, please ignore this email and ensure your account remains secure.\n\n"
            . "SECURITY NOTICE: Maha Construction will never ask you to share your verification code or password.\n\n"
            . "Regards,\nMaha Construction Admin Team";

        try {
            Mail::raw($mailBody, function ($message) use ($email) {
                $fromAddress = config('mail.from.address') ?: config('auth.admin_email');
                $fromName    = config('mail.from.name') ?: 'Maha Construction';
                $message->from($fromAddress, $fromName)
                        ->to($email)
                        ->subject('Maha Construction - Admin Password Reset Code');
            });
        } catch (\Throwable $e) {
            Log::error('Password reset email could not be sent: ' . $e->getMessage());
            $challenge->delete();
            return response()->json([
                'message' => 'Failed to deliver verification email. Please check server mail settings or try again later.',
                'detail'  => 'Failed to deliver verification email. Please check server mail settings or try again later.'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Verification code sent to your registered email address.'
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|string',
        ], [
            'email.required' => 'Please enter your admin email address.',
            'otp.required'   => 'Please enter the 6-digit verification code.',
        ]);

        $email              = strtolower(trim($request->email));
        $officialAdminEmail = strtolower(trim(config('auth.admin_email', 'mahaconstructions2013@gmail.com')));
        $user               = User::where('email', $email)->first();

        if (!$user || $user->role !== 'admin' || !$user->is_active || $email !== $officialAdminEmail) {
            return response()->json([
                'message' => 'Invalid email address. Please enter the valid admin email to reset your password.',
                'detail'  => 'Invalid email address. Please enter the valid admin email to reset your password.'
            ], 422);
        }

        return DB::transaction(function () use ($request, $user) {
            $challenge = PasswordResetChallenge::where('admin_user_id', $user->id)
                ->whereNull('used_at')
                ->latest('id')
                ->lockForUpdate()
                ->first();

            if (!$challenge || $challenge->isExpired()) {
                return response()->json([
                    'message' => 'Verification code has expired or is invalid. Please request a new code.',
                    'detail'  => 'Verification code has expired or is invalid. Please request a new code.'
                ], 400);
            }

            if ($challenge->hasExceededAttempts()) {
                $challenge->update(['used_at' => now()]);
                return response()->json([
                    'message' => 'Maximum verification attempts exceeded. Please request a new code.',
                    'detail'  => 'Maximum verification attempts exceeded. Please request a new code.'
                ], 429);
            }

            if (!Hash::check(trim((string)$request->otp), $challenge->otp_hash)) {
                $newAttempts = $challenge->attempt_count + 1;
                $challenge->attempt_count = $newAttempts;

                if ($newAttempts >= $challenge->max_attempts) {
                    $challenge->used_at = now();
                    $challenge->save();
                    return response()->json([
                        'message' => 'Maximum verification attempts exceeded. Please request a new code.',
                        'detail'  => 'Maximum verification attempts exceeded. Please request a new code.'
                    ], 429);
                }

                $challenge->save();
                $remaining = $challenge->max_attempts - $newAttempts;
                return response()->json([
                    'message' => "Incorrect verification code. {$remaining} attempts remaining.",
                    'detail'  => "Incorrect verification code. {$remaining} attempts remaining."
                ], 400);
            }

            // OTP verified! Invalidate OTP immediately (single-use)
            $challenge->used_at = now();

            // Create short-lived, single-use reset authorization token (Requirement 2)
            $plainResetToken = Str::random(64);
            $challenge->reset_token_hash = hash('sha256', $plainResetToken);
            $challenge->reset_token_expires_at = now()->addMinutes(10);
            $challenge->save();

            return response()->json([
                'success'     => true,
                'message'     => 'Verification code verified successfully.',
                'reset_token' => $plainResetToken,
            ]);
        });
    }

    public function resetPassword(Request $request)
    {
        $rules = [
            'email'        => 'required|email',
            'new_password' => 'required|string|min:12',
        ];
        if ($request->has('new_password_confirmation')) {
            $rules['new_password'] .= '|confirmed';
        }
        $request->validate($rules, [
            'new_password.min'       => 'Password must be at least 12 characters long.',
            'new_password.confirmed' => 'Passwords do not match.',
        ]);

        $email              = strtolower(trim($request->email));
        $officialAdminEmail = strtolower(trim(config('auth.admin_email', 'mahaconstructions2013@gmail.com')));
        $user               = User::where('email', $email)->first();

        if (!$user || $user->role !== 'admin' || !$user->is_active || $email !== $officialAdminEmail) {
            return response()->json([
                'detail'  => 'Invalid email address. Please enter the valid admin email to reset your password.',
                'message' => 'Invalid email address. Please enter the valid admin email to reset your password.'
            ], 422);
        }

        return DB::transaction(function () use ($request, $user) {
            $challenge = null;

            if ($request->filled('reset_token')) {
                $tokenHash = hash('sha256', trim((string)$request->reset_token));
                $challenge = PasswordResetChallenge::where('admin_user_id', $user->id)
                    ->where('reset_token_hash', $tokenHash)
                    ->whereNull('reset_token_used_at')
                    ->where('reset_token_expires_at', '>', now())
                    ->lockForUpdate()
                    ->first();
            } elseif ($request->filled('otp')) {
                // Fallback direct OTP consumption support
                $challenge = PasswordResetChallenge::where('admin_user_id', $user->id)
                    ->whereNull('used_at')
                    ->where('expires_at', '>', now())
                    ->latest('id')
                    ->lockForUpdate()
                    ->first();

                if ($challenge && Hash::check(trim((string)$request->otp), $challenge->otp_hash)) {
                    $challenge->used_at = now();
                } else {
                    $challenge = null;
                }
            }

            if (!$challenge) {
                return response()->json([
                    'detail'  => 'Invalid or expired reset authorization. Please request a new verification code.',
                    'message' => 'Invalid or expired reset authorization. Please request a new verification code.'
                ], 400);
            }

            // Invalidate the reset token immediately (single-use)
            $challenge->reset_token_used_at = now();
            $challenge->save();

            // Update password hash (bcrypt)
            $user->update(['password' => Hash::make($request->new_password)]);

            // Invalidate all Sanctum API tokens for this admin
            $user->tokens()->delete();

            // Invalidate any active admin sessions in database
            try {
                if (\Illuminate\Support\Facades\Schema::hasTable('sessions')) {
                    \Illuminate\Support\Facades\DB::table('sessions')->where('user_id', $user->id)->delete();
                }
            } catch (\Throwable $e) {
                // Ignore if sessions table not present or does not use user_id
            }

            // If the current request has an active session, invalidate it
            if ($request->hasSession()) {
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }

            return response()->json([
                'success' => true,
                'message' => 'Password reset successfully. Please login using your new password.'
            ]);
        });
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
