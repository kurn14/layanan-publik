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
                    ->label(__('Name'))
                    ->required(),
                TextInput::make('email')
                    ->label(__('Email Address'))
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at')
                    ->label(__('Email Verified At')),
                TextInput::make('password')
                    ->label(__('Password'))
                    ->password(),
                TextInput::make('id_number')
                    ->label(__('ID Number')),
                TextInput::make('phone')
                    ->label(__('Phone'))
                    ->tel(),
                TextInput::make('position')
                    ->label(__('Position')),
                TextInput::make('origin_institution')
                    ->label(__('Origin Institution')),
                Select::make('client_type')
                    ->label(__('Client Type'))
                    ->options(ClientType::class)
                    ->default('individual')
                    ->required(),
                Toggle::make('is_active')
                    ->label(__('Active Status'))
                    ->required(),

            ]);
    }
}
