<?php

namespace App\Filament\Resources\Facilities\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use App\Enums\BookingStatus;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BookingsRelationManager extends RelationManager
{
    protected static string $relationship = 'bookings';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->components([
                    Select::make('customer_id')
                        ->relationship('customer', 'name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->label('Pelanggan'),
                    TextInput::make('purpose')
                        ->required()
                        ->maxLength(255)
                        ->label('Tujuan Sewa'),
                    DatePicker::make('start_date')
                        ->required()
                        ->label('Tanggal Mulai'),
                    DatePicker::make('end_date')
                        ->required()
                        ->afterOrEqual('start_date')
                        ->label('Tanggal Selesai'),
                    TextInput::make('guest_count')
                        ->numeric()
                        ->label('Jumlah Tamu (Opsional)'),
                    TextInput::make('total_cost')
                        ->required()
                        ->numeric()
                        ->prefix('Rp')
                        ->label('Total Biaya'),
                    Select::make('status')
                        ->options(BookingStatus::class)
                        ->required()
                        ->default(BookingStatus::PENDING)
                        ->label('Status'),
                    TextInput::make('cancellation_fee')
                        ->numeric()
                        ->prefix('Rp')
                        ->default(0)
                        ->label('Biaya Pembatalan'),
                    Toggle::make('arrival_confirmed')
                        ->label('Kedatangan Dikonfirmasi')
                        ->columnSpanFull(),
                    Textarea::make('notes')
                        ->columnSpanFull()
                        ->label('Catatan Khusus'),
                ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('purpose')
            ->columns([
                TextColumn::make('customer.name')
                    ->label('Pelanggan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('purpose')
                    ->label('Tujuan Sewa')
                    ->searchable(),
                TextColumn::make('start_date')
                    ->label('Mulai')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('Selesai')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                TextColumn::make('total_cost')
                    ->label('Total Biaya')
                    ->money('IDR')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
