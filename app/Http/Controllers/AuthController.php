<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\PasswordResetChallenge;
use App\Mail\AdminPasswordResetMail;
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

        // Generate cryptographically secure 6-digit OTP and single-use reset authorization token
        $otp = random_int(100000, 999999);
        $plainResetToken = Str::random(64);
        $expiresAt = now()->addMinutes(15);

        $challenge = PasswordResetChallenge::create([
            'admin_user_id'          => $user->id,
            'otp_hash'               => Hash::make((string)$otp),
            'expires_at'             => $expiresAt,
            'attempt_count'          => 0,
            'max_attempts'           => 5,
            'last_sent_at'           => now(),
            'request_ip'             => $request->ip(),
            'reset_token_hash'       => hash('sha256', $plainResetToken),
            'reset_token_expires_at' => $expiresAt,
        ]);

        $isProductionEnv = app()->environment('production');
        $isLocalHost     = in_array($request->getHost(), ['localhost', '127.0.0.1', '::1']);

        // ── Reset URL: determined entirely from APP_URL environment variable ─────────────
        // The hosting platform (any provider) sets APP_URL=https://your-production-domain.com
        // No platform-specific logic — the code is portable to any host.
        $configuredUrl     = rtrim((string) config('app.url'), '/');
        $isConfiguredLocal = empty($configuredUrl) || preg_match('/localhost|127\.0\.0\.1|::1/i', $configuredUrl);

        if ($isProductionEnv || !$isLocalHost) {
            if (!$isConfiguredLocal) {
                // APP_URL is a real domain — use it directly
                $baseUrl = $configuredUrl;
            } elseif (!$isLocalHost) {
                // APP_URL not set or is localhost but request came from a real host:
                // infer from the incoming request (behind a reverse proxy)
                $scheme  = ($request->isSecure() || $request->server('HTTP_X_FORWARDED_PROTO') === 'https') ? 'https' : 'http';
                $baseUrl = $scheme . '://' . $request->getHttpHost();
            } else {
                // Absolute last resort: APP_URL is misconfigured; log a warning
                // and use a safe non-localhost placeholder that will be visible in the error
                $baseUrl = $configuredUrl ?: 'https://CONFIGURE_APP_URL_IN_ENV';
            }

            // Ensure https on production (never http for a real domain)
            if (!str_starts_with($baseUrl, 'https://') && !preg_match('/localhost|127\.0\.0\.1|::1/i', $baseUrl)) {
                $baseUrl = preg_replace('/^http:\/\//i', 'https://', $baseUrl);
            }

            $resetPath = route('admin.reset_password.show', ['token' => $plainResetToken], false);
            $resetUrl  = $baseUrl . $resetPath;
        } else {
            // Local development: use APP_URL or fall back to named route (safe — no real email sent)
            $resetUrl = $configuredUrl
                ? $configuredUrl . route('admin.reset_password.show', ['token' => $plainResetToken], false)
                : route('admin.reset_password.show', ['token' => $plainResetToken]);
        }

        try {
            if ($isProductionEnv) {
                // Production environment: send real verification email via configured Gmail SMTP
                Mail::mailer('smtp')->to($email)->send(new AdminPasswordResetMail((string)$otp, $resetUrl));
            } else {
                // Local / Development environment safeguard:
                // Do NOT send real emails to Gmail SMTP or contact the real admin account from local.
                // Safely log the mailable to Laravel log (or array in tests) so the local UI and dev testing work seamlessly.
                $localMailer = app()->environment('testing') ? (config('mail.default') === 'array' ? 'array' : 'log') : 'log';
                Mail::mailer($localMailer)->to($email)->send(new AdminPasswordResetMail((string)$otp, $resetUrl));

                Log::info('[LOCAL/DEV] Password reset OTP generated for local testing (No email sent to Gmail)', [
                    'admin_email' => $email,
                    'environment' => app()->environment(),
                    'mailer'      => $localMailer,
                ]);
            }
        } catch (\Throwable $e) {
            // Log safe diagnostics — NO credentials, NO OTP, NO reset tokens
            Log::error('[MAIL FAILURE] Password reset email could not be sent.', [
                'exception_class'   => get_class($e),
                'exception_message' => $e->getMessage(),
                'app_environment'   => app()->environment(),
                'mail_mailer_used'  => $isProductionEnv ? 'smtp' : ($localMailer ?? 'log'),
                'mail_host'         => config('mail.mailers.smtp.host', '(not set)'),
                'mail_port'         => config('mail.mailers.smtp.port', '(not set)'),
                'mail_encryption'   => config('mail.mailers.smtp.encryption', '(not set)'),
                'mail_from_address' => config('mail.from.address', '(not set)'),
                'mail_username_set' => !empty(config('mail.mailers.smtp.username')),
                'mail_password_set' => !empty(config('mail.mailers.smtp.password')),
            ]);
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

            // Create short-lived, single-use reset authorization token (15 minutes)
            $plainResetToken = Str::random(64);
            $challenge->reset_token_hash = hash('sha256', $plainResetToken);
            $challenge->reset_token_expires_at = now()->addMinutes(15);
            $challenge->save();

            return response()->json([
                'success'     => true,
                'message'     => 'Verification code verified successfully.',
                'reset_token' => $plainResetToken,
            ]);
        });
    }

    public function showResetPasswordForm(string $token)
    {
        $officialAdminEmail = strtolower(trim(config('auth.admin_email', 'mahaconstructions2013@gmail.com')));
        $tokenHash = hash('sha256', trim($token));

        $challenge = PasswordResetChallenge::where('reset_token_hash', $tokenHash)->first();

        if (
            !$challenge ||
            is_null($challenge->reset_token_expires_at) ||
            $challenge->reset_token_expires_at->isPast() ||
            !is_null($challenge->reset_token_used_at)
        ) {
            return response()->view('admin.reset-password-invalid', [
                'errorMessage' => 'This password reset link is invalid or has expired. Please request a new password reset.',
            ], 400);
        }

        $adminUser = $challenge->adminUser;
        if (
            !$adminUser ||
            !$adminUser->is_active ||
            $adminUser->role !== 'admin' ||
            strtolower(trim($adminUser->email)) !== $officialAdminEmail
        ) {
            return response()->view('admin.reset-password-invalid', [
                'errorMessage' => 'This password reset link is invalid or has expired. Please request a new password reset.',
            ], 400);
        }

        return view('admin.reset-password', [
            'token' => $token,
            'email' => $adminUser->email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $rules = [
            'email'        => 'required|email',
            'new_password' => 'required|string|min:6',
        ];
        if ($request->has('new_password_confirmation')) {
            $rules['new_password'] .= '|confirmed';
        }
        $request->validate($rules, [
            'new_password.required'  => 'Please enter a new password.',
            'new_password.min'       => 'Password must be at least 6 characters long.',
            'new_password.confirmed' => 'Passwords do not match.',
        ]);

        $email              = strtolower(trim($request->email));
        $officialAdminEmail = strtolower(trim(config('auth.admin_email', 'mahaconstructions2013@gmail.com')));
        $user               = User::where('email', $email)->first();

        if (!$user || $user->role !== 'admin' || !$user->is_active || $email !== $officialAdminEmail) {
            if ($request->expectsJson()) {
                return response()->json([
                    'detail'  => 'Invalid email address. Please enter the valid admin email to reset your password.',
                    'message' => 'Invalid email address. Please enter the valid admin email to reset your password.'
                ], 422);
            }
            return back()->withErrors(['email' => 'Invalid email address. Please enter the valid admin email to reset your password.']);
        }

        return DB::transaction(function () use ($request, $user) {
            $challenge = null;
            $tokenParam = $request->input('reset_token') ?: $request->input('token');

            if (!empty($tokenParam)) {
                $tokenHash = hash('sha256', trim((string)$tokenParam));
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
                if ($request->expectsJson()) {
                    return response()->json([
                        'detail'  => 'This password reset link is invalid or has expired. Please request a new password reset.',
                        'message' => 'This password reset link is invalid or has expired. Please request a new password reset.'
                    ], 400);
                }
                return response()->view('admin.reset-password-invalid', [
                    'errorMessage' => 'This password reset link is invalid or has expired. Please request a new password reset.',
                ], 400);
            }

            // Invalidate the reset token and OTP challenge immediately (single-use)
            $challenge->reset_token_used_at = now();
            $challenge->used_at = now();
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

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Password reset successfully. Please login using your new password.'
                ]);
            }

            return redirect()->route('admin.login')->with('success', 'Password reset successfully. Please login using your new password.');
        });
    }

    public function resetPasswordWeb(Request $request)
    {
        return $this->resetPassword($request);
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
