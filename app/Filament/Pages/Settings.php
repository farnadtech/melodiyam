<?php

namespace App\Filament\Pages;

use App\Models\EarningsSetting;
use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Schemas\Components\Actions as SchemaActions;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Support\Facades\Cache;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static string | \UnitEnum | null $navigationGroup = 'تنظیمات سیستم';
    protected static ?string $title = 'تنظیمات سایت';
    protected static ?string $navigationLabel = 'تنظیمات عمومی';
    protected static ?int $navigationSort = 1;

    public array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->getSettingsForForm());
    }

    protected function getSettingsForForm(): array
    {
        $dbSettings = Setting::pluck('value', 'key')->toArray();
        $defaults = Setting::defaults();
        
        // Merge defaults with database values
        $settings = array_merge($defaults, $dbSettings);

        // Handle JSON values
        foreach ($settings as $key => $value) {
            if (is_string($value) && (str_starts_with($value, '[') || str_starts_with($value, '{'))) {
                $decoded = json_decode($value, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $settings[$key] = $decoded;
                }
            }
        }

        // Add earnings settings from separate table
        $earningsSettings = EarningsSetting::getSettings();
        $settings['earnings_enabled'] = $earningsSettings->is_enabled;
        $settings['earnings_plays_threshold'] = $earningsSettings->plays_threshold;
        $settings['earnings_amount_toman'] = $earningsSettings->earning_amount_toman;
        $settings['earnings_min_payout'] = $earningsSettings->min_payout_toman;
        $settings['earnings_payout_description'] = $earningsSettings->payout_description;

        // Load SMS Provider settings
        $activeSms = \App\Models\SmsProvider::where('is_active', true)->first();
        if ($activeSms) {
            $settings['sms_provider'] = $activeSms->driver;
        }
        
        $melipayamak = \App\Models\SmsProvider::where('driver', 'melipayamak')->first();
        if ($melipayamak) {
            $settings['melipayamak_username'] = $melipayamak->credentials['username'] ?? '';
            $settings['melipayamak_password'] = $melipayamak->credentials['password'] ?? '';
            $settings['melipayamak_from'] = $melipayamak->credentials['from'] ?? '';
            $settings['melipayamak_otp_pattern'] = $melipayamak->credentials['otp_pattern'] ?? '';
        }

        $smsir = \App\Models\SmsProvider::where('driver', 'smsir')->first();
        if ($smsir) {
            $settings['smsir_api_key'] = $smsir->credentials['api_key'] ?? '';
            $settings['smsir_line_number'] = $smsir->credentials['line_number'] ?? '';
            $settings['smsir_otp_pattern'] = $smsir->credentials['otp_pattern'] ?? '';
        }

        // Load payment gateway settings
        $settings['zibal_merchant'] = Setting::get('zibal_merchant', '');
        $settings['payping_token']  = Setting::get('payping_token', '');
        // active_gateways is JSON in settings — decode to array for CheckboxList
        $ag = Setting::get('active_gateways', '');
        $settings['active_gateways'] = $ag ? (is_array($ag) ? $ag : json_decode($ag, true)) : [];

        return $settings;
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->statePath('data')
            ->schema([
                Tabs::make('تنظیمات')->tabs([

                    // ── Tab 1: General ──
                    Tab::make('عمومی')->icon('heroicon-o-cog')->schema([
                        Section::make('اطلاعات سایت')->schema([
                            TextInput::make('site_name')->label('نام سایت (فارسی)')->required(),
                            TextInput::make('site_name_en')->label('نام سایت (انگلیسی)'),
                            Textarea::make('site_description')->label('توضیحات سایت')->rows(2),
                            TextInput::make('site_email')->label('ایمیل سایت')->email(),
                            TextInput::make('site_phone')->label('تلفن'),
                            Textarea::make('site_address')->label('آدرس')->rows(2),
                        ])->columns(2),

                        Section::make('لوگو و فاوآیکون')->schema([
                            FileUpload::make('site_logo')->label('لوگو سایت')
                                ->image()->directory('settings')->disk('public')->visibility('public'),
                            FileUpload::make('site_favicon')->label('فاوآیکون')
                                ->image()->directory('settings')->disk('public')->visibility('public'),
                            Toggle::make('show_site_name_in_sidebar')
                                ->label('نمایش نام سایت در کنار لوگو')
                                ->default(true),
                            TextInput::make('logo_height_px')
                                ->label('ارتفاع لوگو (پیکسل)')
                                ->numeric()
                                ->default(40)
                                ->suffix('px')
                                ->helperText('حداقل: ۲۰، حداکثر: ۱۵۰. برای حفظ ریسپانسیو، ارتفاع در موبایل محدود می‌شود.'),
                        ])->columns(2),

                        Section::make('سوالات متداول صفحه پریمیوم')->schema([
                            \Filament\Forms\Components\Repeater::make('premium_faqs')
                                ->label('سوالات متداول')
                                ->schema([
                                    TextInput::make('question')->label('سوال')->required(),
                                    Textarea::make('answer')->label('پاسخ')->required(),
                                ])
                                ->columns(1)
                                ->itemLabel(fn (array $state): ?string => $state['question'] ?? null)
                                ->collapsible(),
                        ]),

                        Section::make('تعمیر و نگهداری')->schema([
                            Toggle::make('maintenance_mode')->label('حالت تعمیر')->onColor('danger'),
                            Textarea::make('maintenance_message')->label('پیام تعمیر')->rows(2),
                        ])->columns(2),
                    ]),

                    // ── Tab 2: Auth & Registration ──
                    Tab::make('احراز هویت')->icon('heroicon-o-user-circle')->schema([
                        Section::make('روش احراز هویت')->schema([
                            Select::make('auth_type')
                                ->label('روش ورود و ثبت‌نام')
                                ->options([
                                    'password' => 'رمز عبور + ایمیل/موبایل',
                                    'otp' => 'کد OTP + موبایل',
                                    'both' => 'هر دو (رمز عبور یا OTP)',
                                ])
                                ->default('password')
                                ->helperText('انتخاب روش احراز هویت برای کاربران'),
                        ])->columns(1),
                        Section::make('تنظیمات ثبت‌نام')->schema([
                            Toggle::make('allow_registration')->label('ثبت‌نام آزاد'),
                            Toggle::make('email_verification')->label('تأیید ایمیل اجباری')->live(),
                            Toggle::make('phone_verification')->label('تأیید موبایل اجباری')->live(),
                            Toggle::make('allow_artist_register')->label('ثبت‌نام هنرمند'),
                            Toggle::make('auto_approve_artist')->label('تأیید خودکار هنرمند'),
                        ])->columns(3),

                        // Warning: verification ON but notification channel OFF
                        Section::make('⚠️ هشدار تنظیمات اعلانات')
                            ->schema([
                                Placeholder::make('verification_warning')
                                    ->label('')
                                    ->content(function ($get) {
                                        $otpNotif = \App\Models\NotificationSetting::where('event_key', 'otp_code')->first();
                                        $emailOn = (bool) $get('email_verification');
                                        $phoneOn = (bool) $get('phone_verification');
                                        $smsOff = $phoneOn && (!$otpNotif || !$otpNotif->via_sms);
                                        $emailOff = $emailOn && (!$otpNotif || !$otpNotif->via_email);

                                        $items = '';
                                        if ($smsOff) {
                                            $items .= '<li class="py-1"><strong>پیامک (SMS)</strong> برای رویداد «ارسال کد تایید (OTP)» غیرفعال است — تأیید موبایل بدون آن کار نمی‌کند.</li>';
                                        }
                                        if ($emailOff) {
                                            $items .= '<li class="py-1"><strong>ایمیل</strong> برای رویداد «ارسال کد تایید (OTP)» غیرفعال است — تأیید ایمیل بدون آن کار نمی‌کند.</li>';
                                        }

                                        $link = \App\Filament\Pages\NotificationSettings::getUrl();

                                        return new \Illuminate\Support\HtmlString('
                                            <div class="fi-fo-placeholder text-sm">
                                                <p class="mb-2 text-gray-700 dark:text-gray-300">
                                                    برای اینکه کاربران بتوانند حساب خود را تأیید کنند، باید کانال‌های ارسال کد OTP فعال باشند.
                                                    لطفاً کانال‌های زیر را فعال کنید:
                                                </p>
                                                <ul class="list-disc pr-5 mb-3 text-gray-600 dark:text-gray-400 space-y-1">' . $items . '</ul>
                                                <a href="' . e($link) . '" class="inline-flex items-center gap-1 text-sm font-medium text-primary-600 dark:text-primary-400 hover:underline">
                                                    ⚙️ رفتن به تنظیمات نوتیفیکیشن ←
                                                </a>
                                            </div>
                                        ');
                                    })
                                    ->columnSpanFull(),
                            ])
                            ->visible(function ($get) {
                                $emailOn = (bool) $get('email_verification');
                                $phoneOn = (bool) $get('phone_verification');
                                if (!$emailOn && !$phoneOn) return false;
                                $otpNotif = \App\Models\NotificationSetting::where('event_key', 'otp_code')->first();
                                if ($phoneOn && (!$otpNotif || !$otpNotif->via_sms)) return true;
                                if ($emailOn && (!$otpNotif || !$otpNotif->via_email)) return true;
                                return false;
                            }),
                    ]),

                    // ── Tab 3: Content & Music ──
                    Tab::make('محتوا')->icon('heroicon-o-musical-note')->schema([
                        Section::make('محدودیت‌های پخش')->schema([
                            TextInput::make('free_stream_limit')->label('سقف پخش رایگان (۰ = نامحدود)')->numeric(),
                            TextInput::make('premium_preview_seconds')
                                ->label('پیش‌نمایش محتوای پریمیوم (ثانیه)')
                                ->numeric()->default(30)->minValue(0)->suffix('ثانیه')
                                ->helperText('مدت پیش‌نمایش رایگان برای آهنگ‌ها و قسمت‌های پادکست پریمیوم. ۰ = بدون پیش‌نمایش'),
                        ])->columns(2),
                        Section::make('آپلود')->schema([
                            Toggle::make('user_upload_enabled')
                                ->label('فعال بودن سیستم آپلود کاربر')
                                ->helperText('در صورت فعال بودن، کاربران عادی با دسترسی لازم می‌توانند آهنگ آپلود کنند.')
                                ->default(false),
                            Toggle::make('auto_approve_content')
                                ->label('تأیید خودکار محتوای هنرمندان')
                                ->helperText('در صورت غیرفعال بودن، آهنگ‌ها، آلبوم‌ها و پادکست‌های هنرمندان باید توسط مدیر تایید شوند.')
                                ->default(false),
                            Toggle::make('auto_approve_user_content')
                                ->label('تأیید خودکار محتوای کاربران عادی')
                                ->helperText('در صورت غیرفعال بودن، آهنگ‌های آپلود شده توسط کاربران عادی باید توسط مدیر تایید شوند.')
                                ->default(true),
                            TextInput::make('max_upload_size_mb')->label('حداکثر حجم آپلود (MB)')->numeric(),
                        ])->columns(2),
                    ]),

                    // ── Tab 4: Premium & Payment ──
                    Tab::make('پرداخت')->icon('heroicon-o-credit-card')->schema([
                        Section::make('اشتراک')
                            ->description('روزهای آزمایشی هر پلن را از بخش «اشتراک ← طرح‌های اشتراک» تنظیم کنید.')
                            ->schema([
                                Toggle::make('premium_enabled')->label('فعال بودن پریمیوم'),
                                TextInput::make('currency')->label('واحد پول'),
                                Toggle::make('artist_subscription_required')
                                    ->label('اشتراک هنرمند اجباری')
                                    ->helperText('هنرمند بدون اشتراک فعال نمی‌تواند آهنگ یا آلبوم آپلود کند'),
                            ])->columns(3),
                        Section::make('درگاه پرداخت')->schema([
                            \Filament\Forms\Components\CheckboxList::make('active_gateways')
                                ->label('درگاه‌های پرداخت فعال')
                                ->options([
                                    'zarinpal' => 'زرین‌پال',
                                    'zibal'    => 'زیبال (Zibal)',
                                    'payping'  => 'پی‌پینگ (PayPing)',
                                ])
                                ->columns(3)
                                ->helperText('می‌توانید چند درگاه همزمان فعال کنید — کاربر در صفحه پرداخت انتخاب می‌کند')
                                ->columnSpanFull(),

                            // Zarinpal
                            TextInput::make('zarinpal_merchant')
                                ->label('Merchant ID زرین‌پال')
                                ->placeholder('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx')
                                ->columnSpanFull(),
                            Toggle::make('zarinpal_sandbox')
                                ->label('حالت آزمایشی (Sandbox) زرین‌پال'),

                            // Zibal
                            TextInput::make('zibal_merchant')
                                ->label('Merchant زیبال')
                                ->placeholder('zibal یا کد merchant شما')
                                ->helperText('برای تست از مقدار "zibal" استفاده کنید')
                                ->columnSpanFull(),

                            // PayPing
                            TextInput::make('payping_token')
                                ->label('Token پی‌پینگ')
                                ->password()->revealable()
                                ->helperText('توکن Bearer از پنل پی‌پینگ')
                                ->columnSpanFull(),
                        ])->columns(2),

                        Section::make('تنظیمات مالی')->schema([
                            TextInput::make('deposit_min_amount')
                                ->label('حداقل مبلغ شارژ (تومان)')
                                ->numeric()->default(10000),
                            TextInput::make('deposit_max_amount')
                                ->label('حداکثر مبلغ شارژ (تومان)')
                                ->numeric()->default(50000000),
                            TextInput::make('withdraw_min_amount')
                                ->label('حداقل مبلغ برداشت (تومان)')
                                ->numeric()->default(10000),
                            TextInput::make('withdraw_max_amount')
                                ->label('حداکثر مبلغ برداشت (تومان)')
                                ->numeric()->default(10000000),
                            TextInput::make('transaction_tax_percent')
                                ->label('درصد مالیات/کارمزد تراکنش')
                                ->numeric()->default(0)
                                ->suffix('%')
                                ->helperText('مثلاً ۹ برای ۹٪ — این مقدار به مبلغ نهایی اضافه می‌شود'),
                            TextInput::make('withdraw_fee_amount')
                                ->label('کارمزد ثابت برداشت (تومان)')
                                ->numeric()->default(0)
                                ->helperText('مبلغ ثابت از هر برداشت کسر می‌شود'),
                        ])->columns(3),

                        Section::make('کیف پول و کارت به کارت')->schema([
                            Toggle::make('wallet_enabled')->label('فعال بودن کیف پول')->default(true),
                            Toggle::make('card2card_enabled')->label('شارژ کارت به کارت')->default(true),
                            TextInput::make('bank_card_number')->label('شماره کارت بانکی (برای شارژ)')->placeholder('6037XXXXXXXXXXXXXXXX'),
                            TextInput::make('bank_card_owner')->label('نام صاحب کارت'),
                            TextInput::make('bank_name')->label('نام بانک'),
                        ])->columns(3),
                    ]),

                    // ── Tab 5: Social ──
                    Tab::make('شبکه‌های اجتماعی')->icon('heroicon-o-share')->schema([
                        Section::make()->schema([
                            TextInput::make('social_instagram')->label('اینستاگرام')->prefix('instagram.com/')->url(),
                            TextInput::make('social_telegram')->label('تلگرام')->prefix('t.me/'),
                            TextInput::make('social_twitter')->label('توییتر / X')->prefix('x.com/'),
                            TextInput::make('social_youtube')->label('یوتیوب')->url(),
                            TextInput::make('social_aparat')->label('آپارات')->url(),
                        ])->columns(2),
                    ]),

                    // ── Tab 6: SEO ──
                    Tab::make('سئو')->icon('heroicon-o-magnifying-glass')->schema([
                        Section::make()->schema([
                            TextInput::make('meta_title')->label('عنوان متا'),
                            Textarea::make('meta_description')->label('توضیحات متا')->rows(2),
                            TextInput::make('meta_keywords')->label('کلمات کلیدی'),
                            TextInput::make('google_analytics')->label('کد گوگل آنالیتیکس (G-XXXXX)'),
                        ])->columns(2),
                    ]),

                    // ── Tab 7: Email / Notifications ──
                    Tab::make('ایمیل و پیامک')->icon('heroicon-o-envelope')->schema([
                        Section::make('تنظیمات SMTP')->schema([
                            TextInput::make('smtp_host')->label('SMTP Host'),
                            TextInput::make('smtp_port')->label('SMTP Port')->numeric(),
                            Select::make('smtp_encryption')->label('نوع رمزنگاری')
                                ->options([
                                    'ssl' => 'SSL',
                                    'tls' => 'TLS',
                                    'none' => 'بدون رمزنگاری',
                                ]),
                            TextInput::make('smtp_username')->label('نام کاربری SMTP'),
                            TextInput::make('smtp_password')->label('رمز SMTP')->password()->revealable(),
                            TextInput::make('mail_from_name')->label('نام فرستنده'),
                            TextInput::make('mail_from_address')->label('ایمیل فرستنده')->email(),
                            
                            SchemaActions::make([
                                Action::make('test_smtp')
                                    ->label('ارسال ایمیل تست')
                                    ->color('info')
                                    ->icon('heroicon-o-paper-airplane')
                                    ->form([
                                        TextInput::make('test_recipient')
                                            ->label('ایمیل دریافت‌کننده')
                                            ->email()
                                            ->required()
                                             ->default(fn() => auth()->user()->email),
                                     ])
                                     ->action(fn (array $data) => $this->testSmtpConnection($data)),
                             ]),
                        ])->columns(3),

                        Section::make('قالب ایمیل‌های سیستمی')
                            ->description('تمام ایمیل‌های ارسالی از سیستم (اعلان‌ها، کدهای تایید و غیره) در این قالب ارسال می‌شوند.')
                            ->schema([
                                ColorPicker::make('email_header_color')
                                    ->label('رنگ هدر ایمیل')
                                    ->hexColor()
                                    ->default('#6366f1'),
                                TextInput::make('email_footer_text')
                                    ->label('متن فوتر ایمیل')
                                    ->placeholder('این ایمیل از طرف سایت ما ارسال شده است.')
                                    ->helperText('می‌توانید از HTML ساده استفاده کنید'),
                            ])->columns(2),

                        Section::make('درگاه‌های پیامک')->schema([
                            Select::make('sms_provider')
                                ->label('درگاه پیامک فعال')
                                ->options([
                                    'melipayamak' => 'ملی پیامک',
                                    'smsir' => 'Sms.ir',
                                ])
                                ->reactive()
                                ->default('melipayamak'),

                                Grid::make(2)->schema([
                                    TextInput::make('melipayamak_username')->label('نام کاربری ملی پیامک'),
                                    TextInput::make('melipayamak_password')->label('رمز عبور ملی پیامک')->password()->revealable(),
                                    TextInput::make('melipayamak_from')->label('خط فرستنده ملی پیامک'),
                                    TextInput::make('melipayamak_otp_pattern')->label('کد الگوی OTP (ملی پیامک)'),
                                ])->visible(fn($get) => $get('sms_provider') === 'melipayamak'),

                                SchemaActions::make([
                                     Action::make('test_pattern')
                                         ->label('تست ارسال پترن (OTP)')
                                         ->color('success')
                                         ->icon('heroicon-o-shield-check')
                                         ->form([
                                             TextInput::make('test_phone')
                                                 ->label('شماره موبایل تست')
                                                 ->required()
                                                 ->default(fn() => auth()->user()->phone),
                                             TextInput::make('test_code')
                                                 ->label('کد تایید تست')
                                                 ->required()
                                                 ->default(fn() => rand(100000, 999999)),
                                         ])
                                         ->action(fn (array $data) => $this->testPatternConnection($data)),
                                 ]),

                            // Sms.ir
                            Grid::make(2)->schema([
                                TextInput::make('smsir_api_key')->label('API Key (Sms.ir)'),
                                TextInput::make('smsir_line_number')->label('خط اختصاصی (Sms.ir)'),
                                TextInput::make('smsir_otp_pattern')->label('کد الگوی OTP (Sms.ir)'),
                            ])->visible(fn($get) => $get('sms_provider') === 'smsir'),
                        ]),
                    ]),

                    // ── Tab 8: Theme ──
                    Tab::make('تم و رنگ‌ها')->icon('heroicon-o-paint-brush')->schema([
                        SchemaActions::make([
                            Action::make('resetTheme')
                                ->label('ریست همه رنگ‌ها به پیش‌فرض')
                                ->icon('heroicon-o-arrow-path')
                                ->color('danger')
                                ->requiresConfirmation()
                                ->modalHeading('ریست تمام رنگ‌ها')
                                ->modalDescription('تمام رنگ‌های سایت به مقادیر پیش‌فرض بازگردانده می‌شوند. ادامه می‌دهید؟')
                                ->modalSubmitActionLabel('بله، ریست کن')
                                ->action('resetTheme'),
                        ]),

                        Section::make('رنگ‌های اصلی')
                            ->description('رنگ‌های پایه که در کل سایت استفاده می‌شوند.')
                            ->schema([
                                ColorPicker::make('theme_primary')->label('Primary — دکمه‌ها، لینک‌ها، تاکید')->hexColor(),
                                ColorPicker::make('theme_secondary')->label('Secondary — رنگ دوم')->hexColor(),
                                ColorPicker::make('theme_accent')->label('Accent — رنگ تاکیدی')->hexColor(),
                                ColorPicker::make('theme_danger')->label('Danger — خطا، حذف')->hexColor(),
                                ColorPicker::make('theme_success')->label('Success — موفقیت، تأیید')->hexColor(),
                                ColorPicker::make('theme_warning')->label('Warning — هشدار')->hexColor(),
                            ])->columns(3),

                        Section::make('پس‌زمینه و سطح‌ها')
                            ->schema([
                                ColorPicker::make('theme_bg_light')->label('پس‌زمینه — حالت روشن')->hexColor(),
                                ColorPicker::make('theme_bg_dark')->label('پس‌زمینه — حالت تاریک')->hexColor(),
                                ColorPicker::make('theme_surface_light')->label('سطح کارت — روشن')->hexColor(),
                                ColorPicker::make('theme_surface_dark')->label('سطح کارت — تاریک')->hexColor(),
                            ])->columns(2),

                        Section::make('سایدبار')
                            ->description('رنگ‌های نوار کناری (sidebar) برای هر دو پنل شنونده و هنرمند.')
                            ->schema([
                                ColorPicker::make('theme_sidebar_bg_light')->label('پس‌زمینه سایدبار — روشن')->hexColor(),
                                ColorPicker::make('theme_sidebar_bg_dark')->label('پس‌زمینه سایدبار — تاریک')->hexColor(),
                                ColorPicker::make('theme_sidebar_text')->label('رنگ متن آیتم‌ها')->hexColor(),
                                ColorPicker::make('theme_sidebar_active_bg')->label('پس‌زمینه آیتم فعال')->hexColor(),
                                ColorPicker::make('theme_sidebar_active_text')->label('رنگ متن آیتم فعال')->hexColor(),
                                ColorPicker::make('theme_sidebar_border')->label('رنگ خط جداکننده')->hexColor(),
                            ])->columns(3),

                        Section::make('هدر / نوار بالا')
                            ->schema([
                                ColorPicker::make('theme_header_bg_light')->label('پس‌زمینه هدر — روشن')->hexColor(),
                                ColorPicker::make('theme_header_bg_dark')->label('پس‌زمینه هدر — تاریک')->hexColor(),
                                ColorPicker::make('theme_header_border')->label('رنگ خط پایین هدر')->hexColor(),
                            ])->columns(3),

                        Section::make('پلیر و گرادیانت')
                            ->schema([
                                ColorPicker::make('theme_gradient_from')->label('شروع گرادیانت')->hexColor(),
                                ColorPicker::make('theme_gradient_to')->label('پایان گرادیانت')->hexColor(),
                                ColorPicker::make('theme_player_bg')->label('پس‌زمینه پلیر')->hexColor(),
                                ColorPicker::make('theme_player_text_light')->label('رنگ متن پلیر — روشن')->hexColor(),
                                ColorPicker::make('theme_player_text')->label('رنگ متن پلیر — تاریک')->hexColor(),
                                ColorPicker::make('theme_player_control')->label('رنگ دکمه‌های پلیر')->hexColor(),
                            ])->columns(3),

                        Section::make('فونت و گردی لبه‌ها')->schema([
                            Select::make('theme_font_fa')->label('فونت فارسی')
                                ->options(['Vazirmatn' => 'Vazirmatn', 'IRANSans' => 'IRANSans', 'Sahel' => 'Sahel', 'Yekanbakh' => 'Yekanbakh']),
                            Select::make('theme_font_en')->label('فونت انگلیسی')
                                ->options(['Inter' => 'Inter', 'Poppins' => 'Poppins', 'Roboto' => 'Roboto']),
                            Select::make('theme_radius')->label('گردی لبه‌ها')
                                ->options(['none' => 'بدون', 'sm' => 'کم', 'md' => 'متوسط (پیش‌فرض)', 'lg' => 'زیاد', 'full' => 'کاملاً گرد']),
                        ])->columns(3),
                    ]),

                    // ── Tab 9: Banners ──
                    Tab::make('بنرهای سایدبار')->icon('heroicon-o-rectangle-group')->schema([

                        Section::make('بنر پریمیوم (سایدبار)')
                            ->description('این بنر برای کاربران غیرپریمیوم در پایین سایدبار نمایش داده می‌شود.')
                            ->schema([
                                Toggle::make('premium_banner_enabled')
                                    ->label('نمایش بنر پریمیوم')
                                    ->default(true)
                                    ->columnSpanFull(),
                                TextInput::make('premium_banner_title')
                                    ->label('عنوان بنر')
                                    ->default(config('app.name') . ' پریمیوم')
                                    ->placeholder(config('app.name') . ' پریمیوم'),
                                TextInput::make('premium_banner_subtitle')
                                    ->label('زیرعنوان')
                                    ->default('بدون تبلیغات، کیفیت بالا')
                                    ->placeholder('بدون تبلیغات، کیفیت بالا'),
                                TextInput::make('premium_banner_btn_text')
                                    ->label('متن دکمه')
                                    ->default('ارتقا حساب')
                                    ->placeholder('ارتقا حساب'),
                                TextInput::make('premium_banner_btn_url')
                                    ->label('لینک دکمه')
                                    ->default('/premium')
                                    ->placeholder('/premium'),
                                ColorPicker::make('premium_banner_bg_from')
                                    ->label('رنگ شروع گرادیانت')
                                    ->hexColor(),
                                ColorPicker::make('premium_banner_bg_to')
                                    ->label('رنگ پایان گرادیانت')
                                    ->hexColor(),
                                ColorPicker::make('premium_banner_text_color')
                                    ->label('رنگ متن و دکمه')
                                    ->hexColor()
                                    ->helperText('پیش‌فرض: سفید (#ffffff)'),
                                FileUpload::make('premium_banner_image')
                                    ->label('عکس بنر (اختیاری — جایگزین گرادیانت می‌شود)')
                                    ->image()
                                    ->directory('banners')
                                    ->disk('public')
                                    ->visibility('public')
                                    ->columnSpanFull()
                                    ->helperText('اگر عکس آپلود شود، به جای رنگ گرادیانت استفاده می‌شود'),
                            ])->columns(2),

                        Section::make('بنر هنرمند شو (سایدبار)')
                            ->description('این بنر برای کاربران شنونده (غیرهنرمند) در پایین سایدبار نمایش داده می‌شود.')
                            ->schema([
                                Toggle::make('artist_banner_enabled')
                                    ->label('نمایش بنر هنرمند شو')
                                    ->default(true)
                                    ->columnSpanFull(),
                                TextInput::make('artist_banner_title')
                                    ->label('عنوان بنر')
                                    ->default('هنرمند شوید!')
                                    ->placeholder('هنرمند شوید!'),
                                TextInput::make('artist_banner_subtitle')
                                    ->label('زیرعنوان')
                                    ->default('موسیقی‌تان را با جهان به اشتراک بگذارید')
                                    ->placeholder('موسیقی‌تان را با جهان به اشتراک بگذارید'),
                                TextInput::make('artist_banner_btn_text')
                                    ->label('متن دکمه')
                                    ->default('شروع کنید')
                                    ->placeholder('شروع کنید'),
                                TextInput::make('artist_banner_btn_url')
                                    ->label('لینک دکمه')
                                    ->default('/become-artist')
                                    ->placeholder('/become-artist'),
                                ColorPicker::make('artist_banner_bg_from')
                                    ->label('رنگ شروع گرادیانت')
                                    ->hexColor(),
                                ColorPicker::make('artist_banner_bg_to')
                                    ->label('رنگ پایان گرادیانت')
                                    ->hexColor(),
                                ColorPicker::make('artist_banner_text_color')
                                    ->label('رنگ متن و دکمه')
                                    ->hexColor()
                                    ->helperText('پیش‌فرض: سفید (#ffffff)'),
                                FileUpload::make('artist_banner_image')
                                    ->label('عکس بنر (اختیاری — جایگزین گرادیانت می‌شود)')
                                    ->image()
                                    ->directory('banners')
                                    ->disk('public')
                                    ->visibility('public')
                                    ->columnSpanFull()
                                    ->helperText('اگر عکس آپلود شود، به جای رنگ گرادیانت استفاده می‌شود'),
                            ])->columns(2),
                    ]),

                    // ── Tab 10: Sidebar Footer ──
                    Tab::make('فوتر سایدبار')->icon('heroicon-o-document-text')->schema([
                        Section::make('بخش فوتر سایدبار')
                            ->description('این بخش قبل از بنرهای پایین سایدبار نمایش داده می‌شود و می‌تواند شامل لینک‌های مفید و متن کوتاه باشد.')
                            ->schema([
                                Toggle::make('sidebar_footer_enabled')
                                    ->label('فعال بودن بخش فوتر')
                                    ->default(true),
                                
                                Textarea::make('sidebar_footer_description')
                                    ->label('متن توضیحی کوتاه')
                                    ->rows(2)
                                    ->placeholder('مثلاً: تمامی حقوق برای ' . config('app.name') . ' محفوظ است.'),
                                
                                \Filament\Forms\Components\Repeater::make('sidebar_footer_links')
                                    ->label('لینک‌های مفید')
                                    ->schema([
                                        TextInput::make('label')->label('عنوان لینک')->required(),
                                        TextInput::make('url')->label('آدرس (URL)')->required(),
                                    ])
                                    ->columns(2)
                                    ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
                                    ->addActionLabel('+ افزودن لینک')
                                    ->collapsible(),
                            ]),
                    ]),

                    // ── Tab 11: Storage ──
                    Tab::make('ذخیره‌سازی')->icon('heroicon-o-server')->schema([
                        Section::make('درایور ذخیره‌سازی')->schema([
                            Select::make('storage_driver')->label('درایور')
                                ->options([
                                    'local' => 'محلی (Local)',
                                    'ftp' => 'هاست دانلود (FTP)',
                                ])
                                ->live(),
                        ]),
                        Section::make('تنظیمات هاست دانلود')->schema([
                            TextInput::make('ftp_host')->label('آدرس هاست (Host)')->placeholder('ftp.yoursite.com')->required(),
                            TextInput::make('ftp_port')->label('پورت (Port)')->default(21)->numeric(),
                            TextInput::make('ftp_username')->label('نام کاربری (Username)')->required(),
                            TextInput::make('ftp_password')->label('رمز عبور (Password)')->password()->revealable()->required(),
                            TextInput::make('ftp_root')->label('مسیر اصلی (Root)')->placeholder('/public_html')->default('/'),
                            TextInput::make('ftp_url')->label('آدرس URL مستقیم')->placeholder('https://dl.yoursite.com')->required()
                                ->helperText('آدرس عمومی برای دسترسی به فایل‌ها از مرورگر'),
                            
                            SchemaActions::make([
                                Action::make('test_ftp')
                                    ->label('تست اتصال')
                                    ->color('info')
                                    ->icon('heroicon-o-signal')
                                    ->action('testFtpConnection')
                            ]),
                        ])
                        ->columns(2)
                        ->visible(fn ($get) => $get('storage_driver') === 'ftp'),
                    ]),

                    // ── Tab 11: Artist Earnings ──
                    Tab::make('درآمد هنرمندان')->icon('heroicon-o-banknotes')->schema([
                        Section::make('فعال‌سازی سیستم درآمدزایی')->schema([
                            Toggle::make('earnings_enabled')
                                ->label('سیستم درآمدزایی فعال باشد')
                                ->helperText('با فعال کردن این گزینه، هنرمندان به ازای پخش آهنگ‌ها و پادکست‌هایشان درآمد کسب می‌کنند'),
                        ])->columns(1),
                        Section::make('تنظیمات پرداخت')->schema([
                            TextInput::make('earnings_plays_threshold')
                                ->label('تعداد پخش برای کسب درآمد (n)')
                                ->numeric()->default(100)
                                ->suffix('پخش')
                                ->helperText('به ازای هر n پخش، مبلغ x تومان به حساب هنرمند واریز می‌شود'),
                            TextInput::make('earnings_amount_toman')
                                ->label('مبلغ درآمد به ازای n پخش (x)')
                                ->numeric()->default(500)
                                ->suffix('تومان'),
                            TextInput::make('earnings_min_payout')
                                ->label('حداقل درخواست برداشت')
                                ->numeric()->default(50000)
                                ->suffix('تومان'),
                        ])->columns(3),
                        Section::make('توضیحات پرداخت')->schema([
                            Textarea::make('earnings_payout_description')
                                ->label('توضیحات نحوه پرداخت به هنرمندان')
                                ->rows(3)
                                ->placeholder('مثلاً: پرداخت‌ها هر ماه ۱۵ ام شمسی انجام می‌شود...'),
                        ]),
                    ]),

                    // ── Tab 12: PWA ──
                    Tab::make('PWA (وب‌اپ)')->icon('heroicon-o-device-phone-mobile')->schema([
                        Section::make('تنظیمات Progressive Web App')->schema([
                            Toggle::make('pwa_enabled')
                                ->label('فعال‌سازی PWA')
                                ->helperText('امکان نصب اپلیکیشن روی گوشی‌های اندروید و آیفون'),
                            TextInput::make('pwa_name')
                                ->label('نام اپلیکیشن')
                                ->helperText('نامی که هنگام نصب نمایش داده می‌شود')
                                ->default(config('app.name')),
                            TextInput::make('pwa_short_name')
                                ->label('نام کوتاه')
                                ->helperText('نام کوتاه برای نمایش در صفحه اصلی گوشی')
                                ->default(config('app.name')),
                        ])->columns(2),

                        Section::make('آیکون اپلیکیشن')->schema([
                            FileUpload::make('pwa_icon')
                                ->label('آیکون PWA (PNG مربعی — حداقل 512×512)')
                                ->image()
                                ->acceptedFileTypes(['image/png'])
                                ->directory('settings')
                                ->disk('public')
                                ->visibility('public')
                                ->helperText('پس از ذخیره، خودکار در سایزهای 192×192، 512×512 و 180×180 تولید می‌شود.')
                                ->columnSpanFull(),
                        ]),

                        Section::make('رنگ‌ها و نمایش')->schema([
                            ColorPicker::make('pwa_theme_color')
                                ->label('رنگ تم (Theme Color)')
                                ->default('#0ea5e9'),
                            ColorPicker::make('pwa_bg_color')
                                ->label('رنگ پس‌زمینه (Background)')
                                ->default('#020617'),
                            Select::make('pwa_display')
                                ->label('حالت نمایش')
                                ->options([
                                    'standalone' => 'Standalone (مثل اپلیکیشن)',
                                    'fullscreen' => 'تمام صفحه',
                                    'minimal-ui' => 'حداقل UI',
                                    'browser' => 'مرورگر',
                                ])
                                ->default('standalone'),
                        ])->columns(3),
                    ]),

                ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // Save earnings settings separately
        $earningsKeys = ['earnings_enabled', 'earnings_plays_threshold', 'earnings_amount_toman', 'earnings_min_payout', 'earnings_payout_description'];
        $earningsData = [];
        foreach ($earningsKeys as $key) {
            if (isset($data[$key])) {
                $earningsData[str_replace('earnings_', '', $key)] = $data[$key];
                unset($data[$key]);
            }
        }
        
        if (!empty($earningsData)) {
            $earningsSettings = EarningsSetting::getSettings();
            $earningsSettings->update([
                'is_enabled' => $earningsData['enabled'] ?? false,
                'plays_threshold' => $earningsData['plays_threshold'] ?? 100,
                'earning_amount_toman' => $earningsData['amount_toman'] ?? 500,
                'min_payout_toman' => $earningsData['min_payout'] ?? 50000,
                'payout_description' => $earningsData['payout_description'] ?? null,
            ]);
        }

        // Save SMS Provider settings
        if (isset($data['sms_provider'])) {
            $activeDriver = $data['sms_provider'];
            
            // Deactivate all first
            \App\Models\SmsProvider::query()->update(['is_active' => false]);

            // Melipayamak
            \App\Models\SmsProvider::updateOrCreate(
                ['driver' => 'melipayamak'],
                [
                    'name' => 'ملی پیامک',
                    'is_active' => $activeDriver === 'melipayamak',
                    'credentials' => [
                        'username' => $data['melipayamak_username'] ?? '',
                        'password' => $data['melipayamak_password'] ?? '',
                        'from' => $data['melipayamak_from'] ?? '',
                        'otp_pattern' => $data['melipayamak_otp_pattern'] ?? '',
                    ],
                ]
            );

            // Sms.ir
            \App\Models\SmsProvider::updateOrCreate(
                ['driver' => 'smsir'],
                [
                    'name' => 'Sms.ir',
                    'is_active' => $activeDriver === 'smsir',
                    'credentials' => [
                        'api_key' => $data['smsir_api_key'] ?? '',
                        'line_number' => $data['smsir_line_number'] ?? '',
                        'otp_pattern' => $data['smsir_otp_pattern'] ?? '',
                    ],
                ]
            );

            unset($data['sms_provider'], $data['melipayamak_username'], $data['melipayamak_password'], $data['melipayamak_from'], $data['melipayamak_otp_pattern'], $data['smsir_api_key'], $data['smsir_line_number'], $data['smsir_otp_pattern']);
        }

        // Save payment gateway config
        foreach (['zibal_merchant', 'payping_token', 'zarinpal_merchant', 'zarinpal_sandbox'] as $key) {
            if (array_key_exists($key, $data)) {
                Setting::set($key, is_bool($data[$key]) ? ($data[$key] ? '1' : '0') : ($data[$key] ?? ''));
                unset($data[$key]);
            }
        }
        if (array_key_exists('active_gateways', $data)) {
            Setting::set('active_gateways', json_encode($data['active_gateways'] ?? []));
            unset($data['active_gateways']);
        }

        // Save other settings
        foreach ($data as $key => $value) {
            Setting::set($key, is_bool($value) ? ($value ? '1' : '0') : $value);
        }

        // ── PWA Icon Resize ──
        if (!empty($data['pwa_icon']) && is_string($data['pwa_icon'])) {
            try {
                $this->resizePwaIcon($data['pwa_icon']);
            } catch (\Throwable $e) {
                \Log::warning('PWA icon resize failed: ' . $e->getMessage());
            }
        }

        // ── Auto-sync NotificationSettings based on auth_type ──
        if (isset($data['auth_type'])) {
            $authType = $data['auth_type'];

            // otp_code: فعال اگر auth_type = otp یا both
            $otpViaSms = in_array($authType, ['otp', 'both']);
            \App\Models\NotificationSetting::updateOrCreate(
                ['event_key' => 'otp_code'],
                [
                    'event_label'  => 'ارسال کد تایید (OTP)',
                    'recipient_type' => 'user',
                    'via_sms'      => $otpViaSms,
                    'via_database' => false,
                    'via_email'    => false,
                ]
            );

            // password_recovery: فعال اگر auth_type = otp یا both
            $recoveryViaSms   = in_array($authType, ['otp', 'both']);
            $recoveryViaEmail = in_array($authType, ['password', 'both']);
            \App\Models\NotificationSetting::updateOrCreate(
                ['event_key' => 'password_recovery'],
                [
                    'event_label'  => 'بازیابی رمز عبور',
                    'recipient_type' => 'user',
                    'via_sms'      => $recoveryViaSms,
                    'via_email'    => $recoveryViaEmail,
                    'via_database' => false,
                ]
            );
        }

        Cache::flush();

        Notification::make()
            ->title('تنظیمات با موفقیت ذخیره شد ✅')
            ->success()
            ->send();
    }

    protected function resizePwaIcon(string $iconPath): void
    {
        if (!extension_loaded('gd')) {
            \Log::warning('PWA icon resize skipped: PHP GD extension not installed.');
            return;
        }

        $fullPath = Storage::disk('public')->path($iconPath);
        if (!file_exists($fullPath)) return;

        $sizes = [192, 512, 180];
        $dir = dirname($fullPath);
        $ext = pathinfo($fullPath, PATHINFO_EXTENSION);
        $base = pathinfo($fullPath, PATHINFO_FILENAME);

        foreach ($sizes as $size) {
            $resized = imagecreatetruecolor($size, $size);
            $src = imagecreatefrompng($fullPath);
            if (!$src) continue;

            imagealphablending($resized, false);
            imagesavealpha($resized, true);
            $transparent = imagecolorallocatealpha($resized, 0, 0, 0, 127);
            imagefill($resized, 0, 0, $transparent);

            $srcW = imagesx($src);
            $srcH = imagesy($src);
            imagecopyresampled($resized, $src, 0, 0, 0, 0, $size, $size, $srcW, $srcH);

            $outFile = $dir . '/' . $base . '-' . $size . '.' . $ext;
            imagepng($resized, $outFile, 9);
            imagedestroy($resized);
            imagedestroy($src);

            // Save path relative to public disk
            $relPath = str_replace(Storage::disk('public')->path(''), '', $outFile);
            $relPath = ltrim(str_replace('\\', '/', $relPath), '/');
            Setting::set("pwa_icon_{$size}", $relPath);
        }
    }

    protected function getFormActions(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('ذخیره تنظیمات')
                ->icon('heroicon-o-check')
                ->color('success')
                ->action('save'),
        ];
    }

    public function testSmtpConnection(array $data): void
    {
        $formData = $this->form->getState();
        $recipient = $data['test_recipient'];

        if (empty($formData['smtp_host'])) {
            Notification::make()
                ->title('خطا در تنظیمات ❌')
                ->body('لطفاً ابتدا فیلد SMTP Host را پر کنید.')
                ->danger()
                ->send();
            return;
        }

        config([
            'mail.default' => 'smtp',
            'mail.mailers.smtp' => [
                'transport' => 'smtp',
                'host' => (string) $formData['smtp_host'],
                'port' => (int) ($formData['smtp_port'] ?? 587),
                'encryption' => ($formData['smtp_encryption'] ?? 'tls') === 'none' ? null : ($formData['smtp_encryption'] ?? 'tls'),
                'username' => (string) ($formData['smtp_username'] ?? ''),
                'password' => (string) ($formData['smtp_password'] ?? ''),
                'timeout' => 10,
            ],
            'mail.from' => [
                'address' => (string) ($formData['mail_from_address'] ?? 'noreply@melodiyam.ir'),
                'name' => (string) ($formData['mail_from_name'] ?? config('app.name')),
            ],
        ]);

        // Purge resolved mailer to apply new config
        \Illuminate\Support\Facades\Mail::forgetMailers();

        try {
            \Illuminate\Support\Facades\Mail::to($recipient)->send(new \App\Mail\TestMail());
            
            Notification::make()
                ->title('ایمیل تست با موفقیت ارسال شد! 📧')
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('خطا در ارسال ایمیل ❌')
                ->body('لطفاً تنظیمات SMTP را بررسی کنید. خطا: ' . $e->getMessage())
                ->danger()
                ->persistent()
                ->send();
        }
    }

    public function testSmsConnection(array $data): void
    {
        $formData = $this->form->getState();
        $provider = $formData['sms_provider'];
        $phone = $data['test_phone'];
        $message = $data['test_message'];

        $credentials = [];
        if ($provider === 'melipayamak') {
            $credentials = [
                'username' => $formData['melipayamak_username'],
                'password' => $formData['melipayamak_password'],
                'from' => $formData['melipayamak_from'],
            ];
            $driverClass = \App\Services\SmsDrivers\MelipayamakDriver::class;
        } else {
            $credentials = [
                'api_key' => $formData['smsir_api_key'],
                'line_number' => $formData['smsir_line_number'],
            ];
            $driverClass = \App\Services\SmsDrivers\SmsIrDriver::class;
        }

        try {
            $driver = new $driverClass($credentials);
            $result = $driver->sendText($phone, $message);

            if ($result['success']) {
                Notification::make()
                    ->title('پیامک با موفقیت ارسال شد! ✅')
                    ->body('پاسخ درگاه: ' . json_encode($result['response'], JSON_UNESCAPED_UNICODE))
                    ->success()
                    ->persistent()
                    ->send();
            } else {
                Notification::make()
                    ->title('خطا در ارسال پیامک ❌')
                    ->body('پیام خطا: ' . ($result['message'] ?? 'نامشخص') . "\nپاسخ: " . json_encode($result['response'] ?? '', JSON_UNESCAPED_UNICODE))
                    ->danger()
                    ->persistent()
                    ->send();
            }
        } catch (\Exception $e) {
            Notification::make()
                ->title('خطای سیستم ❌')
                ->body('خطا: ' . $e->getMessage())
                ->danger()
                ->persistent()
                ->send();
        }
    }

    public function testPatternConnection(array $data): void
    {
        $formData = $this->form->getState();
        $provider = $formData['sms_provider'];
        $phone = $data['test_phone'];
        $code = $data['test_code'];

        $credentials = [];
        if ($provider === 'melipayamak') {
            $credentials = [
                'username' => $formData['melipayamak_username'],
                'password' => $formData['melipayamak_password'],
                'otp_pattern' => $formData['melipayamak_otp_pattern'],
            ];
            $patternId = $credentials['otp_pattern'];
            $driverClass = \App\Services\SmsDrivers\MelipayamakDriver::class;
        } else {
            $credentials = [
                'api_key' => $formData['smsir_api_key'],
                'line_number' => $formData['smsir_line_number'],
                'otp_pattern' => $formData['smsir_otp_pattern'],
            ];
            $patternId = $credentials['otp_pattern'];
            $driverClass = \App\Services\SmsDrivers\SmsIrDriver::class;
        }

        if (!$patternId) {
            Notification::make()->title('کد الگو تنظیم نشده است')->danger()->send();
            return;
        }

        try {
            $driver = new $driverClass($credentials);
            $result = $driver->sendByPattern($phone, $patternId, ['code' => $code]);

            if ($result['success']) {
                Notification::make()
                    ->title('پیامک پترن با موفقیت ارسال شد! ✅')
                    ->body('پاسخ درگاه: ' . json_encode($result['response'], JSON_UNESCAPED_UNICODE))
                    ->success()
                    ->persistent()
                    ->send();
            } else {
                Notification::make()
                    ->title('خطا در ارسال پترن ❌')
                    ->body('پیام خطا: ' . ($result['message'] ?? 'نامشخص') . "\nپاسخ: " . json_encode($result['response'] ?? '', JSON_UNESCAPED_UNICODE))
                    ->danger()
                    ->persistent()
                    ->send();
            }
        } catch (\Exception $e) {
            Notification::make()
                ->title('خطای سیستم ❌')
                ->body('خطا: ' . $e->getMessage())
                ->danger()
                ->persistent()
                ->send();
        }
    }

    public function testFtpConnection(): void
    {
        $data = $this->form->getState();

        config([
            'filesystems.disks.ftp_test' => [
                'driver' => 'ftp',
                'host' => $data['ftp_host'],
                'username' => $data['ftp_username'],
                'password' => $data['ftp_password'],
                'port' => (int) $data['ftp_port'],
                'root' => $data['ftp_root'],
                'passive' => true,
                'ssl' => false,
                'timeout' => 10,
            ]
        ]);

        try {
            $disk = Storage::disk('ftp_test');
            // Try to list contents of root to verify connection
            $disk->files('/');
            
            Notification::make()
                ->title('اتصال برقرار شد! ✅')
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('خطا در اتصال ❌')
                ->body('لطفاً مشخصات هاست دانلود را بررسی کنید. خطا: ' . $e->getMessage())
                ->danger()
                ->persistent()
                ->send();
        }
    }

    public function resetTheme(): void
    {
        $allDefaults = Setting::defaults();
        $themeKeys = [
            'theme_primary', 'theme_secondary', 'theme_accent', 'theme_danger', 'theme_success', 'theme_warning',
            'theme_bg_light', 'theme_bg_dark', 'theme_surface_light', 'theme_surface_dark',
            'theme_gradient_from', 'theme_gradient_to', 'theme_player_bg', 'theme_player_text_light', 'theme_player_text', 'theme_player_control',
            'theme_sidebar_bg_light', 'theme_sidebar_bg_dark', 'theme_sidebar_text',
            'theme_sidebar_active_bg', 'theme_sidebar_active_text', 'theme_sidebar_border',
            'theme_header_bg_light', 'theme_header_bg_dark', 'theme_header_border',
            'theme_font_fa', 'theme_font_en', 'theme_radius',
        ];

        foreach ($themeKeys as $key) {
            if (isset($allDefaults[$key])) {
                Setting::set($key, $allDefaults[$key]);
            }
        }

        Cache::flush();

        // reload form with new values
        $this->form->fill($this->getSettingsForForm());

        Notification::make()
            ->title('رنگ‌ها به حالت پیش‌فرض بازگشتند 🎨')
            ->info()
            ->send();
    }

    public function getView(): string
    {
        return 'filament.pages.settings';
    }
}
