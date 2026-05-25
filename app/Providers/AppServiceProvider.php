<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (!app()->runningInConsole() && Schema::hasTable('settings')) {
            try {
                $settings = Setting::getAll();

                // override config with DB values
                if (!empty($settings['site_name'])) {
                    config(['app.name' => $settings['site_name']]);
                }

                // share with all Blade views
                View::share('siteName',        $settings['site_name']        ?? config('app.name'));
                View::share('siteDescription', $settings['site_description'] ?? '');
                View::share('siteLogo',        $settings['site_logo']        ? asset('storage/' . $settings['site_logo']) : null);
                View::share('siteFavicon',     $settings['site_favicon']     ? asset('storage/' . $settings['site_favicon']) : null);
                View::share('metaTitle',       $settings['meta_title']       ?? config('app.name'));
                View::share('metaDescription', $settings['meta_description'] ?? '');
                View::share('metaKeywords',    $settings['meta_keywords']    ?? '');
                View::share('googleAnalytics', $settings['google_analytics'] ?? '');
                View::share('socialLinks', [
                    'instagram' => $settings['social_instagram'] ?? '',
                    'telegram'  => $settings['social_telegram']  ?? '',
                    'twitter'   => $settings['social_twitter']   ?? '',
                    'youtube'   => $settings['social_youtube']   ?? '',
                    'aparat'    => $settings['social_aparat']    ?? '',
                ]);
                View::share('maintenanceMode',    ($settings['maintenance_mode']    ?? '0') === '1');
                View::share('maintenanceMessage', $settings['maintenance_message']  ?? '');
                View::share('premiumEnabled',     ($settings['premium_enabled']     ?? '1') === '1');
                View::share('allowRegistration',  ($settings['allow_registration']  ?? '1') === '1');
            } catch (\Exception $e) {
                // silently fail if settings table not ready yet
            }
        }
    }
}
