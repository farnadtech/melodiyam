<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArtistApplicationResource\Pages;
use App\Helpers\Jalali;
use App\Models\Artist;
use App\Models\ArtistApplication;
use App\Models\ArtistApplicationField;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class ArtistApplicationResource extends Resource
{
    protected static ?string $model = ArtistApplication::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-plus';
    protected static string|\UnitEnum|null $navigationGroup = 'مدیریت';
    protected static ?string $modelLabel = 'درخواست هنرمند';
    protected static ?string $pluralModelLabel = 'درخواست‌های هنرمند';
    protected static ?int $navigationSort = 5;

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('status', 'pending')->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Schema $form): Schema
    {
        return $form->schema([
            \Filament\Schemas\Components\Section::make('اطلاعات متقاضی')->schema([
                Forms\Components\Placeholder::make('user_info')
                    ->label('کاربر')
                    ->content(fn($record) => $record?->user
                        ? new \Illuminate\Support\HtmlString(
                            '<a href="' . e(route('filament.admin.resources.users.edit', $record->user)) . '" target="_blank" class="text-primary-600 underline font-medium">'
                            . e($record->user->name) . '</a>'
                            . ' — ' . e($record->user->email)
                            . ($record->user->phone ? ' — ' . e($record->user->phone) : '')
                        )
                        : '—'
                    ),
                Forms\Components\Placeholder::make('submitted_at')
                    ->label('تاریخ ثبت')
                    ->content(fn($record) => $record?->created_at
                        ? Jalali::format($record->created_at, 'Y/m/d H:i')
                        : '—'
                    ),
            ])->columns(2),

            \Filament\Schemas\Components\Section::make('اطلاعات ارسال‌شده')->schema([
                Forms\Components\Placeholder::make('application_data')
                    ->label('')
                    ->content(function ($record) {
                        if (!$record?->data) return '—';
                        $fields = ArtistApplicationField::orderBy('sort_order')->pluck('label', 'key');
                        $html = '<div class="space-y-3">';
                        $fieldTypes = ArtistApplicationField::orderBy('sort_order')->pluck('type', 'key');
                        foreach ($record->data as $key => $value) {
                            $label     = $fields[$key] ?? $key;
                            $fieldType = $fieldTypes[$key] ?? null;

                            if ($fieldType === 'file' || ($fieldType === null && is_string($value) && preg_match('#^[\w\-/]+\.\w{2,5}$#', $value) && !str_contains($value, ' '))) {
                                // فایل آپلودشده
                                $url = asset('storage/' . $value);
                                $html .= '<div><span class="font-medium text-sm">' . e($label) . ':</span> '
                                    . '<a href="' . e($url) . '" target="_blank" class="text-primary-600 underline text-sm">مشاهده فایل</a></div>';
                            } elseif ($fieldType === 'checkbox' || is_bool($value)) {
                                // چک‌باکس
                                $html .= '<div><span class="font-medium text-sm">' . e($label) . ':</span> <span class="text-sm">' . ($value ? '✓ بله' : '✗ خیر') . '</span></div>';
                            } elseif (is_array($value)) {
                                $html .= '<div><span class="font-medium text-sm">' . e($label) . ':</span> <span class="text-sm">' . e(implode('، ', $value)) . '</span></div>';
                            } else {
                                $html .= '<div><span class="font-medium text-sm">' . e($label) . ':</span> <span class="text-sm">' . e($value) . '</span></div>';
                            }
                        }
                        $html .= '</div>';
                        return new \Illuminate\Support\HtmlString($html);
                    })
                    ->columnSpanFull(),
            ]),

            \Filament\Schemas\Components\Section::make('بررسی ادمین')->schema([
                Forms\Components\Select::make('status')
                    ->label('وضعیت')
                    ->options(ArtistApplication::$statuses)
                    ->required()
                    ->live(),
                Forms\Components\Textarea::make('admin_note')
                    ->label('یادداشت (نمایش داده می‌شود به کاربر)')
                    ->rows(3)
                    ->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('#')->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('نام کاربر')->searchable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('ایمیل')->searchable()->limit(25),
                Tables\Columns\TextColumn::make('status')
                    ->label('وضعیت')->badge()
                    ->color(fn($state) => match($state) {
                        'pending'   => 'warning',
                        'reviewing' => 'primary',
                        'approved'  => 'success',
                        'rejected'  => 'danger',
                        default     => 'gray',
                    })
                    ->formatStateUsing(fn($state) => ArtistApplication::$statuses[$state] ?? $state),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ')
                    ->formatStateUsing(fn($state) => $state ? Jalali::format($state, 'Y/m/d') : '-')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('وضعیت')
                    ->options(ArtistApplication::$statuses),
            ])
            ->actions([\Filament\Actions\EditAction::make()->label('بررسی')])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArtistApplications::route('/'),
            'edit'  => Pages\EditArtistApplication::route('/{record}/edit'),
        ];
    }
}
