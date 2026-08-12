<?php

namespace App\Filament\Resources\Employees\Schemas;

use App\Enums\EmployeeRole;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class EmployeeForm
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
                    ->password()
                    ->required(),
                Select::make('roles')
                    ->label(__('Role'))
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->required(),
                TextInput::make('phone')
                    ->label(__('Phone'))
                    ->tel(),
                Toggle::make('is_active')
                    ->label(__('Active Status'))
                    ->required(),


            ]);
    }
}
