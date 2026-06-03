<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    protected $fillable = [
        'event_key', 'event_label', 'recipient_type', 'database_template',
        'via_database', 'via_sms', 'via_email',
        'sms_pattern_id', 'sms_var_names', 'sms_template',
        'email_subject', 'email_body',
    ];

    protected $casts = [
        'via_database'  => 'boolean',
        'via_sms'       => 'boolean',
        'via_email'     => 'boolean',
        'sms_var_names' => 'array',
    ];

    /**
     * تعریف رویدادهای نوتیفیکیشن سیستم
     */
    public static function getEvents(): array
    {
        return [
            // برای کاربران عادی
            'track_liked' => [
                'label'          => 'لایک شدن آهنگ (صاحب اثر)',
                'recipient_type' => 'artist',
                'sms_vars'       => ['track_title' => 'نام آهنگ', 'user_name' => 'نام کاربر'],
                'default_sms'    => 'هنرمند گرامی، آهنگ {track_title} توسط {user_name} لایک شد.',
            ],
            'track_reposted' => [
                'label'          => 'بازنشر آهنگ (صاحب اثر)',
                'recipient_type' => 'artist',
                'sms_vars'       => ['track_title' => 'نام آهنگ', 'user_name' => 'نام کاربر'],
                'default_sms'    => 'هنرمند گرامی، آهنگ {track_title} توسط {user_name} بازنشر شد.',
            ],
            'user_followed' => [
                'label'          => 'دنبال شدن (کاربر)',
                'recipient_type' => 'user',
                'sms_vars'       => ['follower_name' => 'نام دنبال‌کننده'],
                'default_sms'    => 'کاربر گرامی، {follower_name} شما را دنبال کرد.',
            ],
            'new_content_follower' => [
                'label'          => 'محتوای جدید از دنبال‌شوندگان (دنبال‌کننده)',
                'recipient_type' => 'user',
                'sms_vars'       => ['artist_name' => 'نام هنرمند', 'content_title' => 'عنوان محتوا'],
                'default_sms'    => 'محتوای جدید: {artist_name} آهنگ جدید "{content_title}" را منتشر کرد.',
            ],
            'track_purchased_artist' => [
                'label'          => 'فروش آهنگ (هنرمند)',
                'recipient_type' => 'artist',
                'sms_vars'       => ['track_title' => 'نام آهنگ', 'amount' => 'مبلغ'],
                'default_sms'    => 'هنرمند گرامی، آهنگ {track_title} به مبلغ {amount} فروخته شد.',
            ],
            // برای ادمین
            'new_artist_application' => [
                'label'          => 'درخواست هنرمند جدید (ادمین)',
                'recipient_type' => 'admin',
                'sms_vars'       => ['user_name' => 'نام کاربر'],
                'default_sms'    => 'ادمین گرامی، درخواست جدید هنرمندی از طرف {user_name} ثبت شد.',
            ],
            'new_report' => [
                'label'          => 'گزارش جدید (ادمین)',
                'recipient_type' => 'admin',
                'sms_vars'       => ['type' => 'نوع گزارش'],
                'default_sms'    => 'گزارش جدیدی با موضوع {type} ثبت شد.',
            ],
            'subscription_purchased' => [
                'label'          => 'خرید اشتراک (ادمین)',
                'recipient_type' => 'admin',
                'sms_vars'       => ['user_name' => 'نام کاربر', 'plan_name' => 'نام پلن', 'amount' => 'مبلغ'],
                'default_sms'    => 'ادمین گرامی، کاربر {user_name} اشتراک {plan_name} را به مبلغ {amount} تومان خرید.',
            ],
            'withdrawal_requested' => [
                'label'          => 'درخواست برداشت (ادمین)',
                'recipient_type' => 'admin',
                'sms_vars'       => ['user_name' => 'نام کاربر', 'amount' => 'مبلغ'],
                'default_sms'    => 'ادمین گرامی، کاربر {user_name} درخواست برداشت {amount} تومان ثبت کرد.',
            ],
            // احراز هویت
            'otp_code' => [
                'label'          => 'ارسال کد تایید (OTP)',
                'recipient_type' => 'user',
                'sms_vars'       => ['code' => 'کد تایید'],
                'default_sms'    => 'کد تایید شما: {code}',
            ],
            'password_recovery' => [
                'label'          => 'بازیابی رمز عبور',
                'recipient_type' => 'user',
                'sms_vars'       => ['code' => 'کد تایید'],
                'default_sms'    => 'کد بازیابی رمز عبور شما: {code}',
            ],
        ];
    }
}
