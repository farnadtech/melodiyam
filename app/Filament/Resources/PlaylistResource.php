<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlaylistResource\Pages;
use App\Models\Playlist;
use App\Models\Track;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class PlaylistResource extends Resource
{
    protected static ?string $model = Playlist::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-queue-list';
    protected static string | \UnitEnum | null $navigationGroup = 'محتوا';
    protected static ?string $modelLabel = 'پلی‌لیست';
    protected static ?string $pluralModelLabel = 'پلی‌لیست‌ها';
    protected static ?int $navigationSort = 4;

    public static function form(Schema $form): Schema
    {
        return $form->schema([
            \Filament\Schemas\Components\Section::make('اطلاعات پلی‌لیست')->schema([
                Forms\Components\TextInput::make('title')
                    ->label('عنوان')->required()->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\Textarea::make('description')
                    ->label('توضیحات')->rows(3),
                Forms\Components\FileUpload::make('cover_image')
                    ->label('تصویر کاور')->image()->directory('playlists')->disk('public')->visibility('public'),
                Forms\Components\Select::make('visibility')
                    ->label('دسترسی')
                    ->options(['public' => 'عمومی', 'private' => 'خصوصی'])->required()->default('public'),
            ])->columns(2),

            \Filament\Schemas\Components\Section::make('⭐ تنظیمات ادمین')
                ->description('پلی‌لیست‌های ادمین جداگانه از پلی‌لیست کاربران نمایش داده می‌شوند.')
                ->schema([
                    Forms\Components\Toggle::make('is_system')
                        ->label('پلی‌لیست ادمین (جدا از پلی‌لیست کاربران)')
                        ->helperText('فعال کنید تا این پلی‌لیست فقط در سکشن ادمین نمایش داده شود و در لیست کاربران نیاید.')
                        ->default(true)
                        ->onColor('warning')
                        ->offColor('gray'),
                    Forms\Components\Toggle::make('is_featured')
                        ->label('نمایش در صدر صفحه (Featured)')
                        ->helperText('فعال کنید تا با نشان طلایی در بالای صفحه پلی‌لیست‌ها نمایش داده شود.')
                        ->default(true)
                        ->onColor('warning')
                        ->offColor('gray'),
                ])->columns(2),

            \Filament\Schemas\Components\Section::make('آهنگ‌ها')->schema([
                Forms\Components\Select::make('track_ids')
                    ->label('آهنگ‌ها')
                    ->multiple()
                    ->searchable()
                    ->default(fn($record) => $record?->tracks->pluck('id')->toArray() ?? [])
                    ->getSearchResultsUsing(function (string $search) {
                        return Track::with('artist')
                            ->where(function ($q) use ($search) {
                                $q->where('title', 'like', "%{$search}%")
                                  ->orWhereHas('artist', fn($q2) => $q2->where('display_name', 'like', "%{$search}%"));
                            })
                            ->limit(30)
                            ->get()
                            ->mapWithKeys(fn(Track $track) => [
                                $track->id => $track->title . '  ·  🎤 ' . ($track->artist->display_name ?? '—'),
                            ]);
                    })
                    ->getOptionLabelUsing(function ($value) {
                        $track = Track::with('artist')->find($value);
                        return $track ? $track->title . '  ·  🎤 ' . ($track->artist->display_name ?? '—') : $value;
                    })
                    ->getOptionLabelsUsing(function (array $values) {
                        return Track::with('artist')
                            ->whereIn('id', $values)
                            ->get()
                            ->mapWithKeys(fn(Track $track) => [
                                $track->id => $track->title . '  ·  🎤 ' . ($track->artist->display_name ?? '—'),
                            ]);
                    })
                    ->dehydrated(false),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')->label('کاور')->square()->disk('public'),
                Tables\Columns\TextColumn::make('title')->label('عنوان')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('user.name')->label('سازنده')->searchable(),
                Tables\Columns\TextColumn::make('tracks_count')->label('آهنگ')
                    ->counts('tracks')->numeric()->sortable(),
                Tables\Columns\BadgeColumn::make('visibility')->label('دسترسی')
                    ->formatStateUsing(fn ($state) => match($state) {
                        'public' => 'عمومی',
                        'private' => 'خصوصی',
                        default => $state,
                    })
                    ->colors(['success' => 'public', 'gray' => 'private']),
                Tables\Columns\IconColumn::make('is_featured')->label('ویژه ادمین')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->label('تاریخ')->date('Y/m/d')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('visibility')
                    ->options(['public' => 'عمومی', 'private' => 'خصوصی']),
                Tables\Filters\TernaryFilter::make('is_featured')->label('ویژه ادمین'),
            ])
            ->actions([\Filament\Actions\EditAction::make(), \Filament\Actions\DeleteAction::make()])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlaylists::route('/'),
            'create' => Pages\CreatePlaylist::route('/create'),
            'edit' => Pages\EditPlaylist::route('/{record}/edit'),
        ];
    }
}
