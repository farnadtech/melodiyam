<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;

class ManifestController extends Controller
{
    public function __invoke(): JsonResponse
    {
        if (!Setting::get('pwa_enabled', '1')) {
            return response()->json(['error' => 'PWA disabled'], 404);
        }

        $name = Setting::get('pwa_name', config('app.name'));
        $shortName = Setting::get('pwa_short_name', config('app.name'));
        $themeColor = Setting::get('pwa_theme_color', '#0ea5e9');
        $bgColor = Setting::get('pwa_bg_color', '#020617');
        $display = Setting::get('pwa_display', 'standalone');

        // Get base path for scope and start_url
        $basePath = parse_url(config('app.url'), PHP_URL_PATH) ?: '/';
        $basePath = rtrim($basePath, '/') . '/';

        $icons = [];
        foreach ([192, 512] as $size) {
            $path = Setting::get("pwa_icon_{$size}");
            if ($path) {
                $icons[] = [
                    'src' => asset('storage/' . $path),
                    'sizes' => "{$size}x{$size}",
                    'type' => 'image/png',
                    'purpose' => 'any',
                ];
            }
        }

        // Add maskable variant for 512
        $path512 = Setting::get('pwa_icon_512');
        if ($path512) {
            $icons[] = [
                'src' => asset('storage/' . $path512),
                'sizes' => '512x512',
                'type' => 'image/png',
                'purpose' => 'maskable',
            ];
        }

        // Fallback icon if none uploaded
        if (empty($icons)) {
            $icons[] = [
                'src' => asset('images/pwa-icon-192.png'),
                'sizes' => '192x192',
                'type' => 'image/png',
                'purpose' => 'any',
            ];
            $icons[] = [
                'src' => asset('images/pwa-icon-512.png'),
                'sizes' => '512x512',
                'type' => 'image/png',
                'purpose' => 'any',
            ];
            $icons[] = [
                'src' => asset('images/pwa-icon-512.png'),
                'sizes' => '512x512',
                'type' => 'image/png',
                'purpose' => 'maskable',
            ];
        }

        return response()->json([
            'name' => $name,
            'short_name' => $shortName,
            'description' => Setting::get('site_description', ''),
            'start_url' => $basePath . '?source=pwa',
            'scope' => $basePath,
            'display' => $display,
            'display_override' => ['standalone', 'fullscreen', 'minimal-ui'],
            'orientation' => 'portrait',
            'theme_color' => $themeColor,
            'background_color' => $bgColor,
            'dir' => 'rtl',
            'lang' => 'fa',
            'id' => $basePath,
            'categories' => ['music', 'entertainment'],
            'icons' => $icons,
        ], 200, [
            'Content-Type' => 'application/manifest+json',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Access-Control-Allow-Origin' => '*',
        ]);
    }
}
