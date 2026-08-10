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
                Section::make(__('Customer Details'))
                    ->components([
                        Grid::make(2)->components([
                            TextEntry::make('name')->label(__('Name')),
                            TextEntry::make('email')->label(__('Email')),
                            TextEntry::make('phone')->label(__('Phone')),
                            TextEntry::make('id_number')->label(__('ID Number')),
                            TextEntry::make('position')->label(__('Position')),
                            TextEntry::make('origin_institution')->label(__('Origin Institution')),
                            TextEntry::make('client_type')->badge()->label(__('Client Type')),
                            TextEntry::make('is_active')
                                ->label(__('Active Status'))
                                ->badge()
                                ->state(fn ($record) => $record->is_active ? __('Active') : __('Inactive'))
                                ->color(fn ($record) => $record->is_active ? 'success' : 'danger'),
                        ]),
                    ]),
            ]);
    }
}
