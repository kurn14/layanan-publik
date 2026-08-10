<?php

namespace App\Filament\Resources\Trainings\Tables;

use App\Enums\TrainingStatus;
use App\Enums\TrainingType;
use App\Models\Training;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class TrainingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Pelatihan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->wrap(),

                TextColumn::make('type')
                    ->label('Jenis')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state instanceof TrainingType ? $state->label() : TrainingType::tryFrom($state)?->label() ?? $state)
                    ->color(fn ($state) => match ($state instanceof TrainingType ? $state : TrainingType::tryFrom($state)) {
                        TrainingType::TECHNICAL => 'primary',
                        TrainingType::MANAGERIAL => 'warning',
                        TrainingType::FUNCTIONAL => 'info',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state instanceof TrainingStatus ? $state->label() : TrainingStatus::tryFrom($state)?->label() ?? $state)
                    ->color(fn ($state) => match ($state instanceof TrainingStatus ? $state : TrainingStatus::tryFrom($state)) {
                        TrainingStatus::DRAFT => 'gray',
                        TrainingStatus::OPEN => 'success',
                        TrainingStatus::FULL => 'danger',
                        TrainingStatus::ONGOING => 'warning',
                        TrainingStatus::COMPLETED => 'info',
                        TrainingStatus::CANCELLED => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('start_date')
                    ->label('Jadwal Pelaksanaan')
                    ->date('d M Y')
                    ->description(fn (Training $record) => $record->end_date ? 's.d. ' . $record->end_date->format('d M Y') : null)
                    ->sortable(),

                TextColumn::make('duration_days')
                    ->label('Durasi')
                    ->suffix(' hari')
                    ->alignCenter()
                    ->sortable(),

                TextColumn::make('filled_quota')
                    ->label('Kuota')
                    ->formatStateUsing(fn (Training $record) => "{$record->filled_quota} / {$record->max_quota}")
                    ->badge()
                    ->color(fn (Training $record) => $record->filled_quota >= $record->max_quota ? 'danger' : 'success')
                    ->alignCenter()
                    ->sortable(),

                TextColumn::make('location')
                    ->label('Lokasi')
                    ->limit(30)
                    ->tooltip(fn (Training $record) => $record->location)
                    ->searchable()
                    ->toggleable(),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->alignCenter()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('start_date', 'desc')
            ->filters([
                SelectFilter::make('type')
                    ->label('Jenis Pelatihan')
                    ->options(collect(TrainingType::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])),

                SelectFilter::make('status')
                    ->label('Status Pelatihan')
                    ->options(collect(TrainingStatus::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])),

                TernaryFilter::make('is_active')
                    ->label('Status Publikasi')
                    ->trueLabel('Hanya Pelatihan Aktif')
                    ->falseLabel('Pelatihan Nonaktif'),

                TrashedFilter::make()
                    ->label('Data Terhapus'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);
    }
}
