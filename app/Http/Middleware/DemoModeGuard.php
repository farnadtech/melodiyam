<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DemoModeGuard
{
    /**
     * HTTP methods that are considered "read-only" and allowed in demo mode.
     */
    protected array $allowedMethods = ['GET', 'HEAD', 'OPTIONS'];

    /**
     * Routes that demo users are allowed to POST to (e.g. logout).
     */
    protected array $allowedRoutes = [
        'logout',
        'filament.admin.auth.logout',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->isDemo()) {
            return $next($request);
        }

        // Allow read-only methods
        if (in_array($request->method(), $this->allowedMethods)) {
            return $next($request);
        }

        // Allow specific routes (like logout)
        $routeName = $request->route()?->getName();
        if ($routeName && in_array($routeName, $this->allowedRoutes)) {
            return $next($request);
        }

        // Block all write operations for demo users
        $message = 'شما در حالت نمایشی (دمو) هستید و امکان ایجاد تغییرات را ندارید.';

        // Livewire request - return valid 200 response (no-op) to prevent Livewire errors
        if ($request->hasHeader('X-Livewire')) {
            $components = $request->input('components', []);
            $componentResponses = [];

            foreach ($components as $i => $componentPayload) {
                $snapshot = json_decode($componentPayload['snapshot'] ?? '{}', true);
                $componentResponses[] = [
                    'snapshot' => $componentPayload['snapshot'] ?? '{}',
                    'effects' => $i === 0 ? [
                        'dispatches' => [
                            ['name' => 'demo-blocked', 'params' => ['message' => $message]],
                        ],
                    ] : [],
                ];
            }

            return response()->json([
                'components' => $componentResponses,
                'assets' => [],
            ], 200);
        }

        // API request
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => false,
                'message' => $message,
            ], 403);
        }

        // Filament admin request
        if ($request->is('admin/*') || $request->is('admin')) {
            // For Filament actions (AJAX), return JSON
            if ($request->wantsJson() || $request->hasHeader('X-Filament')) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 403);
            }

            return redirect()
                ->back()
                ->with('error', $message);
        }

        // Regular web request
        return redirect()
            ->back()
            ->with('error', $message);
    }
}
