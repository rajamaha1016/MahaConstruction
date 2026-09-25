<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class AdminAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('admin_authenticated') && !$request->user()) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated. Admin login required.'], 401);
            }
            return redirect()->route('admin.login');
        }

        // Verify that if a user is associated, they must be active and have the admin role
        $user = $request->user();
        if (!$user && session('admin_email')) {
            $user = User::where('email', session('admin_email'))->first();
        }

        if ($user && (!$user->is_active || $user->role !== 'admin')) {
            if ($request->hasSession()) {
                $request->session()->invalidate();
            }
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json(['message' => 'Forbidden. Active admin privileges required.'], 403);
            }
            return redirect()->route('admin.login')->withErrors(['email' => 'Your account is inactive or lacks administrative privileges.']);
        }

        return $next($request);
    }
}
