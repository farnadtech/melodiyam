<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnforceVerification
{
    /**
     * Routes that unverified users CAN access.
     */
    protected array $except = [
        'verify-account',
        'logout',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Only applies to authenticated, non-admin users
        if (!$user || $user->isAdmin() || $user->isModerator() || $user->isDemo()) {
            return $next($request);
        }

        $requireEmail = Setting::get('email_verification', '0') === '1';
        $requirePhone = Setting::get('phone_verification', '0') === '1';

        $needsEmailVerification = $requireEmail && !$user->email_verified_at && $user->email;
        $needsPhoneVerification = $requirePhone && !$user->phone_verified_at && $user->phone;

        // If user has no email but email verification is required, they need to provide one
        $needsEmailSetup = $requireEmail && !$user->email;
        // If user has no phone but phone verification is required, they need to provide one
        $needsPhoneSetup = $requirePhone && !$user->phone;

        $needsVerification = $needsEmailVerification || $needsPhoneVerification || $needsEmailSetup || $needsPhoneSetup;

        if (!$needsVerification) {
            return $next($request);
        }

        // Allow access to verification page and logout
        $path = ltrim($request->path(), '/');
        foreach ($this->except as $except) {
            if ($path === $except || str_starts_with($path, $except . '/')) {
                return $next($request);
            }
        }

        // Also allow Livewire asset requests
        if ($request->is('livewire*')) {
            return $next($request);
        }

        return redirect()->route('verify-account');
    }
}
