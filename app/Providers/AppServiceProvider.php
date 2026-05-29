<?php

namespace App\Providers;

use App\Helpers\Jalali;
use App\Models\Setting;
use Illuminate\Support\Facades\Blade;
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
        // Jalali Blade directives
        Blade::directive('jalali', function ($expression) {
            return "<?php echo \App\Helpers\Jalali::format($expression); ?>";
        });
        Blade::directive('jalalifull', function ($expression) {
            return "<?php echo \App\Helpers\Jalali::formatFull($expression); ?>";
        });

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
                
                $logo = $settings['site_logo'] ?? null;
                View::share('siteLogo',        $logo ? asset('storage/' . $logo) : null);
                
                $favicon = $settings['site_favicon'] ?? null;
                View::share('siteFavicon',     $favicon ? asset('storage/' . $favicon) : asset('images/favicon.ico'));

                View::share('showSiteName',       ($settings['show_site_name_in_sidebar'] ?? '1') === '1');
                View::share('logoHeight',         (int) ($settings['logo_height_px'] ?? 40));

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

                // ── Dynamic Storage Configuration ──
                $driver = $settings['storage_driver'] ?? 'local';
                if ($driver === 'ftp' && !empty($settings['ftp_host'])) {
                    config([
                        'filesystems.disks.public.driver'   => 'ftp',
                        'filesystems.disks.public.host'     => $settings['ftp_host'],
                        'filesystems.disks.public.username' => $settings['ftp_username'] ?? '',
                        'filesystems.disks.public.password' => $settings['ftp_password'] ?? '',
                        'filesystems.disks.public.port'     => (int) ($settings['ftp_port'] ?? 21),
                        'filesystems.disks.public.root'     => $settings['ftp_root'] ?? '/',
                        'filesystems.disks.public.url'      => rtrim($settings['ftp_url'] ?? '', '/'),
                        'filesystems.disks.public.passive'  => true,
                        'filesystems.disks.public.ssl'      => false,
                        'filesystems.disks.public.timeout'  => 30,
                    ]);
                }

                // ── Dynamic SMTP Configuration ──
                if (!empty($settings['smtp_host'])) {
                    config([
                        'mail.default' => 'smtp',
                        'mail.mailers.smtp.host'       => $settings['smtp_host'],
                        'mail.mailers.smtp.port'       => (int) ($settings['smtp_port'] ?? 587),
                        'mail.mailers.smtp.encryption' => ($settings['smtp_encryption'] ?? 'tls') === 'none' ? null : ($settings['smtp_encryption'] ?? 'tls'),
                        'mail.mailers.smtp.username'   => $settings['smtp_username'] ?? '',
                        'mail.mailers.smtp.password'   => $settings['smtp_password'] ?? '',
                        'mail.from.address'            => $settings['mail_from_address'] ?? 'noreply@melodiyam.ir',
                        'mail.from.name'               => $settings['mail_from_name'] ?? config('app.name'),
                    ]);
                }
            } catch (\Exception $e) {
                // silently fail if settings table not ready yet
            }
        }
    }
}
