<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('subscription_id')
                    ->relationship('subscription', 'id')
                    ->default(null),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                TextInput::make('tax_amount')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('fee_amount')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('gateway')
                    ->required()
                    ->default('zarinpal'),
                TextInput::make('payment_type')
                    ->required()
                    ->default('subscription'),
                TextInput::make('authority')
                    ->default(null),
                TextInput::make('ref_id')
                    ->default(null),
                Select::make('status')
                    ->options(['pending' => 'Pending', 'paid' => 'Paid', 'failed' => 'Failed', 'refunded' => 'Refunded'])
                    ->default('pending')
                    ->required(),
                TextInput::make('description')
                    ->default(null),
                Textarea::make('callback_url')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('mobile')
                    ->default(null),
                Textarea::make('gateway_response')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('payable_type')
                    ->default(null),
                TextInput::make('payable_id')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
