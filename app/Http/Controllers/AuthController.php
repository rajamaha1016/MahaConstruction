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

        $email = strtolower($request->email);
        $user  = User::where('email', $email)->first();

        // Always respond the same way whether or not the email exists, so the
        // endpoint can't be used to enumerate registered accounts.
        if ($user) {
            $otp = random_int(100000, 999999);
            cache()->put('otp_' . $email, $otp, 600);

            try {
                Mail::raw("Your Maha Construction password reset code is: {$otp}\nThis code expires in 10 minutes.", function ($message) use ($email) {
                    $message->to($email)->subject('Your password reset code');
                });
            } catch (\Throwable $e) {
                // MAIL_MAILER defaults to 'log', so delivery failures here mean
                // real SMTP is misconfigured, not that the OTP wasn't issued.
                Log::warning('Password reset email could not be sent: ' . $e->getMessage());
            }
        }

        return response()->json(['message' => 'If that email is registered, an OTP has been sent to it.']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'        => 'required|email',
            'otp'          => 'required|string',
            'new_password' => 'required|string|min:6',
        ]);

        $cached = cache()->get('otp_' . strtolower($request->email));
        if ((string)$cached !== (string)$request->otp) {
            return response()->json(['detail' => 'Invalid or expired OTP'], 400);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $user->update(['password' => Hash::make($request->new_password)]);
        cache()->forget('otp_' . strtolower($request->email));

        return response()->json(['message' => 'Password reset successfully']);
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
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            session(['admin_authenticated' => true, 'admin_email' => $user->email, 'admin_name' => $user->full_name]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function adminLogout()
    {
        session()->flush();
        return redirect()->route('admin.login');
    }
}
