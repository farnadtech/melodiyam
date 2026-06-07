<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class EnforceMaxDevices
{
    /**
     * Enforce max concurrent device sessions per premium plan.
     * Runs on every authenticated request so that pre-existing
     * sessions (created before the limit was set) are also cleaned up.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();

        // Throttle: check at most once per 60 seconds per user
        $cacheKey = 'max_dev_chk_' . $user->id;
        if (Cache::has($cacheKey)) {
            return $next($request);
        }
        Cache::put($cacheKey, true, 60);

        // Only enforce for premium users
        if (! $user->isPremium()) {
            return $next($request);
        }

        $plan       = $user->activeSubscription()?->first()?->plan;
        $maxDevices = (int) ($plan?->max_devices ?? 1);

        // Persist current session to DB before counting (it may not be saved yet)
        if ($request->hasSession()) {
            $request->session()->save();
        }

        // Sessions ordered newest-first; keep the top $maxDevices, delete the rest
        // MySQL requires LIMIT with OFFSET, so we fetch IDs and slice in PHP
        $allSessionIds = DB::table('sessions')
            ->where('user_id', $user->id)
            ->orderByDesc('last_activity')
            ->pluck('id')
            ->slice($maxDevices);

        if ($allSessionIds->isNotEmpty()) {
            DB::table('sessions')
                ->whereIn('id', $allSessionIds)
                ->delete();
        }

        return $next($request);
    }
}
