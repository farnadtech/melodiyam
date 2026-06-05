<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'group', 'type'];

    public static function defaults(): array
    {
        return [
            // General
            'site_name' => config('app.name', 'Melodiyam'),
            'site_name_en' => 'Melodiyam',
            'show_site_name_in_sidebar' => '1',
            'logo_height_px' => '40',
            'maintenance_mode' => '0',
            
            // Auth
            'auth_type' => 'password',
            'allow_registration' => '1',
            'email_verification' => '0',
            'phone_verification' => '0',
            'allow_artist_register' => '1',
            'auto_approve_artist' => '0',
            'artist_subscription_required' => '0',
            
            // Content
            'user_upload_enabled' => '0',
            'free_stream_limit' => '0',
            'allow_download_free' => '0',
            'allow_download_premium' => '1',
            'premium_preview_seconds' => '30',
            'auto_approve_content' => '0',
            'max_upload_size_mb' => '100',
            'featured_tracks_count' => '10',
            'home_new_releases' => '12',
            'smart_playlist_templates' => '[]',
            
            // Payment
            'premium_enabled' => '1',
            'currency' => 'تومان',
            'deposit_min_amount' => '10000',
            'deposit_max_amount' => '50000000',
            'withdraw_min_amount' => '10000',
            'withdraw_max_amount' => '10000000',
            'transaction_tax_percent' => '0',
            'withdraw_fee_amount' => '0',
            'wallet_enabled' => '1',
            'card2card_enabled' => '1',
            
            // Theme
            'theme_primary' => '#0ea5e9',
            'theme_secondary' => '#8b5cf6',
            'theme_accent' => '#d946ef',
            'theme_danger' => '#ef4444',
            'theme_success' => '#10b981',
            'theme_warning' => '#f59e0b',
            'theme_bg_light' => '#f8fafc',
            'theme_bg_dark' => '#020617',
            'theme_surface_light' => '#ffffff',
            'theme_surface_dark' => '#0f172a',
            'theme_gradient_from' => '#0ea5e9',
            'theme_gradient_to' => '#d946ef',
            'theme_player_bg' => '#1a1a2e',
            'theme_player_text' => '#ffffff',
            'theme_player_control' => '#0ea5e9',
            'theme_sidebar_bg_light' => '#ffffff',
            'theme_sidebar_bg_dark' => '#0f172a',
            'theme_sidebar_text' => '#64748b',
            'theme_sidebar_active_bg' => '#0ea5e9',
            'theme_sidebar_active_text' => '#ffffff',
            'theme_sidebar_border' => '#e2e8f0',
            'theme_header_bg_light' => '#ffffff',
            'theme_header_bg_dark' => '#0f172a',
            'theme_header_border' => '#e2e8f0',
            'theme_font_fa' => 'Vazirmatn',
            'theme_font_en' => 'Inter',
            'theme_radius' => 'md',

            // Sidebar Footer
            'sidebar_footer_enabled' => '1',

            // Storage
            'storage_driver' => 'local',
            'ftp_host' => '',
            'ftp_port' => '21',
            'ftp_username' => '',
            'ftp_password' => '',
            'ftp_root' => '/',
            'ftp_url' => '',

            // SMTP
            'smtp_host' => '',
            'smtp_port' => '587',
            'smtp_encryption' => 'tls',
            'smtp_username' => '',
            'smtp_password' => '',
            'mail_from_name' => 'Melodiyam',
            'mail_from_address' => 'noreply@melodiyam.ir',
            'email_header_color' => '#6366f1',
            'email_footer_text' => '',
            // Payment gateways
            'zibal_merchant'   => '',
            'payping_token'    => '',

            // PWA
            'pwa_enabled' => '1',
            'pwa_name' => config('app.name', 'Melodiyam'),
            'pwa_short_name' => config('app.name', 'Melodiyam'),
            'pwa_theme_color' => '#0ea5e9',
            'pwa_bg_color' => '#020617',
            'pwa_display' => 'standalone',
            'pwa_icon' => '',
        ];
    }

    public static function get(string $key, $default = null)
    {
        if ($default === null) {
            $defaults = static::defaults();
            $default = $defaults[$key] ?? null;
        }

        return Cache::rememberForever("setting.{$key}", function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Auto-detect group from key prefix.
     */
    protected static function detectGroup(string $key): string
    {
        $prefixMap = [
            'theme_'  => 'theme',
            'pwa_'    => 'pwa',
            'smtp_'   => 'smtp',
            'mail_'   => 'smtp',
            'ftp_'    => 'storage',
            'storage_'=> 'storage',
            'auth_'   => 'auth',
            'allow_'  => 'auth',
            'email_'  => 'smtp',
            'zibal_'  => 'payment',
            'payping_'=> 'payment',
            'premium_'=> 'payment',
            'deposit_'=> 'payment',
            'withdraw_'=> 'payment',
            'transaction_'=> 'payment',
            'wallet_' => 'payment',
            'card2card_'=> 'payment',
            'currency'=> 'payment',
            'sidebar_footer_'=> 'general',
            'site_'   => 'general',
            'show_'   => 'general',
            'logo_'   => 'general',
            'meta_'   => 'seo',
            'google_' => 'seo',
            'social_' => 'seo',
            'maintenance_'=> 'general',
            'user_upload_'=> 'content',
            'free_stream_'=> 'content',
            'auto_approve_'=> 'content',
            'max_upload_'=> 'content',
            'featured_'=> 'content',
            'home_'   => 'content',
            'artist_' => 'auth',
        ];

        foreach ($prefixMap as $prefix => $group) {
            if (str_starts_with($key, $prefix)) {
                return $group;
            }
        }

        return 'general';
    }

    public static function set(string $key, $value): void
    {
        $group = static::detectGroup($key);

        if (is_array($value)) {
            $value = json_encode($value, JSON_UNESCAPED_UNICODE);
        }

        static::updateOrCreate(['key' => $key], ['value' => $value, 'group' => $group]);
        Cache::forget("setting.{$key}");
        Cache::forget('settings_all');
        Cache::forget("settings_group.{$group}");
    }

    public static function getAll(): array
    {
        return \Illuminate\Support\Facades\Cache::rememberForever('settings_all', function () {
            return static::pluck('value', 'key')->toArray();
        });
    }

    public static function getByGroup(string $group): array
    {
        return Cache::rememberForever("settings_group.{$group}", function () use ($group) {
            return static::where('group', $group)->pluck('value', 'key')->toArray();
        });
    }
}
