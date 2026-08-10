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
                Section::make('Facility Details')
                    ->components([
                        Grid::make(2)->components([
                            TextEntry::make('name')->label('Nama Fasilitas'),
                            TextEntry::make('type')->badge()->label('Tipe'),
                            TextEntry::make('capacity')->label('Kapasitas'),
                            TextEntry::make('price_per_day')->money('IDR')->label('Harga per Hari'),
                            TextEntry::make('is_active')
                                ->label('Status Aktif')
                                ->badge()
                                ->state(fn ($record) => $record->is_active ? 'Aktif' : 'Non-aktif')
                                ->color(fn ($record) => $record->is_active ? 'success' : 'danger'),
                        ]),
                    ]),
                Section::make('Deskripsi')
                    ->components([
                        TextEntry::make('description')->html()->label(''),
                    ]),
                Section::make('Foto Fasilitas')
                    ->components([
                        RepeatableEntry::make('photos')
                            ->label('')
                            ->schema([
                                ImageEntry::make('path')->label('Foto'),
                                TextEntry::make('description')->label('Deskripsi'),
                            ])
                            ->columns(2)
                    ]),
            ]);
    }
}
