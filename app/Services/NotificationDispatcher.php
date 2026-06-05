<?php

namespace App\Services;

use App\Models\NotificationSetting;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Notifications\SystemNotification;

class NotificationDispatcher
{
    public static function dispatch(string $eventKey, array $params = [], $recipient = null)
    {
        $setting = NotificationSetting::where('event_key', $eventKey)->first();
        if (!$setting) return;

        // Special handling for Admin notifications if global admin contact is set
        if ($setting->recipient_type === 'admin' && !$recipient) {
            $adminMobile = \App\Models\Setting::get('admin_notification_mobile');
            $adminEmail = \App\Models\Setting::get('admin_notification_email');

            if ($adminMobile || $adminEmail) {
                // Create a virtual user-like object to satisfy the loop below
                $virtualAdmin = new \stdClass();
                $virtualAdmin->phone = $adminMobile;
                $virtualAdmin->email = $adminEmail;
                // Virtual admins don't get database notifications as they aren't real Users
                $virtualAdmin->notify = function() {}; 
                
                $recipients = [$virtualAdmin];
            } else {
                $recipients = self::resolveRecipients($setting, $recipient);
            }
        } else {
            $recipients = self::resolveRecipients($setting, $recipient);
        }

        if (empty($recipients)) return;

        foreach ($recipients as $user) {
            // 1. Database Notification
            if ($setting->via_database && isset($user->id) && method_exists($user, 'notify')) {
                $message = self::formatMessage($setting->database_template ?: ($setting->sms_template ?: $setting->event_label), $params);
                $user->notify(new SystemNotification($eventKey, $message, $params));
            }

            // 2. SMS Notification
            $phone = $user->phone ?? null;
            if ($setting->via_sms && $phone) {
                $smsService = new SmsService();
                if ($setting->sms_pattern_id) {
                    // Map internal param names to SMS provider variable names
                    $mappedParams = $params;
                    if ($setting->sms_var_names) {
                        $mappedParams = [];
                        foreach ($params as $key => $value) {
                            $providerKey = $setting->sms_var_names[$key] ?? $key;
                            $mappedParams[$providerKey] = $value;
                        }
                    }
                    $smsService->sendByPattern($phone, $setting->sms_pattern_id, $mappedParams);
                } else {
                    $message = self::formatMessage($setting->sms_template, $params);
                    $smsService->sendText($phone, $message);
                }
            }

            // 3. Email Notification
            $email = $user->email ?? null;
            if ($setting->via_email && $email) {
                $subject = self::formatMessage($setting->email_subject, $params);
                $body = self::formatMessage($setting->email_body, $params);
                
                Mail::to($email)->send(new \App\Mail\NotificationMail($subject, $body));
            }
        }
    }

    protected static function resolveRecipients($setting, $providedRecipient)
    {
        if ($providedRecipient) {
            return is_array($providedRecipient) || $providedRecipient instanceof \Illuminate\Support\Collection 
                ? $providedRecipient 
                : [$providedRecipient];
        }

        return match ($setting->recipient_type) {
            'admin' => User::where('type', 'admin')->get(),
            default => [],
        };
    }

    protected static function formatMessage($template, $params)
    {
        if (!$template) return '';
        
        foreach ($params as $key => $value) {
            $template = str_replace('{' . $key . '}', $value, $template);
        }
        
        return $template;
    }
}
