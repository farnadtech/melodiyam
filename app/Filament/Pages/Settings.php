<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Schemas\Components\Actions as SchemaActions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Support\Facades\Cache;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static string | \UnitEnum | null $navigationGroup = 'سیستم';
    protected static ?string $title = 'تنظیمات سایت';
    protected static ?string $navigationLabel = 'تنظیمات';
    protected static ?int $navigationSort = 99;

    public array $data = [];

    public function mount(): void
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        $this->form->fill($settings);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->statePath('data')
            ->schema([
                Tabs::make('تنظیمات')->tabs([

                    // ── Tab 1: General ──
                    Tab::make('⚙️ عمومی')->schema([
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
                        ])->columns(2),

                        Section::make('تعمیر و نگهداری')->schema([
                            Toggle::make('maintenance_mode')->label('حالت تعمیر')->onColor('danger'),
                            Textarea::make('maintenance_message')->label('پیام تعمیر')->rows(2),
                        ])->columns(2),
                    ]),

                    // ── Tab 2: Auth & Registration ──
                    Tab::make('👤 ثبت‌نام و احراز هویت')->schema([
                        Section::make('تنظیمات ثبت‌نام')->schema([
                            Toggle::make('allow_registration')->label('ثبت‌نام آزاد'),
                            Toggle::make('email_verification')->label('تأیید ایمیل اجباری'),
                            Toggle::make('phone_verification')->label('تأیید موبایل اجباری'),
                            Toggle::make('allow_artist_register')->label('ثبت‌نام هنرمند'),
                            Toggle::make('auto_approve_artist')->label('تأیید خودکار هنرمند'),
                        ])->columns(3),
                    ]),

                    // ── Tab 3: Content & Music ──
                    Tab::make('🎵 محتوا و موسیقی')->schema([
                        Section::make('محدودیت‌های پخش')->schema([
                            TextInput::make('free_stream_limit')->label('سقف پخش رایگان (۰ = نامحدود)')->numeric(),
                            Toggle::make('allow_download_free')->label('دانلود برای کاربران رایگان'),
                            Toggle::make('allow_download_premium')->label('دانلود برای کاربران پریمیوم'),
                        ])->columns(3),
                        Section::make('آپلود و صفحه اصلی')->schema([
                            TextInput::make('max_upload_size_mb')->label('حداکثر حجم آپلود (MB)')->numeric(),
                            TextInput::make('featured_tracks_count')->label('تعداد آهنگ‌های ویژه')->numeric(),
                            TextInput::make('home_new_releases')->label('تعداد جدیدترین‌ها در خانه')->numeric(),
                        ])->columns(3),
                    ]),

                    // ── Tab 4: Premium & Payment ──
                    Tab::make('💎 پریمیوم و پرداخت')->schema([
                        Section::make('اشتراک')
                            ->description('روزهای آزمایشی هر پلن را از بخش «اشتراک ← طرح‌های اشتراک» تنظیم کنید.')
                            ->schema([
                                Toggle::make('premium_enabled')->label('فعال بودن پریمیوم'),
                                TextInput::make('currency')->label('واحد پول'),
                            ])->columns(2),
                        Section::make('درگاه پرداخت')->schema([
                            Select::make('payment_gateway')
                                ->label('درگاه پرداخت فعال')
                                ->options([
                                    ''          => '— غیرفعال —',
                                    'zarinpal'  => 'زرین‌پال',
                                    'idpay'     => 'آیدی‌پی (IDPay)',
                                    'payir'     => 'Pay.ir',
                                    'nextpay'   => 'نکست‌پی',
                                    'vandar'    => 'وندار',
                                ])
                                ->live()
                                ->columnSpanFull(),

                            // Zarinpal
                            TextInput::make('zarinpal_merchant')
                                ->label('Merchant ID زرین‌پال')
                                ->placeholder('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx')
                                ->visible(fn($get) => $get('payment_gateway') === 'zarinpal')
                                ->columnSpanFull(),
                            Toggle::make('zarinpal_sandbox')
                                ->label('حالت آزمایشی (Sandbox) زرین‌پال')
                                ->visible(fn($get) => $get('payment_gateway') === 'zarinpal'),

                            // IDPay
                            TextInput::make('idpay_api_key')
                                ->label('API Key آیدی‌پی')
                                ->password()->revealable()
                                ->visible(fn($get) => $get('payment_gateway') === 'idpay'),
                            Toggle::make('idpay_sandbox')
                                ->label('حالت آزمایشی (Sandbox) آیدی‌پی')
                                ->visible(fn($get) => $get('payment_gateway') === 'idpay'),

                            // Pay.ir
                            TextInput::make('payir_api')
                                ->label('API Key پی‌ایر')
                                ->password()->revealable()
                                ->visible(fn($get) => $get('payment_gateway') === 'payir'),

                            // Nextpay
                            TextInput::make('nextpay_api')
                                ->label('API Key نکست‌پی')
                                ->password()->revealable()
                                ->visible(fn($get) => $get('payment_gateway') === 'nextpay'),

                            // Vandar
                            TextInput::make('vandar_api')
                                ->label('API Key وندار')
                                ->password()->revealable()
                                ->visible(fn($get) => $get('payment_gateway') === 'vandar'),
                            TextInput::make('vandar_mobile')
                                ->label('موبایل وندار')
                                ->visible(fn($get) => $get('payment_gateway') === 'vandar'),
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
                    Tab::make('🔗 شبکه‌های اجتماعی')->schema([
                        Section::make()->schema([
                            TextInput::make('social_instagram')->label('اینستاگرام')->prefix('instagram.com/')->url(),
                            TextInput::make('social_telegram')->label('تلگرام')->prefix('t.me/'),
                            TextInput::make('social_twitter')->label('توییتر / X')->prefix('x.com/'),
                            TextInput::make('social_youtube')->label('یوتیوب')->url(),
                            TextInput::make('social_aparat')->label('آپارات')->url(),
                        ])->columns(2),
                    ]),

                    // ── Tab 6: SEO ──
                    Tab::make('🔍 سئو')->schema([
                        Section::make()->schema([
                            TextInput::make('meta_title')->label('عنوان متا'),
                            Textarea::make('meta_description')->label('توضیحات متا')->rows(2),
                            TextInput::make('meta_keywords')->label('کلمات کلیدی'),
                            TextInput::make('google_analytics')->label('کد گوگل آنالیتیکس (G-XXXXX)'),
                        ])->columns(2),
                    ]),

                    // ── Tab 7: Email / Notifications ──
                    Tab::make('📧 ایمیل و اعلان‌ها')->schema([
                        Section::make('اعلان‌های مدیر')->schema([
                            Toggle::make('notify_new_track')->label('اعلان آهنگ جدید'),
                            Toggle::make('notify_new_user')->label('اعلان کاربر جدید'),
                            Toggle::make('admin_email_notify')->label('ایمیل به مدیر'),
                        ])->columns(3),
                        Section::make('تنظیمات SMTP')->schema([
                            TextInput::make('smtp_host')->label('SMTP Host'),
                            TextInput::make('smtp_port')->label('SMTP Port')->numeric(),
                            TextInput::make('smtp_username')->label('نام کاربری SMTP'),
                            TextInput::make('smtp_password')->label('رمز SMTP')->password()->revealable(),
                            TextInput::make('mail_from_name')->label('نام فرستنده'),
                            TextInput::make('mail_from_address')->label('ایمیل فرستنده')->email(),
                        ])->columns(3),
                    ]),

                    // ── Tab 8: Theme ──
                    Tab::make('🎨 تم و رنگ‌ها')->schema([
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
                        Section::make('رنگ‌های اصلی سایت')
                            ->description('بعد از ذخیره، صفحه سایت را رفرش کنید.')
                            ->schema([
                                ColorPicker::make('theme_primary')->label('رنگ اصلی (Primary)')->hexColor(),
                                ColorPicker::make('theme_secondary')->label('رنگ ثانویه (Secondary)')->hexColor(),
                                ColorPicker::make('theme_accent')->label('رنگ تاکیدی (Accent)')->hexColor(),
                                ColorPicker::make('theme_danger')->label('رنگ خطر (Danger)')->hexColor(),
                                ColorPicker::make('theme_success')->label('رنگ موفقیت (Success)')->hexColor(),
                            ])->columns(3),
                        Section::make('رنگ‌های پس‌زمینه')->schema([
                            ColorPicker::make('theme_bg_light')->label('پس‌زمینه حالت روشن')->hexColor(),
                            ColorPicker::make('theme_bg_dark')->label('پس‌زمینه حالت تاریک')->hexColor(),
                            ColorPicker::make('theme_surface_light')->label('سطح کارت (روشن)')->hexColor(),
                            ColorPicker::make('theme_surface_dark')->label('سطح کارت (تاریک)')->hexColor(),
                        ])->columns(2),
                        Section::make('گرادیانت پلیر و هدر')->schema([
                            ColorPicker::make('theme_gradient_from')->label('شروع گرادیانت')->hexColor(),
                            ColorPicker::make('theme_gradient_to')->label('پایان گرادیانت')->hexColor(),
                            ColorPicker::make('theme_player_bg')->label('پس‌زمینه پلیر')->hexColor(),
                        ])->columns(3),
                        Section::make('فونت')->schema([
                            Select::make('theme_font_fa')->label('فونت فارسی')
                                ->options(['Vazirmatn' => 'Vazirmatn', 'IRANSans' => 'IRANSans', 'Sahel' => 'Sahel', 'Yekanbakh' => 'Yekanbakh']),
                            Select::make('theme_font_en')->label('فونت انگلیسی')
                                ->options(['Inter' => 'Inter', 'Poppins' => 'Poppins', 'Roboto' => 'Roboto']),
                            Select::make('theme_radius')->label('گردی لبه‌ها')
                                ->options(['none' => 'بدون', 'sm' => 'کم', 'md' => 'متوسط (پیش‌فرض)', 'lg' => 'زیاد', 'full' => 'کاملاً گرد']),
                        ])->columns(3),
                    ]),

                    // ── Tab 9: Storage ──
                    Tab::make('🗄️ ذخیره‌سازی')->schema([
                        Section::make('درایور ذخیره‌سازی')->schema([
                            Select::make('storage_driver')->label('درایور')
                                ->options(['local' => 'محلی (Local)', 's3' => 'AWS S3 / ArvanCloud']),
                        ]),
                        Section::make('تنظیمات S3')->schema([
                            TextInput::make('s3_key')->label('Access Key'),
                            TextInput::make('s3_secret')->label('Secret Key')->password()->revealable(),
                            TextInput::make('s3_region')->label('Region'),
                            TextInput::make('s3_bucket')->label('Bucket Name'),
                        ])->columns(2),
                    ]),

                ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::set($key, is_bool($value) ? ($value ? '1' : '0') : $value);
        }

        Cache::flush();

        Notification::make()
            ->title('تنظیمات با موفقیت ذخیره شد ✅')
            ->success()
            ->send();
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

    public function resetTheme(): void
    {
        $defaults = [
            'theme_primary'       => '#0ea5e9',
            'theme_secondary'     => '#8b5cf6',
            'theme_accent'        => '#d946ef',
            'theme_danger'        => '#ef4444',
            'theme_success'       => '#10b981',
            'theme_bg_light'      => '#f8fafc',
            'theme_bg_dark'       => '#020617',
            'theme_surface_light' => '#ffffff',
            'theme_surface_dark'  => '#0f172a',
            'theme_gradient_from' => '#0ea5e9',
            'theme_gradient_to'   => '#d946ef',
            'theme_player_bg'     => '#1a1a2e',
            'theme_font_fa'       => 'Vazirmatn',
            'theme_font_en'       => 'Inter',
            'theme_radius'        => 'md',
        ];

        foreach ($defaults as $key => $value) {
            Setting::set($key, $value);
        }

        Cache::flush();

        // reload form with new values
        $this->form->fill(Setting::pluck('value', 'key')->toArray());

        Notification::make()
            ->title('رنگ‌ها به حالت پیش‌فرض بازگشتند 🎨')
            ->success()
            ->send();
    }

    public function getView(): string
    {
        return 'filament.pages.settings';
    }
}
