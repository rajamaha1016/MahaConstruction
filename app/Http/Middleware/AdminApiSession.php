<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Session\Middleware\StartSession;

/**
 * Middleware for Admin API routes.
 * Decrypts browser cookies and boots the web session so session('admin_authenticated')
 * is correctly read on API calls from the admin panel.
 */
class AdminApiSession
{
    protected EncryptCookies $encryptCookies;
    protected StartSession $startSession;

    public function __construct(EncryptCookies $encryptCookies, StartSession $startSession)
    {
        $this->encryptCookies = $encryptCookies;
        $this->startSession   = $startSession;
    }

    public function handle(Request $request, Closure $next): Response
    {
        return $this->encryptCookies->handle($request, function ($req) use ($next) {
            return $this->startSession->handle($req, $next);
        });
    }
}
