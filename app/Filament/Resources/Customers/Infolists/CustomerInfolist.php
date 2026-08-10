<?php

namespace App\Filament\Resources\Customers\Infolists;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CustomerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Customer Details')
                    ->components([
                        Grid::make(2)->components([
                            TextEntry::make('name')->label('Nama'),
                            TextEntry::make('email')->label('Email'),
                            TextEntry::make('phone')->label('Telepon'),
                            TextEntry::make('id_number')->label('Nomor Identitas'),
                            TextEntry::make('position')->label('Jabatan'),
                            TextEntry::make('origin_institution')->label('Asal Instansi'),
                            TextEntry::make('client_type')->badge()->label('Tipe Klien'),
                            TextEntry::make('is_active')
                                ->label('Status Aktif')
                                ->badge()
                                ->state(fn ($record) => $record->is_active ? 'Aktif' : 'Non-aktif')
                                ->color(fn ($record) => $record->is_active ? 'success' : 'danger'),
                        ]),
                    ]),
            ]);
    }
}
