<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Standard security headers
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'no-referrer-when-downgrade');
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), browsing-topics=()');

        // Tell reverse proxies (Nginx, Cloudflare, etc.) to serve different HTML per session.
        // Without this, a proxy may cache a logged-in page and serve it to a logged-out user.
        $response->headers->set('Vary', 'Cookie, Accept-Encoding');
        
        // Disable Caching to prevent stale data in SPA-like navigation (Livewire wire:navigate)
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, proxy-revalidate, max-age=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        // Content Security Policy (CSP)
        // Optimized for Laravel, Livewire, and Alpine.js
        $csp = "default-src 'self'; ";
        $csp .= "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://www.google-analytics.com https://www.googletagmanager.com; ";
        $csp .= "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net; ";
        $csp .= "img-src 'self' data: https: blob:; ";
        $csp .= "font-src 'self' https://fonts.gstatic.com data:; ";
        $csp .= "connect-src 'self' https://www.google-analytics.com https://www.googletagmanager.com; ";
        $csp .= "media-src 'self' data: https: blob:; ";
        $csp .= "object-src 'none'; ";
        $csp .= "frame-src 'self' https://www.youtube.com https://player.vimeo.com; ";
        $csp .= "base-uri 'self'; ";
        $csp .= "form-action 'self';";
        
        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
