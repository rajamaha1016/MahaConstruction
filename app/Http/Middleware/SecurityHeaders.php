<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request and attach standard security headers.
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        // Clickjacking Defense
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Prevent MIME-Type Sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Referrer Privacy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Restrict sensitive hardware features
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        // HTTP Strict Transport Security (HSTS) when on HTTPS
        if ($request->isSecure() || $request->server('HTTP_X_FORWARDED_PROTO') === 'https') {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }
}
