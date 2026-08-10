<?php

namespace App\Filament\Resources\Facilities\Schemas;

use App\Enums\FacilityType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class FacilityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('type')
                    ->options(FacilityType::class)
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('capacity')
                    ->numeric(),
                TextInput::make('price_per_day')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->required(),
                Repeater::make('photos')
                    ->relationship()
                    ->schema([
                        FileUpload::make('path')
                            ->label('Foto')
                            ->image()
                            ->required(),
                        TextInput::make('deskripsi')
                            ->label('Deskripsi'),
                    ])
                    ->orderColumn('sort')
                    ->defaultItems(1)
                    ->columnSpanFull(),
            ]);
    }
}
