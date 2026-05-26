<?php

namespace App\Filament\Resources\CommissionRules;

use App\Filament\Resources\CommissionRules\Pages\CreateCommissionRule;
use App\Filament\Resources\CommissionRules\Pages\EditCommissionRule;
use App\Filament\Resources\CommissionRules\Pages\ListCommissionRules;
use App\Filament\Resources\CommissionRules\Schemas\CommissionRuleForm;
use App\Filament\Resources\CommissionRules\Tables\CommissionRulesTable;
use App\Models\CommissionRule;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Tables;
use Filament\Tables\Table;

class CommissionRuleResource extends Resource
{
    protected static ?string $model = CommissionRule::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-currency-dollar';
    protected static string|\UnitEnum|null $navigationGroup = 'مالی';
    protected static ?string $modelLabel = 'قانون کمیسیون';
    protected static ?string $pluralModelLabel = 'قوانین کمیسیون';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('اطلاعات قانون')->schema([
                TextInput::make('name')
                    ->label('نام قانون')
                    ->required()
                    ->placeholder('مثلاً: کمیسیون پیش‌فرض'),
                Select::make('type')
                    ->label('نوع اعمال')
                    ->options([
                        'global' => 'جهانی (همه)',
                        'genre'  => 'ژانر خاص',
                        'artist' => 'هنرمند خاص',
                    ])
                    ->live()
                    ->required(),
                Select::make('reference_id')
                    ->label('ژانر / هنرمند')
                    ->visible(fn($get) => in_array($get('type'), ['genre', 'artist']))
                    ->options(function ($get) {
                        if ($get('type') === 'genre') {
                            return \App\Models\Genre::active()->pluck('name_fa', 'id');
                        }
                        if ($get('type') === 'artist') {
                            return \App\Models\Artist::pluck('display_name', 'id');
                        }
                        return [];
                    })
                    ->searchable(),
            ])->columns(3),
            Section::make('نرخ کمیسیون')->schema([
                Select::make('commission_type')
                    ->label('نوع محاسبه')
                    ->options([
                        'percent' => 'درصدی',
                        'fixed'   => 'مبلغ ثابت (تومان)',
                    ])
                    ->required()
                    ->live(),
                TextInput::make('commission_value')
                    ->label(fn($get) => $get('commission_type') === 'fixed' ? 'مبلغ کمیسیون (تومان)' : 'درصد کمیسیون')
                    ->numeric()
                    ->required()
                    ->suffix(fn($get) => $get('commission_type') === 'fixed' ? 'تومان' : '%'),
                Toggle::make('is_active')
                    ->label('فعال')
                    ->default(true),
                Textarea::make('description')
                    ->label('توضیحات')
                    ->rows(2)
                    ->columnSpanFull(),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('نام')->searchable(),
                Tables\Columns\TextColumn::make('type')->label('نوع')
                    ->badge()
                    ->formatStateUsing(fn($s) => match($s) {
                        'global' => 'جهانی', 'genre' => 'ژانر', 'artist' => 'هنرمند', default => $s
                    })
                    ->color(fn($s) => match($s) {
                        'global' => 'info', 'genre' => 'warning', 'artist' => 'success', default => 'gray'
                    }),
                Tables\Columns\TextColumn::make('commission_type')->label('نحوه محاسبه')
                    ->formatStateUsing(fn($state) => $state === 'percent' ? 'درصدی' : 'ثابت'),
                Tables\Columns\TextColumn::make('effective_rate')
                    ->label('نرخ')
                    ->getStateUsing(fn($record) => $record->commission_type === 'percent'
                        ? $record->commission_value . '%'
                        : number_format((float)$record->commission_value) . ' ت'
                    ),
                Tables\Columns\IconColumn::make('is_active')->label('فعال')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->label('ایجاد')->dateTime('Y/m/d')->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                EditAction::make()->label('ویرایش'),
                DeleteAction::make()->label('حذف'),
            ])
            ->bulkActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCommissionRules::route('/'),
            'create' => CreateCommissionRule::route('/create'),
            'edit' => EditCommissionRule::route('/{record}/edit'),
        ];
    }
}
