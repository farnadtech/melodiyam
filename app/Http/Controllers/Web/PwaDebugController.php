<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class PwaDebugController extends Controller
{
    public function __invoke(Request $request)
    {
        $manifestUrl = route('pwa.manifest');
        $manifestFallbackUrl = route('pwa.manifest.fallback');
        
        // Call ManifestController directly instead of file_get_contents (avoids self-HTTP issues)
        $manifestController = new \App\Http\Controllers\Web\ManifestController();
        $manifestResponse = $manifestController();
        $manifestContent = $manifestResponse->getContent();
        $manifest = json_decode($manifestContent, true);

        $lines = [];
        $lines[] = '<!DOCTYPE html><html dir="rtl" lang="fa"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>PWA Debug</title>';
        $lines[] = '<style>body{font-family:monospace;padding:20px;background:#0f172a;color:#e2e8f0;line-height:1.8} .ok{color:#10b981} .fail{color:#ef4444} .warn{color:#f59e0b} h2{color:#0ea5e9;margin-top:24px} pre{background:#1e293b;padding:12px;border-radius:8px;overflow-x:auto;font-size:12px;direction:ltr;text-align:left}</style></head><body>';

        $lines[] = '<h1>PWA Diagnostic</h1>';
        $lines[] = '<p>URL: ' . e($request->url()) . '</p>';
        $lines[] = '<p>Time: ' . now()->toDateTimeString() . '</p>';

        // 1. HTTPS
        $lines[] = '<h2>1. HTTPS</h2>';
        $isHttps = $request->secure();
        $lines[] = $isHttps
            ? '<p class="ok">OK: HTTPS active</p>'
            : '<p class="fail">FAIL: NOT HTTPS — PWA requires HTTPS!</p>';

        // 2. Manifest
        $lines[] = '<h2>2. Manifest</h2>';
        $lines[] = '<p>Primary URL: <a href="' . e($manifestUrl) . '" style="color:#0ea5e9">' . e($manifestUrl) . '</a></p>';
        $lines[] = '<p>Fallback URL: <a href="' . e($manifestFallbackUrl) . '" style="color:#0ea5e9">' . e($manifestFallbackUrl) . '</a></p>';

        if ($manifest) {
            $lines[] = '<p class="ok">OK: ManifestController returned valid JSON</p>';
            $keys = ['name', 'short_name', 'display', 'start_url', 'scope', 'theme_color', 'background_color', 'id', 'display_override'];
            foreach ($keys as $k) {
                $val = $manifest[$k] ?? 'MISSING';
                if (is_array($val)) $val = json_encode($val);
                $lines[] = '<p>' . e($k) . ': <strong>' . e($val) . '</strong></p>';
            }

            // Icons
            $lines[] = '<h3>Icons:</h3>';
            if (!empty($manifest['icons'])) {
                foreach ($manifest['icons'] as $icon) {
                    $src = $icon['src'] ?? 'MISSING';
                    $sizes = $icon['sizes'] ?? '?';
                    $purpose = $icon['purpose'] ?? 'any';
                    $iconOk = true;
                    $httpCode = null;
                    if (str_starts_with($src, 'http')) {
                        $ch = curl_init($src);
                        curl_setopt($ch, CURLOPT_NOBODY, true);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                        curl_exec($ch);
                        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                        curl_close($ch);
                        $iconOk = ($httpCode === 200);
                    }
                    $status = $iconOk ? 'ok' : 'fail';
                    $label = $iconOk ? 'OK' : 'FAIL (HTTP ' . $httpCode . ')';
                    $lines[] = '<p class="' . $status . '">' . $label . ' ' . e($sizes) . ' / ' . e($purpose) . ' — <a href="' . e($src) . '" style="color:#0ea5e9">' . e($src) . '</a></p>';
                }
            } else {
                $lines[] = '<p class="fail">FAIL: No icons in manifest!</p>';
            }

            $lines[] = '<h3>Raw Manifest:</h3>';
            $lines[] = '<pre>' . e(json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) . '</pre>';
        } else {
            $lines[] = '<p class="fail">FAIL: Could not load manifest!</p>';
            if ($manifestContent) {
                $lines[] = '<pre>' . e(substr($manifestContent, 0, 500)) . '</pre>';
            }
        }

        // 3. PWA Settings
        $lines[] = '<h2>3. PWA Settings</h2>';
        $pwaEnabled = Setting::get('pwa_enabled', '1');
        $lines[] = '<p>pwa_enabled: <strong>' . e($pwaEnabled) . '</strong> ' . (($pwaEnabled === '1') ? '<span class="ok">(enabled)</span>' : '<span class="fail">(DISABLED!)</span>') . '</p>';

        $settingsKeys = [
            'pwa_name' => config('app.name'),
            'pwa_short_name' => config('app.name'),
            'pwa_display' => 'standalone',
            'pwa_theme_color' => '#0ea5e9',
            'pwa_bg_color' => '#020617',
            'pwa_icon_192' => null,
            'pwa_icon_512' => null,
            'pwa_icon_180' => null,
        ];
        foreach ($settingsKeys as $key => $default) {
            $val = Setting::get($key, $default);
            $lines[] = '<p>' . e($key) . ': <strong>' . e($val ?: '(empty)') . '</strong></p>';
        }

        // 4. Verification Middleware
        $lines[] = '<h2>4. Verification Middleware</h2>';
        $emailVer = Setting::get('email_verification', '0');
        $phoneVer = Setting::get('phone_verification', '0');
        $lines[] = '<p>email_verification: ' . e($emailVer) . ' ' . ($emailVer === '1' ? '(ON)' : '(OFF)') . '</p>';
        $lines[] = '<p>phone_verification: ' . e($phoneVer) . ' ' . ($phoneVer === '1' ? '(ON)' : '(OFF)') . '</p>';

        // 5. Service Worker
        $lines[] = '<h2>5. Service Worker</h2>';
        $swPath = public_path('sw.js');
        if (file_exists($swPath)) {
            $lines[] = '<p class="ok">OK: sw.js exists (' . filesize($swPath) . ' bytes)</p>';
            $lines[] = '<p>URL: <a href="/sw.js" style="color:#0ea5e9">/sw.js</a></p>';
        } else {
            $lines[] = '<p class="fail">FAIL: sw.js NOT found!</p>';
        }

        // 6. Fallback Icons
        $lines[] = '<h2>6. Fallback Icons</h2>';
        foreach ([192, 512, 180] as $s) {
            $path = public_path("images/pwa-icon-{$s}.png");
            if (file_exists($path)) {
                $lines[] = '<p class="ok">OK: pwa-icon-' . $s . '.png (' . filesize($path) . ' bytes)</p>';
            } else {
                $lines[] = '<p class="fail">FAIL: pwa-icon-' . $s . '.png MISSING</p>';
            }
        }

        // 7. APP_URL
        $lines[] = '<h2>7. APP_URL / Asset URLs</h2>';
        $lines[] = '<p>config(app.url): <strong>' . e(config('app.url')) . '</strong></p>';
        $lines[] = '<p>asset() base: <strong>' . e(asset('')) . '</strong></p>';
        $lines[] = '<p>request scheme: <strong>' . e($request->getScheme()) . '</strong></p>';
        $lines[] = '<p>request host: <strong>' . e($request->getHost()) . '</strong></p>';

        $lines[] = '<br><br><p style="color:#64748b">End of server diagnostics</p>';
        
        // Client-side manifest test (JavaScript) - test both URLs
        $lines[] = '<h2>8. Browser Manifest Test (JavaScript)</h2>';
        $lines[] = '<div id="browser-manifest-test" style="color:#f59e0b">Testing...</div>';
        $lines[] = '<h3 style="margin-top:12px">Test /manifest.json (fallback):</h3>';
        $lines[] = '<div id="browser-manifest-fallback-test" style="color:#f59e0b">Testing...</div>';
        $lines[] = '<script>';
        $lines[] = 'function testManifest(url, elId) {';
        $lines[] = '  fetch(url, {credentials: "omit"})';
        $lines[] = '    .then(function(r) { return r.text(); })';
        $lines[] = '    .then(function(text) {';
        $lines[] = '      var el = document.getElementById(elId);';
        $lines[] = '      try {';
        $lines[] = '        var j = JSON.parse(text);';
        $lines[] = '        if (j.name && j.icons) {';
        $lines[] = '          el.innerHTML = \'<p style="color:#10b981">OK: Valid PWA manifest (name: \' + j.name + \', icons: \' + j.icons.length + \')</p>\';';
        $lines[] = '        } else {';
        $lines[] = '          el.innerHTML = \'<p style="color:#ef4444">FAIL: JSON but NOT a valid manifest!</p><pre style="background:#1e293b;padding:8px;border-radius:4px;font-size:11px;direction:ltr">\' + text.substring(0,300) + \'</pre>\';';
        $lines[] = '        }';
        $lines[] = '      } catch(e) {';
        $lines[] = '        el.innerHTML = \'<p style="color:#ef4444">FAIL: Response is not JSON!</p><pre style="background:#1e293b;padding:8px;border-radius:4px;font-size:11px;direction:ltr">\' + text.substring(0,300) + \'</pre>\';';
        $lines[] = '      }';
        $lines[] = '    })';
        $lines[] = '    .catch(function(e) {';
        $lines[] = '      document.getElementById(elId).innerHTML = \'<p style="color:#ef4444">FAIL: \' + e.message + \'</p>\';';
        $lines[] = '    });';
        $lines[] = '}';
        $lines[] = 'testManifest("/pwa-manifest.json", "browser-manifest-test");';
        $lines[] = 'testManifest("/manifest.json", "browser-manifest-fallback-test");';
        $lines[] = '</script>';
        
        $lines[] = '</body></html>';

        return response(implode("\n", $lines));
    }
}
