<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomepageSectionResource\Pages;
use App\Models\HomepageSection;
use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Resources\Resource;

class HomepageSectionResource extends Resource
{
    protected static ?string $model = HomepageSection::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'صفحه اصلی';
    protected static ?string $modelLabel = 'بخش';
    protected static ?string $pluralModelLabel = 'بخش‌های صفحه اصلی';
    protected static string | \UnitEnum | null $navigationGroup = 'محتوا';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('اطلاعات اصلی')->schema([
                TextInput::make('title_fa')
                    ->label('عنوان بخش')
                    ->required()
                    ->maxLength(100)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, $set) {
                        $slug = preg_replace('/\s+/', '-', trim(mb_strtolower($state ?? '')));
                        $set('title', $slug ?: 'section-' . time());
                    })
                    ->columnSpanFull(),
                Grid::make(2)->schema([
                    Select::make('type')
                        ->label('نوع ویجت')
                        ->required()
                        ->live()
                        ->afterStateUpdated(function ($state, $set, $get) {
                            $defaults = \App\Models\HomepageSection::getDefaultConfig($state);
                            $currentConfig = $get('config') ?: [];
                            $set('config', array_merge($defaults, $currentConfig));
                        })
                        ->options([
                            'hero'              => '🎯 هیرو (بنر اصلی)',
                            'track_shelf'       => '🎼 قفسه آهنگ‌ها',
                            'featured_artists'  => '🎤 هنرمندان',
                            'featured_playlists'=> '🎵 پلی‌لیست‌ها',
                            'genres'            => '🎸 ژانرها',
                            'latest_albums'     => '💿 آلبوم‌های جدید',
                            'top_charts'        => '📊 چارت برتر',
                            'artist_spotlight'  => '⭐ هنرمند ویژه (یک نفره)',
                            'banner'            => '🖼️ بنر تبلیغاتی',
                            'custom_tracks'      => '🎼 آهنگ‌های دستی',
                            'featured_track'     => '🎵 آهنگ ویژه (کارت اسلایدر)',
                        ]),
                    Toggle::make('is_active')
                        ->label('فعال')
                        ->default(true)
                        ->inline(false),
                ]),
            ]),

            // ── Hero config ──
            Section::make('تنظیمات هیرو')
                ->visible(fn ($get) => $get('type') === 'hero')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('config.hero_title')->label('عنوان بزرگ'),
                        TextInput::make('config.hero_subtitle')->label('زیر عنوان'),
                    ]),
                    Grid::make(2)->schema([
                        TextInput::make('config.hero_btn1_label')->label('متن دکمه اول'),
                        TextInput::make('config.hero_btn1_url')->label('لینک دکمه اول'),
                    ]),
                    Grid::make(2)->schema([
                        TextInput::make('config.hero_btn2_label')->label('متن دکمه دوم'),
                        TextInput::make('config.hero_btn2_url')->label('لینک دکمه دوم'),
                    ]),
                    Grid::make(2)->schema([
                        ColorPicker::make('config.hero_color_from')->label('رنگ گرادیانت از')->hexColor(),
                        ColorPicker::make('config.hero_color_to')->label('رنگ گرادیانت تا')->hexColor(),
                    ]),
                    FileUpload::make('config.hero_image')
                        ->label('تصویر پس‌زمینه (اختیاری)')
                        ->image()
                        ->disk('public')
                        ->directory('homepage'),
                ]),

            // ── Track/Album shelf config (shared) ──
            Section::make('تنظیمات شلف')
                ->visible(fn ($get) => in_array($get('type'), [
                    'track_shelf', 'latest_albums'
                ]))
                ->schema([
                    Grid::make(3)->schema([
                        TextInput::make('config.limit')
                            ->label('تعداد آیتم')
                            ->numeric()->default(6)->minValue(1)->maxValue(24),
                        Select::make('config.layout')
                            ->label('چیدمان')
                            ->options(['grid'=>'شبکه‌ای','list'=>'لیستی','scroll'=>'اسکرول افقی'])
                            ->default('grid'),
                        Select::make('config.columns')
                            ->label('تعداد ستون')
                            ->options(['2'=>'۲','3'=>'۳','4'=>'۴','5'=>'۵','6'=>'۶'])
                            ->default('6'),
                    ]),
                    Grid::make(2)->schema([
                        Select::make('config.sort_by')
                            ->label('مرتب‌سازی')
                            ->options([
                                'release_date' => 'تاریخ انتشار',
                                'play_count'   => 'تعداد پخش',
                                'created_at'   => 'تاریخ افزوده شدن',
                                'like_count'   => 'تعداد لایک',
                            ])
                            ->default('release_date'),
                        Select::make('config.genre_filter')
                            ->label('فیلتر ژانر (چندتایی)')
                            ->options(fn () => \App\Models\Genre::active()->ordered()->pluck('name_fa', 'slug')->toArray())
                            ->multiple()
                            ->searchable()
                            ->placeholder('همه ژانرها'),
                    ]),
                    Toggle::make('config.show_see_all')->label('نمایش دکمه «مشاهده همه»')->default(true),
                    TextInput::make('config.see_all_url')
                        ->label('لینک «مشاهده همه» (خالی = خودکار)')
                        ->placeholder('خودکار بر اساس نوع و ژانر'),
                    TextInput::make('config.see_all_label')
                        ->label('متن دکمه «مشاهده همه»')
                        ->placeholder('مشاهده همه')
                        ->default('مشاهده همه'),
                ]),

            // ── Artists shelf config ──
            Section::make('تنظیمات هنرمندان')
                ->visible(fn ($get) => $get('type') === 'featured_artists')
                ->schema([
                    Grid::make(3)->schema([
                        TextInput::make('config.limit')->label('تعداد')->numeric()->default(8)->minValue(1)->maxValue(20),
                        Select::make('config.columns')
                            ->label('تعداد ستون')
                            ->options(['3'=>'۳','4'=>'۴','5'=>'۵','6'=>'۶','8'=>'۸'])
                            ->default('8'),
                        Toggle::make('config.featured_only')->label('فقط ویژه‌ها')->default(true),
                    ]),
                ]),

            // ── Playlists shelf config ──
            Section::make('تنظیمات پلی‌لیست')
                ->visible(fn ($get) => $get('type') === 'featured_playlists')
                ->schema([
                    Grid::make(3)->schema([
                        TextInput::make('config.limit')->label('تعداد')->numeric()->default(6)->minValue(1)->maxValue(20),
                        Select::make('config.columns')
                            ->label('تعداد ستون')
                            ->options(['2'=>'۲','3'=>'۳','4'=>'۴','6'=>'۶'])
                            ->default('6'),
                        Toggle::make('config.featured_only')->label('فقط ویژه‌ها')->default(true),
                    ]),
                ]),

            // ── Genres config ──
            Section::make('تنظیمات ژانرها')
                ->visible(fn ($get) => $get('type') === 'genres')
                ->schema([
                    Grid::make(3)->schema([
                        TextInput::make('config.limit')->label('تعداد')->numeric()->default(12)->minValue(1)->maxValue(30),
                        Select::make('config.columns')
                            ->label('تعداد ستون')
                            ->options(['3'=>'۳','4'=>'۴','6'=>'۶'])
                            ->default('6'),
                        Toggle::make('config.show_count')->label('نمایش تعداد آهنگ')->default(false),
                    ]),
                ]),

            // ── Artist spotlight config ──
            Section::make('تنظیمات هنرمند ویژه')
                ->visible(fn ($get) => $get('type') === 'artist_spotlight')
                ->schema([
                    Select::make('config.artist_id')
                        ->label('هنرمند')
                        ->options(fn () => \App\Models\Artist::where('verification_status','approved')->pluck('display_name','id')->toArray())
                        ->searchable()
                        ->required(),
                    Textarea::make('config.spotlight_text')->label('متن معرفی')->rows(3),
                ]),

            // ── Banner config ──
            Section::make('تنظیمات بنر')
                ->visible(fn ($get) => $get('type') === 'banner')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('config.banner_title')->label('عنوان بنر'),
                        TextInput::make('config.banner_url')->label('لینک بنر'),
                    ]),
                    FileUpload::make('config.banner_image')
                        ->label('تصویر بنر')
                        ->image()
                        ->disk('public')
                        ->directory('homepage')
                        ->required(),
                    Grid::make(2)->schema([
                        ColorPicker::make('config.banner_bg')->label('رنگ پس‌زمینه')->hexColor(),
                        TextInput::make('config.banner_btn_label')->label('متن دکمه'),
                    ]),
                ]),

            // ── Top charts config ──
            Section::make('تنظیمات چارت')
                ->visible(fn ($get) => $get('type') === 'top_charts')
                ->schema([
                    Grid::make(3)->schema([
                        TextInput::make('config.limit')->label('تعداد')->numeric()->default(10)->minValue(1)->maxValue(50),
                        Select::make('config.columns')
                            ->label('تعداد ستون')
                            ->options(['2' => '۲', '3' => '۳', '4' => '۴', '5' => '۵', '6' => '۶'])
                            ->default('6'),
                        Select::make('config.period')
                            ->label('بازه زمانی')
                            ->options(['7' => 'هفت روز', '30' => 'یک ماه', '90' => 'سه ماه', '365' => 'یک سال'])
                            ->default('30'),
                    ]),
                    Toggle::make('config.show_see_all')->label('نمایش دکمه «مشاهده همه»')->default(true),
                    TextInput::make('config.see_all_url')
                        ->label('لینک «مشاهده همه» (خالی = خودکار)')
                        ->placeholder('خودکار بر اساس نوع'),
                ]),

            // ── Custom tracks config ──
            Section::make('آیتم‌های دستی')
                ->visible(fn ($get) => $get('type') === 'custom_tracks')
                ->schema([
                    Grid::make(3)->schema([
                        Select::make('config.layout')
                            ->label('چیدمان')
                            ->options(['grid'=>'شبکه‌ای','list'=>'لیستی','scroll'=>'اسکرول افقی'])
                            ->default('grid'),
                        Select::make('config.columns')
                            ->label('تعداد ستون')
                            ->options(['2'=>'۲','3'=>'۳','4'=>'۴','5'=>'۵','6'=>'۶'])
                            ->default('6'),
                        Toggle::make('config.show_see_all')->label('دکمه مشاهده همه')->default(false),
                    ]),
                    \Filament\Schemas\Components\Section::make('آهنگ‌های انتخابی')->schema([
                        \Filament\Forms\Components\Repeater::make('config.track_ids')
                            ->label('آهنگ‌ها')
                            ->schema([
                                Select::make('id')
                                    ->label('آهنگ')
                                    ->options(fn () => \App\Models\Track::published()->with('artist')
                                        ->get()->mapWithKeys(fn($t) => [$t->id => $t->title . ' — ' . ($t->artist?->display_name ?? '')])->toArray())
                                    ->searchable()
                                    ->required(),
                            ])
                            ->columns(1)
                            ->addActionLabel('افزودن آهنگ')
                            ->collapsible(),
                    ])->collapsible(),
                    \Filament\Schemas\Components\Section::make('آلبوم‌های انتخابی')->schema([
                        \Filament\Forms\Components\Repeater::make('config.album_ids')
                            ->label('آلبوم‌ها')
                            ->schema([
                                Select::make('id')
                                    ->label('آلبوم')
                                    ->options(fn () => \App\Models\Album::published()->with('artist')
                                        ->get()->mapWithKeys(fn($a) => [$a->id => $a->title . ' — ' . ($a->artist?->display_name ?? '')])->toArray())
                                    ->searchable()
                                    ->required(),
                            ])
                            ->columns(1)
                            ->addActionLabel('افزودن آلبوم')
                            ->collapsible(),
                    ])->collapsible(),
                    \Filament\Schemas\Components\Section::make('پلی‌لیست‌های انتخابی')->schema([
                        \Filament\Forms\Components\Repeater::make('config.playlist_ids')
                            ->label('پلی‌لیست‌ها')
                            ->schema([
                                Select::make('id')
                                    ->label('پلی‌لیست')
                                    ->options(fn () => \App\Models\Playlist::public()
                                        ->get()->pluck('title', 'id')->toArray())
                                    ->searchable()
                                    ->required(),
                            ])
                            ->columns(1)
                            ->addActionLabel('افزودن پلی‌لیست')
                            ->collapsible(),
                    ])->collapsible(),
                ]),

            // ── Featured track (slider card) config ──
            Section::make('تنظیمات آهنگ ویژه')
                ->visible(fn ($get) => $get('type') === 'featured_track')
                ->schema([
                    Grid::make(2)->schema([
                        Select::make('config.sort_by')
                            ->label('نمایش بر اساس')
                            ->options([
                                'play_count'   => 'پرطرفدارترین',
                                'release_date' => 'جدیدترین',
                                'created_at'   => 'تازه‌ترین',
                                'manual'       => 'انتخاب دستی',
                            ])
                            ->default('play_count')
                            ->reactive(),
                        TextInput::make('config.limit')
                            ->label('تعداد آهنگ در چرخش')
                            ->numeric()->default(5)->minValue(2)->maxValue(20),
                    ]),
                    Select::make('config.genre_filter')
                        ->label('فیلتر ژانر')
                        ->options(fn () => \App\Models\Genre::active()->ordered()->pluck('name_fa', 'slug')->toArray())
                        ->multiple()->searchable()->placeholder('همه ژانرها'),
                    \Filament\Forms\Components\Repeater::make('config.manual_track_ids')
                        ->label('آهنگ‌های دستی')
                        ->visible(fn ($get) => $get('config.sort_by') === 'manual')
                        ->schema([
                            Select::make('id')
                                ->label('آهنگ')
                                ->options(fn () => \App\Models\Track::published()->with('artist')
                                    ->get()->mapWithKeys(fn($t) => [$t->id => $t->title . ' — ' . ($t->artist?->display_name ?? '')])->toArray())
                                ->searchable()->required(),
                        ])
                        ->addActionLabel('افزودن آهنگ')
                        ->collapsible(),
                    Grid::make(3)->schema([
                        Toggle::make('config.autoplay')->label('چرخش خودکار')->default(true),
                        TextInput::make('config.autoplay_interval')->label('فاصله (ثانیه)')->numeric()->default(5),
                        Toggle::make('config.show_play_btn')->label('دکمه پخش')->default(true),
                    ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title_fa')
                    ->label('عنوان')
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('type')
                    ->label('نوع')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match($state) {
                        'hero'               => '🎯 هیرو',
                        'track_shelf'        => '🎼 قفسه آهنگ‌ها',
                        'featured_artists'   => '🎤 هنرمندان',
                        'featured_playlists' => '🎵 پلی‌لیست‌ها',
                        'genres'             => '🎸 ژانر',
                        'latest_albums'      => '💿 آلبوم',
                        'top_charts'         => '📊 چارت',
                        'artist_spotlight'   => '⭐ اسپاتلایت',
                        'banner'             => '🖼️ بنر',
                        'custom_tracks'      => '🎼 دستی',
                        'featured_track'     => '🎵 آهنگ ویژه',
                        default              => $state,
                    })
                    ->color(fn ($state) => match($state) {
                        'hero'               => 'primary',
                        'trending'           => 'danger',
                        'top_charts'         => 'warning',
                        'banner'             => 'gray',
                        default              => 'success',
                    }),
                IconColumn::make('is_active')
                    ->label('فعال')
                    ->boolean(),
            ])
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->reorderRecordsTriggerAction(
                fn ($action) => $action->button()->label('مرتب‌سازی'),
            )
            ->actions([
                EditAction::make()->label('ویرایش'),
                DeleteAction::make()->label('حذف'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('هیچ بخشی تعریف نشده')
            ->emptyStateDescription('با کلیک روی «افزودن بخش» اولین ویجت صفحه اصلی را بسازید.')
            ->emptyStateIcon('heroicon-o-squares-2x2');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListHomepageSections::route('/'),
            'create' => Pages\CreateHomepageSection::route('/create'),
            'edit'   => Pages\EditHomepageSection::route('/{record}/edit'),
        ];
    }
}
