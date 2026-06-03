<?php

namespace App\Filament\Pages;

use App\Models\NotificationSetting;
use Filament\Actions\Action;
use App\Models\Setting;
use Filament\Schemas\Components\Actions as SchemaActions;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Placeholder;
use Illuminate\Support\HtmlString;

class NotificationSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-bell';
    protected static string | \UnitEnum | null $navigationGroup = 'تنظیمات سیستم';
    protected static ?string $title = 'تنظیمات نوتیفیکیشن';
    protected static ?string $navigationLabel = 'نوتیفیکیشن‌ها';
    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.notification-settings';

    public $data = [];

    public function mount()
    {
        $events = NotificationSetting::getEvents();
        $settings = NotificationSetting::all()->keyBy('event_key');
        $formData = [];

        foreach ($events as $key => $event) {
            $setting = $settings->get($key);
            $formData[$key] = [
                'via_database' => $setting->via_database ?? true,
                'database_template' => $setting->database_template ?? ($event['default_sms'] ?? ''),
                'via_sms' => $setting->via_sms ?? false,
                'via_email' => $setting->via_email ?? false,
                'sms_pattern_id' => $setting->sms_pattern_id ?? '',
                'sms_var_names' => $setting->sms_var_names ?? [],
                'sms_template' => $setting->sms_template ?? ($event['default_sms'] ?? ''),
                'email_subject' => $setting->email_subject ?? $event['label'],
                'email_body' => $setting->email_body ?? '',
            ];
        }

        $this->form->fill([
            'notifications' => $formData,
            'admin_mobile' => Setting::get('admin_notification_mobile', ''),
            'admin_email' => Setting::get('admin_notification_email', ''),
        ]);
    }

    public function form(Schema $form): Schema
    {
        $events = NotificationSetting::getEvents();
        $sections = [];

        // --- Admin Contact Section ---
        $sections[] = Section::make('اطلاعات تماس ادمین')
            ->description('این شماره و ایمیل برای دریافت پیامک‌ها و ایمیل‌های تست و همچنین تمام اعلان‌های سیستمی مدیر استفاده می‌شود.')
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('admin_mobile')
                        ->label('شماره موبایل مدیر')
                        ->placeholder('09120000000')
                        ->required(),
                    TextInput::make('admin_email')
                        ->label('ایمیل مدیر')
                        ->placeholder('admin@site.com')
                        ->email()
                        ->required(),
                ]),
            ])->columns(1);

        $activeSms = \App\Models\SmsProvider::where('is_active', true)->first();
        $smsDriver = $activeSms?->driver ?? 'melipayamak';

        foreach ($events as $key => $event) {
            $sections[] = Section::make($event['label'])
                ->description($event['recipient_type'] === 'admin' ? 'گیرنده: مدیر' : ($event['recipient_type'] === 'artist' ? 'گیرنده: هنرمند' : 'گیرنده: کاربر'))
                ->schema([
                    Tabs::make('channels')
                        ->tabs([
                            // --- Tab: In-Site ---
                            Tab::make('داخل سایت')
                                ->icon('heroicon-m-bell')
                                ->schema([
                                    Toggle::make("notifications.{$key}.via_database")
                                        ->label('فعال‌سازی اعلان در سایت')
                                        ->live(),
                                    TextInput::make("notifications.{$key}.database_template")
                                        ->label('متن نمایشی در پنل')
                                        ->placeholder('مثال: {user_name} آهنگ {track_title} را لایک کرد.')
                                        ->visible(fn($get) => $get("notifications.{$key}.via_database")),
                                ]),

                            // --- Tab: SMS ---
                            Tab::make('پیامک')
                                ->icon('heroicon-m-chat-bubble-left-right')
                                ->schema([
                                    Toggle::make("notifications.{$key}.via_sms")
                                        ->label('فعال‌سازی ارسال پیامک')
                                        ->live(),
                                    
                                    Grid::make(2)->schema([
                                        TextInput::make("notifications.{$key}.sms_pattern_id")
                                            ->label('کد الگو (Pattern ID)')
                                            ->required()
                                            ->placeholder('مثلاً 12345'),
                                        SchemaActions::make([
                                            Action::make("test_sms_{$key}")
                                                ->label('تست پترن')
                                                ->icon('heroicon-m-paper-airplane')
                                                ->color('primary')
                                                ->form([
                                                    TextInput::make('phone')
                                                        ->label('شماره موبایل')
                                                        ->required()
                                                        ->default(fn() => $this->data['admin_mobile'] ?? auth()->user()->phone),
                                                ])
                                                ->action(fn(array $data) => $this->testEventNotification($key, 'sms', $data)),
                                        ])->alignEnd(),
                                    ])->visible(fn($get) => $get("notifications.{$key}.via_sms")),

                                    // --- Variable Name Mapping ---
                                    Grid::make(count($event['sms_vars']))->schema(
                                        collect($event['sms_vars'])->map(fn($label, $vkey) =>
                                            TextInput::make("notifications.{$key}.sms_var_names.{$vkey}")
                                                ->label("نام متغیر «{$label}» در پنل پیامک")
                                                ->placeholder($vkey)
                                                ->helperText("مقدار پیش‌فرض: {$vkey}")
                                        )->values()->all()
                                    )->visible(fn($get) => $get("notifications.{$key}.via_sms")),

                                    Placeholder::make("guide_{$key}")
                                        ->label('راهنمای تنظیم پترن در پنل مخابراتی')
                                        ->content(function() use ($event, $smsDriver) {
                                            $vars = collect($event['sms_vars']);
                                            
                                            // Generate Sample Text for Panel
                                            $sampleText = $event['default_sms'] ?? '';
                                            $index = 0;
                                            foreach ($event['sms_vars'] as $vkey => $vlabel) {
                                                if ($smsDriver === 'melipayamak') {
                                                    $sampleText = str_replace('{' . $vkey . '}', "{" . $index . "}", $sampleText);
                                                    $index++;
                                                } else {
                                                    $sampleText = str_replace('{' . $vkey . '}', "#{$vkey}#", $sampleText);
                                                }
                                            }

                                            $samplePattern = $smsDriver === 'melipayamak' 
                                                ? $vars->keys()->map(fn($k, $i) => "{" . $i . "}")->implode(';')
                                                : $vars->keys()->map(fn($k) => "#{$k}#")->implode(', ');

                                            $rows = $vars->values()->map(function($label, $i) use ($vars, $smsDriver) {
                                                $vkey = $vars->keys()[$i];
                                                $v = $smsDriver === 'smsir' ? "#{$vkey}#" : "{" . $i . "}";
                                                return "
                                                    <tr class='border-b border-gray-100 dark:border-gray-800 last:border-0'>
                                                        <td class='py-2 font-mono font-bold text-primary-600 dark:text-primary-400 text-sm'>{$v}</td>
                                                        <td class='py-2 text-gray-600 dark:text-gray-400 text-sm'>{$label}</td>
                                                    </tr>";
                                            })->implode('');

                                            $providerName = $smsDriver === 'melipayamak' ? 'ملی‌پیامک' : 'Sms.ir';

                                            return new HtmlString("
                                                <div class='mt-4 space-y-6'>
                                                    <div class='p-4 bg-primary-50 dark:bg-primary-900/10 rounded-xl border border-primary-100 dark:border-primary-800 shadow-sm'>
                                                        <p class='text-xs font-black uppercase tracking-wider text-primary-700 dark:text-primary-300 mb-2'>
                                                            نمونه متن برای تعریف در پنل {$providerName}:
                                                        </p>
                                                        <div class='bg-white dark:bg-gray-950 p-3 rounded border border-primary-200 dark:border-primary-700 text-sm leading-relaxed text-gray-800 dark:text-gray-200'>
                                                            {$sampleText}
                                                        </div>
                                                        <p class='mt-2 text-[10px] text-primary-600/70 dark:text-primary-400/70'>
                                                            * متن بالا را در پنل مخابراتی خود به عنوان قالب پیامک تعریف کنید.
                                                        </p>
                                                    </div>

                                                    <div class='p-3 bg-gray-50 dark:bg-gray-900 rounded-lg border border-dashed border-gray-300 dark:border-gray-700'>
                                                        <p class='text-xs font-bold mb-1 text-gray-500'>پترن پیشنهادی برای کد الگو:</p>
                                                        <code class='text-sm text-primary-600 dark:text-primary-400'>{$samplePattern}</code>
                                                    </div>

                                                    <div class='overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700'>
                                                        <table class='w-full text-right bg-gray-50/50 dark:bg-gray-900/50'>
                                                            <thead>
                                                                <tr class='bg-gray-100 dark:bg-gray-800'>
                                                                    <th class='p-3 text-xs font-bold text-gray-500'>متغیر در پنل</th>
                                                                    <th class='p-3 text-xs font-bold text-gray-500'>محتوای ارسالی</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class='divide-y divide-gray-100 dark:divide-gray-800'>
                                                                {$rows}
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            ");
                                        })
                                        ->visible(fn($get) => $get("notifications.{$key}.via_sms")),
                                ]),

                            // --- Tab: Email ---
                            Tab::make('ایمیل')
                                ->icon('heroicon-m-envelope')
                                ->schema([
                                    Toggle::make("notifications.{$key}.via_email")
                                        ->label('فعال‌سازی ارسال ایمیل')
                                        ->live(),
                                    
                                    Grid::make(1)->schema([
                                        TextInput::make("notifications.{$key}.email_subject")->label('موضوع ایمیل'),
                                        Textarea::make("notifications.{$key}.email_body")->label('متن ایمیل')->rows(3),
                                        SchemaActions::make([
                                            Action::make("test_email_{$key}")
                                                ->label('تست ایمیل')
                                                ->icon('heroicon-m-paper-airplane')
                                                ->color('secondary')
                                                ->form([
                                                    TextInput::make('email')
                                                        ->label('آدرس ایمیل')
                                                        ->email()
                                                        ->required()
                                                        ->default(fn() => $this->data['admin_email'] ?? auth()->user()->email),
                                                ])
                                                ->action(fn(array $data) => $this->testEventNotification($key, 'email', $data)),
                                        ])->alignEnd(),
                                    ])->visible(fn($get) => $get("notifications.{$key}.via_email")),
                                ]),
                        ])
                        ->persistTabInQueryString()
                ])->collapsible();
        }

        return $form
            ->statePath('data')
            ->schema($sections);
    }

    public function save()
    {
        $formData = $this->form->getState();
        $notifications = $formData['notifications'] ?? [];

        // Save Admin Contacts
        Setting::set('admin_notification_mobile', $formData['admin_mobile'] ?? '');
        Setting::set('admin_notification_email', $formData['admin_email'] ?? '');

        foreach ($notifications as $key => $notificationData) {
            NotificationSetting::updateOrCreate(
                ['event_key' => $key],
                array_merge($notificationData, [
                    'event_label' => NotificationSetting::getEvents()[$key]['label'] ?? $key,
                    'recipient_type' => NotificationSetting::getEvents()[$key]['recipient_type'] ?? 'user',
                ])
            );
        }

        Notification::make()
            ->title('تنظیمات اعلان‌ها با موفقیت ذخیره شد')
            ->success()
            ->send();
    }

    public function testEventNotification(string $eventKey, string $type, array $data)
    {
        $events = NotificationSetting::getEvents();
        $event = $events[$eventKey] ?? null;
        if (!$event) return;

        // Create dummy params
        $params = [];
        foreach ($event['sms_vars'] as $vkey => $label) {
            $params[$vkey] = "تست " . $label;
        }

        $formData = $this->data['notifications'][$eventKey] ?? [];
        
        try {
            if ($type === 'sms') {
                $smsService = new \App\Services\SmsService();
                $phone = $data['phone'];
                $patternId = $formData['sms_pattern_id'] ?? null;
                
                if (!$patternId) {
                    Notification::make()->title('کد الگو وارد نشده است')->danger()->send();
                    return;
                }

                // Apply variable name mapping
                $varNames = $formData['sms_var_names'] ?? [];
                $mappedParams = [];
                foreach ($params as $key => $value) {
                    $providerKey = !empty($varNames[$key]) ? $varNames[$key] : $key;
                    $mappedParams[$providerKey] = $value;
                }

                $res = $smsService->sendByPattern($phone, $patternId, $mappedParams);

                if ($res['success']) {
                    Notification::make()->title('پیامک پترن با موفقیت ارسال شد')->success()->send();
                } else {
                    Notification::make()->title('خطا در ارسال پترن')->body($res['message'])->danger()->send();
                }
            } else {
                $email = $data['email'];
                $subject = $formData['email_subject'] ?? 'تست';
                $body = $formData['email_body'] ?? 'این یک متن تست است.';
                foreach ($params as $k => $v) { 
                    $subject = str_replace("{{$k}}", $v, $subject);
                    $body = str_replace("{{$k}}", $v, $body);
                }

                \Illuminate\Support\Facades\Mail::to($email)->send(new \App\Mail\NotificationMail($subject, $body));

                Notification::make()->title('ایمیل تست با موفقیت ارسال شد')->success()->send();
            }
        } catch (\Exception $e) {
            Notification::make()->title('خطای سیستم')->body($e->getMessage())->danger()->send();
        }
    }
}
