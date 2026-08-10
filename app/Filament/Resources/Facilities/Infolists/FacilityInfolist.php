<?php

namespace App\Filament\Resources\Facilities\Infolists;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FacilityInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Facility Details'))
                    ->components([
                        Grid::make(2)->components([
                            TextEntry::make('name')->label(__('Facility Name')),
                            TextEntry::make('type')->badge()->label(__('Type')),
                            TextEntry::make('capacity')->label(__('Capacity')),
                            TextEntry::make('price_per_day')->money('IDR')->label(__('Price per Day')),
                            TextEntry::make('is_active')
                                ->label(__('Active Status'))
                                ->badge()
                                ->state(fn ($record) => $record->is_active ? __('Active') : __('Inactive'))
                                ->color(fn ($record) => $record->is_active ? 'success' : 'danger'),
                        ]),
                    ]),
                Section::make(__('Description'))
                    ->components([
                        TextEntry::make('description')->html()->label(''),
                    ]),
                Section::make(__('Facility Photos'))
                    ->components([
                        RepeatableEntry::make('photos')
                            ->label('')
                            ->schema([
                                ImageEntry::make('path')->label(__('Photo')),
                                TextEntry::make('description')->label(__('Description')),
                            ])
                            ->columns(2)
                    ]),
            ]);
    }
}
