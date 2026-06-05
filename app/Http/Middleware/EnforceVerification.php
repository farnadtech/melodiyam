<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnforceVerification
{
    /**
     * Route names that unverified users CAN access.
     */
    protected array $exceptRoutes = [
        'verify-account',
        'logout',
        'login',
        'register',
        'password.request',
        'password.reset',
        'pwa.manifest',
        'pwa.manifest.fallback',
        'pwa.debug',
    ];

    /**
     * Path prefixes that unverified users CAN access.
     */
    protected array $exceptPaths = [
        'verify-account',
        'livewire',
        'login',
        'register',
        'forgot-password',
        'reset-password',
        'manifest.json',
        'pwa-manifest.json',
        'sw.js',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Only applies to authenticated, non-admin users
        if (!$user || $user->isAdmin() || $user->isModerator() || $user->isDemo()) {
            return $next($request);
        }

        // ALWAYS allow Livewire AJAX requests through (prevents JSON parse errors)
        // Livewire sends X-Livewire header on all update requests
        if ($request->hasHeader('X-Livewire') || $request->is('livewire/*')) {
            return $next($request);
        }

        $requireEmail = Setting::get('email_verification', '0') === '1';
        $requirePhone = Setting::get('phone_verification', '0') === '1';

        // If neither is required, pass through
        if (!$requireEmail && !$requirePhone) {
            return $next($request);
        }

        // Check what needs verification
        $needsEmailVerification = $requireEmail && !$user->email_verified_at;
        $needsPhoneVerification = $requirePhone && !$user->phone_verified_at;

        if (!$needsEmailVerification && !$needsPhoneVerification) {
            return $next($request);
        }

        // Allow access by route name
        $routeName = $request->route()?->getName();
        if ($routeName && in_array($routeName, $this->exceptRoutes)) {
            return $next($request);
        }

        // Allow access by path prefix
        $path = ltrim($request->path(), '/');
        foreach ($this->exceptPaths as $prefix) {
            if ($path === $prefix || str_starts_with($path, $prefix . '/') || str_starts_with($path, $prefix . '?')) {
                return $next($request);
            }
        }

        // Redirect to verification page
        return redirect()->route('verify-account');
    }
}
