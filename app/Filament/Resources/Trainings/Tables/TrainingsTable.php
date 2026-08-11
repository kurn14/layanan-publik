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
use Filament\Tables\Columns\ImageColumn;
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
                ImageColumn::make('image')
                    ->label(__('Image'))
                    ->circular(),

                TextColumn::make('name')
                    ->label(__('Training Name'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->wrap(),

                TextColumn::make('type')
                    ->label(__('Type'))
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
                    ->label(__('Status'))
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
                    ->label(__('Execution Schedule'))
                    ->date('d M Y')
                    ->description(fn (Training $record) => $record->end_date ? __('until') . ' ' . $record->end_date->format('d M Y') : null)
                    ->sortable(),

                TextColumn::make('duration_days')
                    ->label(__('Duration'))
                    ->suffix(' ' . __('days'))
                    ->alignCenter()
                    ->sortable(),

                TextColumn::make('filled_quota')
                    ->label(__('Quota'))
                    ->formatStateUsing(fn (Training $record) => "{$record->filled_quota} / {$record->max_quota}")
                    ->badge()
                    ->color(fn (Training $record) => $record->filled_quota >= $record->max_quota ? 'danger' : 'success')
                    ->alignCenter()
                    ->sortable(),

                TextColumn::make('location')
                    ->label(__('Location'))
                    ->limit(30)
                    ->tooltip(fn (Training $record) => $record->location)
                    ->searchable()
                    ->toggleable(),

                IconColumn::make('is_active')
                    ->label(__('Active'))
                    ->boolean()
                    ->alignCenter()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('start_date', 'desc')
            ->filters([
                SelectFilter::make('type')
                    ->label(__('Training Type'))
                    ->options(collect(TrainingType::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])),

                SelectFilter::make('status')
                    ->label(__('Training Status'))
                    ->options(collect(TrainingStatus::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])),

                TernaryFilter::make('is_active')
                    ->label(__('Publication Status'))
                    ->trueLabel(__('Active Training Only'))
                    ->falseLabel(__('Inactive Training')),

                TrashedFilter::make()
                    ->label(__('Deleted Data')),
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
