<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Repeater;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Facades\Cache;

class SmartPlaylistSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-musical-note';
    protected static string|\UnitEnum|null $navigationGroup = 'تنظیمات سیستم';
    protected static ?string $title = 'پلی‌لیست‌های هوشمند';
    protected static ?string $navigationLabel = 'پلی‌لیست‌های هوشمند';
    protected static ?int $navigationSort = 5;

    public array $data = [];

    public function mount(): void
    {
        $templates = Setting::get('smart_playlist_templates', []);
        if (is_string($templates)) {
            $templates = json_decode($templates, true) ?? [];
        }

        $this->form->fill(['templates' => $templates]);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->statePath('data')
            ->schema([
                Section::make('قالب‌های پلی‌لیست هوشمند')
                    ->description('این قالب‌ها برای ساخت خودکار پلی‌لیست‌های شخصی‌سازی‌شده برای هر کاربر استفاده می‌شوند. محتوای هر پلی‌لیست بر اساس سلیقه و رفتار شنیداری کاربر به‌صورت خودکار پر می‌شود و هر هفته بروزرسانی می‌شود.')
                    ->schema([
                        Repeater::make('templates')
                            ->label('قالب‌ها')
                            ->schema([
                                TextInput::make('key')
                                    ->label('کلید یکتا (انگلیسی)')
                                    ->required()
                                    ->maxLength(50)
                                    ->alphaDash()
                                    ->helperText('مثلاً: daily_mix, chill_vibes, workout_energy')
                                    ->columnSpan(1),

                                TextInput::make('name')
                                    ->label('نام نمایشی (فارسی)')
                                    ->required()
                                    ->maxLength(100)
                                    ->helperText('نامی که کاربر در صفحه کشف کن می‌بیند')
                                    ->columnSpan(1),

                                Select::make('strategy')
                                    ->label('استراتژی انتخاب آهنگ')
                                    ->required()
                                    ->options([
                                        'top_genre_mix' => 'ترکیب ژانرهای مورد علاقه',
                                        'recent_favorites' => 'آهنگ‌های اخیر مورد علاقه',
                                        'trending_in_genres' => 'پرطرفدارها در ژانر کاربر',
                                        'mood_based' => 'بر اساس مود/حس‌وحال',
                                        'artist_exploration' => 'کشف هنرمندان مشابه',
                                        'forgotten_gems' => 'آهنگ‌های فراموش‌شده',
                                    ])
                                    ->columnSpan(1),

                                FileUpload::make('cover_image')
                                    ->label('تصویر کاور')
                                    ->image()
                                    ->directory('settings/playlists')
                                    ->disk('public')
                                    ->visibility('public')
                                    ->imagePreviewHeight('100')
                                    ->columnSpan(1),

                                TextInput::make('track_count')
                                    ->label('تعداد آهنگ')
                                    ->numeric()
                                    ->minValue(5)
                                    ->maxValue(50)
                                    ->default(20)
                                    ->columnSpan(1),

                                Toggle::make('enabled')
                                    ->label('فعال')
                                    ->default(true)
                                    ->columnSpan(1),
                            ])
                            ->columns(3)
                            ->itemLabel(fn(array $state): ?string => $state['name'] ?? null)
                            ->collapsible()
                            ->defaultItems(0)
                            ->addActionLabel('افزودن قالب جدید'),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $templates = $data['templates'] ?? [];

        // Ensure unique keys
        $keys = array_column($templates, 'key');
        if (count($keys) !== count(array_unique($keys))) {
            Notification::make()
                ->danger()
                ->title('خطا: کلید تکراری')
                ->body('کلید هر قالب باید یکتا باشد.')
                ->send();
            return;
        }

        Setting::set('smart_playlist_templates', json_encode($templates));
        Cache::forget('smart_playlist_templates');

        // Invalidate all user smart playlist caches
        Cache::forget('smart_playlists_all');

        Notification::make()
            ->success()
            ->title('تنظیمات پلی‌لیست‌های هوشمند ذخیره شد')
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('ذخیره تنظیمات')
                ->icon('heroicon-o-check')
                ->color('primary')
                ->action('save'),
        ];
    }
}
