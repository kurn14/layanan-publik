<?php

namespace App\Filament\Widgets;

use App\Models\FacilityBooking;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestFacilityBookingsWidget extends BaseWidget
{
    protected static ?string $heading = '10 Pemesanan Fasilitas Terakhir';
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                FacilityBooking::query()->latest()->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Pemesan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('facility.name')
                    ->label('Fasilitas'),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Tgl Mulai')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Tgl Selesai')
                    ->date(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->paginated(false);
    }
}
