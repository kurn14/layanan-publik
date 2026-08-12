<?php

namespace App\Filament\Widgets;

use App\Models\Registration;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestRegistrationsWidget extends BaseWidget
{
    protected static ?string $heading = '10 Pendaftar Pelatihan Terakhir';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Registration::query()->latest()->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('registration_code')
                    ->label('Kode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Peserta')
                    ->searchable(),
                Tables\Columns\TextColumn::make('training.name')
                    ->label('Pelatihan'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Daftar')
                    ->dateTime()
                    ->sortable(),
            ])
            ->paginated(false);
    }
}
