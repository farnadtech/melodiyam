<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // ── General ──
            ['key' => 'site_name',           'value' => 'ملودیام',              'group' => 'general',  'type' => 'text'],
            ['key' => 'site_name_en',         'value' => 'Melodiyam',            'group' => 'general',  'type' => 'text'],
            ['key' => 'site_description',     'value' => 'سرویس پخش آنلاین موسیقی فارسی', 'group' => 'general', 'type' => 'textarea'],
            ['key' => 'site_logo',            'value' => null,                   'group' => 'general',  'type' => 'image'],
            ['key' => 'site_favicon',         'value' => null,                   'group' => 'general',  'type' => 'image'],
            ['key' => 'site_email',           'value' => 'info@melodiyam.ir',    'group' => 'general',  'type' => 'text'],
            ['key' => 'site_phone',           'value' => '',                     'group' => 'general',  'type' => 'text'],
            ['key' => 'site_address',         'value' => '',                     'group' => 'general',  'type' => 'textarea'],
            ['key' => 'maintenance_mode',     'value' => '0',                    'group' => 'general',  'type' => 'boolean'],
            ['key' => 'maintenance_message',  'value' => 'سایت در حال به‌روزرسانی است.', 'group' => 'general', 'type' => 'textarea'],

            // ── Registration & Auth ──
            ['key' => 'allow_registration',   'value' => '1',                    'group' => 'auth',     'type' => 'boolean'],
            ['key' => 'email_verification',   'value' => '0',                    'group' => 'auth',     'type' => 'boolean'],
            ['key' => 'phone_verification',   'value' => '0',                    'group' => 'auth',     'type' => 'boolean'],
            ['key' => 'allow_artist_register','value' => '1',                    'group' => 'auth',     'type' => 'boolean'],
            ['key' => 'auto_approve_artist',  'value' => '0',                    'group' => 'auth',     'type' => 'boolean'],

            // ── Music & Content ──
            ['key' => 'free_stream_limit',    'value' => '0',                    'group' => 'content',  'type' => 'number'],
            ['key' => 'allow_download_free',  'value' => '0',                    'group' => 'content',  'type' => 'boolean'],
            ['key' => 'allow_download_premium','value' => '1',                   'group' => 'content',  'type' => 'boolean'],
            ['key' => 'max_upload_size_mb',   'value' => '50',                   'group' => 'content',  'type' => 'number'],
            ['key' => 'featured_tracks_count','value' => '10',                   'group' => 'content',  'type' => 'number'],
            ['key' => 'home_new_releases',    'value' => '20',                   'group' => 'content',  'type' => 'number'],

            // ── Premium & Subscription ──
            ['key' => 'premium_enabled',      'value' => '1',                    'group' => 'premium',  'type' => 'boolean'],
            ['key' => 'trial_days',           'value' => '0',                    'group' => 'premium',  'type' => 'number'],
            ['key' => 'currency',             'value' => 'تومان',                'group' => 'premium',  'type' => 'text'],
            ['key' => 'payment_gateway',      'value' => 'zarinpal',             'group' => 'premium',  'type' => 'select'],
            ['key' => 'zarinpal_merchant',    'value' => '',                     'group' => 'premium',  'type' => 'text'],
            ['key' => 'idpay_api_key',        'value' => '',                     'group' => 'premium',  'type' => 'text'],

            // ── Social Links ──
            ['key' => 'social_instagram',     'value' => '',                     'group' => 'social',   'type' => 'text'],
            ['key' => 'social_telegram',      'value' => '',                     'group' => 'social',   'type' => 'text'],
            ['key' => 'social_twitter',       'value' => '',                     'group' => 'social',   'type' => 'text'],
            ['key' => 'social_youtube',       'value' => '',                     'group' => 'social',   'type' => 'text'],
            ['key' => 'social_aparat',        'value' => '',                     'group' => 'social',   'type' => 'text'],

            // ── SEO ──
            ['key' => 'meta_title',           'value' => 'ملودیام - موسیقی آنلاین', 'group' => 'seo',  'type' => 'text'],
            ['key' => 'meta_description',     'value' => 'گوش دادن به موسیقی فارسی به صورت آنلاین', 'group' => 'seo', 'type' => 'textarea'],
            ['key' => 'meta_keywords',        'value' => 'موسیقی,آنلاین,فارسی',  'group' => 'seo',    'type' => 'text'],
            ['key' => 'google_analytics',     'value' => '',                     'group' => 'seo',      'type' => 'text'],

            // ── Notifications ──
            ['key' => 'notify_new_track',     'value' => '1',                    'group' => 'notify',   'type' => 'boolean'],
            ['key' => 'notify_new_user',      'value' => '1',                    'group' => 'notify',   'type' => 'boolean'],
            ['key' => 'admin_email_notify',   'value' => '1',                    'group' => 'notify',   'type' => 'boolean'],
            ['key' => 'smtp_host',            'value' => '',                     'group' => 'notify',   'type' => 'text'],
            ['key' => 'smtp_port',            'value' => '587',                  'group' => 'notify',   'type' => 'number'],
            ['key' => 'smtp_username',        'value' => '',                     'group' => 'notify',   'type' => 'text'],
            ['key' => 'smtp_password',        'value' => '',                     'group' => 'notify',   'type' => 'text'],
            ['key' => 'mail_from_name',       'value' => 'ملودیام',              'group' => 'notify',   'type' => 'text'],
            ['key' => 'mail_from_address',    'value' => 'noreply@melodiyam.ir', 'group' => 'notify',   'type' => 'text'],

            // ── Storage ──
            ['key' => 'storage_driver',       'value' => 'local',                'group' => 'storage',  'type' => 'select'],
            ['key' => 's3_key',               'value' => '',                     'group' => 'storage',  'type' => 'text'],
            ['key' => 's3_secret',            'value' => '',                     'group' => 'storage',  'type' => 'text'],
            ['key' => 's3_region',            'value' => '',                     'group' => 'storage',  'type' => 'text'],
            ['key' => 's3_bucket',            'value' => '',                     'group' => 'storage',  'type' => 'text'],
        ];

        foreach ($settings as $s) {
            Setting::updateOrCreate(['key' => $s['key']], $s);
        }
    }
}
