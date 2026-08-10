<?php

namespace App\Filament\Resources\Facilities\Schemas;

use App\Enums\FacilityType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
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
                    ->label(__('Name'))
                    ->required(),
                Select::make('type')
                    ->label(__('Type'))
                    ->options(FacilityType::class)
                    ->required(),
                RichEditor::make('description')
                    ->label(__('Description'))
                    ->columnSpanFull(),
                TextInput::make('capacity')
                    ->label(__('Capacity'))
                    ->numeric(),
                TextInput::make('price_per_day')
                    ->label(__('Price per Day'))
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->label(__('Active Status'))
                    ->required(),
                Repeater::make('photos')
                    ->label(__('Photos'))
                    ->relationship()
                    ->schema([
                        FileUpload::make('path')
                            ->label(__('Photo'))
                            ->image()
                            ->imageEditor()
                            ->required(),
                        TextInput::make('description')
                            ->label(__('Description')),
                    ])
                    ->orderColumn('sort')
                    ->defaultItems(1)
                    ->columnSpanFull(),
            ]);
    }
}
