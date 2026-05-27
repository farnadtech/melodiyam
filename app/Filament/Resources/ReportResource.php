<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Helpers\Jalali;
use App\Models\Album;
use App\Models\Report;
use App\Models\Track;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-flag';
    protected static string|\UnitEnum|null $navigationGroup = 'مدیریت';
    protected static ?string $modelLabel = 'شکایت';
    protected static ?string $pluralModelLabel = 'شکایات';
    protected static ?int $navigationSort = 10;

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('status', 'pending')->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    protected static function getContentInfo(Report $record): array
    {
        $label = match($record->reportable_type) {
            'App\\Models\\Track' => 'آهنگ',
            'App\\Models\\Album' => 'آلبوم',
            default => $record->reportable_type,
        };
        $title = '—';
        $url   = null;

        if ($record->reportable_type === 'App\\Models\\Track') {
            $item = Track::withTrashed()->find($record->reportable_id);
            if ($item) {
                $title = $item->title;
                $url   = route('filament.admin.resources.tracks.edit', $item);
            }
        } elseif ($record->reportable_type === 'App\\Models\\Album') {
            $item = Album::withTrashed()->find($record->reportable_id);
            if ($item) {
                $title = $item->title;
                $url   = route('filament.admin.resources.albums.edit', $item);
            }
        }

        return [$label, $title, $url];
    }

    public static function form(Schema $form): Schema
    {
        return $form->schema([
            \Filament\Schemas\Components\Section::make('اطلاعات کاربر گزارش‌دهنده')->schema([
                Forms\Components\Placeholder::make('reporter_name')
                    ->label('نام کاربر')
                    ->content(fn($record) => $record?->user
                        ? new \Illuminate\Support\HtmlString(
                            '<a href="' . e(route('filament.admin.resources.users.edit', $record->user)) . '" target="_blank" class="text-primary-600 underline font-medium">'
                            . e($record->user->name) . '</a>'
                        )
                        : '—'
                    ),
                Forms\Components\Placeholder::make('reporter_email')
                    ->label('ایمیل')
                    ->content(fn($record) => $record?->user?->email ?? '—'),
                Forms\Components\Placeholder::make('reporter_phone')
                    ->label('شماره موبایل')
                    ->content(fn($record) => $record?->user?->phone ?? '—'),
                Forms\Components\Placeholder::make('report_date')
                    ->label('تاریخ گزارش')
                    ->content(fn($record) => $record?->created_at
                        ? Jalali::format($record->created_at, 'Y/m/d H:i')
                        : '—'
                    ),
            ])->columns(2),

            \Filament\Schemas\Components\Section::make('محتوای گزارش‌شده')->schema([
                Forms\Components\TextInput::make('reportable_type')
                    ->label('نوع محتوا')
                    ->formatStateUsing(fn($state) => match($state) {
                        'App\\Models\\Track' => 'آهنگ',
                        'App\\Models\\Album' => 'آلبوم',
                        default => $state,
                    })->disabled(),
                Forms\Components\TextInput::make('reportable_id')
                    ->label('شناسه')->disabled(),
                Forms\Components\TextInput::make('reason')
                    ->label('دلیل گزارش')
                    ->formatStateUsing(fn($state) => Report::$reasons[$state] ?? $state)
                    ->disabled(),
                Forms\Components\Placeholder::make('content_link')
                    ->label('لینک محتوا')
                    ->content(function ($record) {
                        if (!$record) return '—';
                        [, $title, $url] = static::getContentInfo($record);
                        if ($url) {
                            return new \Illuminate\Support\HtmlString(
                                '<a href="' . e($url) . '" target="_blank" class="text-primary-600 underline">' . e($title) . '</a>'
                            );
                        }
                        return $title;
                    }),
                Forms\Components\Textarea::make('description')
                    ->label('توضیحات کاربر')->disabled()->rows(4)->columnSpanFull(),
            ])->columns(2),

            \Filament\Schemas\Components\Section::make('بررسی ادمین')->schema([
                Forms\Components\Select::make('status')
                    ->label('وضعیت')
                    ->options(Report::$statuses)->required(),
                Forms\Components\Textarea::make('admin_note')
                    ->label('یادداشت ادمین (نمایش داده می‌شود به کاربر)')
                    ->rows(3)->columnSpanFull(),
            ])->columns(1),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('#')->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('کاربر')->searchable()->limit(20),
                Tables\Columns\TextColumn::make('reportable_type')
                    ->label('نوع')
                    ->formatStateUsing(fn($state) => match($state) {
                        'App\\Models\\Track' => '🎵 آهنگ',
                        'App\\Models\\Album' => '💿 آلبوم',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('content_title')
                    ->label('محتوا')
                    ->getStateUsing(function ($record) {
                        if ($record->reportable_type === 'App\\Models\\Track') {
                            $item = Track::withTrashed()->find($record->reportable_id);
                        } elseif ($record->reportable_type === 'App\\Models\\Album') {
                            $item = Album::withTrashed()->find($record->reportable_id);
                        } else {
                            $item = null;
                        }
                        return $item ? $item->title : '(حذف شده #' . $record->reportable_id . ')';
                    })
                    ->url(function ($record) {
                        if ($record->reportable_type === 'App\\Models\\Track') {
                            $item = Track::withTrashed()->find($record->reportable_id);
                            return $item ? route('filament.admin.resources.tracks.edit', $item) : null;
                        } elseif ($record->reportable_type === 'App\\Models\\Album') {
                            $item = Album::withTrashed()->find($record->reportable_id);
                            return $item ? route('filament.admin.resources.albums.edit', $item) : null;
                        }
                        return null;
                    })
                    ->openUrlInNewTab()
                    ->limit(30),
                Tables\Columns\TextColumn::make('reason')
                    ->label('دلیل')
                    ->formatStateUsing(fn($state) => Report::$reasons[$state] ?? $state),
                Tables\Columns\TextColumn::make('status')
                    ->label('وضعیت')
                    ->badge()
                    ->color(fn($state) => match($state) {
                        'pending'  => 'warning',
                        'reviewed' => 'primary',
                        'resolved' => 'success',
                        'rejected' => 'danger',
                        default    => 'gray',
                    })
                    ->formatStateUsing(fn($state) => Report::$statuses[$state] ?? $state),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ')
                    ->formatStateUsing(fn($state) => $state ? Jalali::format($state, 'Y/m/d') : '-')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->label('وضعیت')
                    ->options(Report::$statuses),
                Tables\Filters\SelectFilter::make('reason')->label('دلیل')
                    ->options(Report::$reasons),
                Tables\Filters\SelectFilter::make('reportable_type')->label('نوع محتوا')
                    ->options([
                        'App\\Models\\Track' => 'آهنگ',
                        'App\\Models\\Album' => 'آلبوم',
                    ]),
            ])
            ->actions([\Filament\Actions\EditAction::make()])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
            'edit'  => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
