<?php

namespace App\Filament\Resources\CommissionRules\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CommissionRuleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('type')
                    ->options(['global' => 'Global', 'genre' => 'Genre', 'artist' => 'Artist'])
                    ->default('global')
                    ->required(),
                TextInput::make('reference_id')
                    ->numeric()
                    ->default(null),
                Select::make('commission_type')
                    ->options(['percent' => 'Percent', 'fixed' => 'Fixed'])
                    ->default('percent')
                    ->required(),
                TextInput::make('commission_value')
                    ->required()
                    ->numeric()
                    ->default(20.0),
                Toggle::make('is_active')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
