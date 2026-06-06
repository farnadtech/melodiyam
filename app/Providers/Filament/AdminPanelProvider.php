<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $settings = \App\Models\Setting::getAll();
        $logo = !empty($settings['site_logo']) ? asset('storage/' . $settings['site_logo']) : null;
        $favicon = !empty($settings['site_favicon']) ? asset('storage/' . $settings['site_favicon']) : asset('images/favicon.ico');
        
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName($settings['site_name'] ?? config('app.name'))
            ->brandLogo($logo)
            ->favicon($favicon)
            ->colors([
                'primary' => Color::Amber,
                'danger' => Color::Rose,
                'info' => Color::Blue,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->sidebarCollapsibleOnDesktop()
            ->sidebarWidth('280px')
            ->maxContentWidth('full')
            ->navigationGroups([
                'تنظیمات سیستم',
                'مدیریت موسیقی',
                'پادکست‌ها',
                'مدیریت کاربران',
                'مالی و اشتراک‌ها',
                'محتوا و ظاهر',
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
                \App\Filament\Pages\Settings::class,
                \App\Filament\Pages\NotificationSettings::class,
                \App\Filament\Pages\ArtistApplicationSettings::class,
                \App\Filament\Pages\Reports::class,
                \App\Filament\Pages\SystemUpdate::class,
                \App\Filament\Pages\SmartPlaylistSettings::class,
                \App\Filament\Pages\Sitemap::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                \App\Filament\Widgets\StatsOverview::class,
                \App\Filament\Widgets\RecentTracksTable::class,
                \App\Filament\Widgets\TopArtistsTable::class,
                \App\Filament\Widgets\RecentUsersTable::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                \App\Http\Middleware\DemoModeGuard::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->renderHook(
                PanelsRenderHook::HEAD_START,
                function (): string {
                    $fontFamily = \App\Models\Setting::get('theme_font_fa', 'Vazirmatn');
                    return '<link rel="preconnect" href="https://fonts.googleapis.com">'
                        . '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>'
                        . '<link href="https://fonts.googleapis.com/css2?family=' . urlencode($fontFamily) . ':wght@100..900&display=swap" rel="stylesheet">'
                        . '<style>:root{--font-sans:"' . e($fontFamily) . '",ui-sans-serif,system-ui,sans-serif;--font-serif:"' . e($fontFamily) . '",ui-serif,Georgia,sans-serif;--font-mono:ui-monospace,monospace;}body{font-family:"' . e($fontFamily) . '",sans-serif!important;}[dir="rtl"]{font-family:"' . e($fontFamily) . '",sans-serif!important;}</style>';
                },
            )
            ->renderHook(
                PanelsRenderHook::BODY_START,
                function (): string {
                    if (auth()->check() && auth()->user()->isDemo()) {
                        $badge = '<div style="position:fixed;top:4px;left:50%;transform:translateX(-50%);z-index:99999;display:flex;align-items:center;gap:6px;background:rgba(245,158,11,0.15);backdrop-filter:blur(12px);border:1px solid rgba(245,158,11,0.25);color:#d97706;border-radius:9999px;padding:5px 16px;font-size:13px;font-weight:600;box-shadow:0 2px 8px rgba(0,0,0,0.08);white-space:nowrap;"><svg style="width:14px;height:14px;flex-shrink:0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg><span>' . 'حالت نمایشی (دمو)' . '</span></div>';
                        $script = '<script>'
                            . 'window.showDemoToast=function(msg){'
                            . 'var t=document.createElement("div");'
                            . 't.style.cssText="position:fixed;bottom:80px;left:50%;transform:translateX(-50%);z-index:999999;background:rgba(225,29,72,0.95);color:#fff;padding:12px 24px;border-radius:12px;font-size:14px;font-weight:600;box-shadow:0 4px 16px rgba(0,0,0,0.2);backdrop-filter:blur(8px);animation:fadeInUp .3s ease;white-space:nowrap;";'
                            . 't.textContent=msg||"' . 'شما در حالت نمایشی (دمو) هستید و امکان ایجاد تغییرات را ندارید.' . '";'
                            . 'document.body.appendChild(t);'
                            . 'setTimeout(function(){t.style.opacity="0";t.style.transition="opacity .3s";setTimeout(function(){t.remove()},300)},4000);'
                            . '};'
                            . 'if(!document.getElementById("demo-toast-style")){'
                            . 'var s=document.createElement("style");s.id="demo-toast-style";'
                            . 's.textContent="@keyframes fadeInUp{from{opacity:0;transform:translateX(-50%) translateY(10px)}to{opacity:1;transform:translateX(-50%) translateY(0)}}";'
                            . 'document.head.appendChild(s);'
                            . '}'
                            . 'window.addEventListener("demo-blocked",function(e){'
                            . 'window.showDemoToast(e.detail?.message||e.detail?.params?.message);'
                            . '});'
                            . '</script>';
                        return Blade::render($badge . $script);
                    }
                    return '';
                },
            );
    }
}
