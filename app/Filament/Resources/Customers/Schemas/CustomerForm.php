<?php

namespace App\Filament\Resources\Customers\Schemas;

use App\Enums\ClientType;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password(),
                TextInput::make('id_number'),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('position'),
                TextInput::make('origin_institution'),
                Select::make('client_type')
                    ->options(ClientType::class)
                    ->default('individual')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),

            ]);
    }
}
