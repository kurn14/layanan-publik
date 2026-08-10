<?php

namespace App\Filament\Resources\Trainings\Schemas;

use App\Enums\TrainingStatus;
use App\Enums\TrainingType;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TrainingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Main Training Information'))
                    ->components([
                        TextEntry::make('name')
                            ->label(__('Training Name'))
                            ->weight('bold')
                            ->size('lg')
                            ->columnSpanFull(),

                        Grid::make(2)
                            ->components([
                                TextEntry::make('type')
                                    ->label(__('Training Type'))
                                    ->badge()
                                    ->formatStateUsing(fn ($state) => $state instanceof TrainingType ? $state->label() : TrainingType::tryFrom($state)?->label() ?? $state)
                                    ->color(fn ($state) => match ($state instanceof TrainingType ? $state : TrainingType::tryFrom($state)) {
                                        TrainingType::TECHNICAL => 'primary',
                                        TrainingType::MANAGERIAL => 'warning',
                                        TrainingType::FUNCTIONAL => 'info',
                                        default => 'gray',
                                    }),

                                TextEntry::make('status')
                                    ->label(__('Training Status'))
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
                                    }),
                            ]),

                        TextEntry::make('description')
                            ->label(__('Training Description'))
                            ->placeholder(__('No description.'))
                            ->columnSpanFull(),

                        TextEntry::make('requirements')
                            ->label(__('Participant Requirements'))
                            ->placeholder(__('No specific requirements.'))
                            ->columnSpanFull(),
                    ]),

                Section::make(__('Schedule & Location'))
                    ->components([
                        Grid::make(3)
                            ->components([
                                TextEntry::make('start_date')
                                    ->label(__('Start Date'))
                                    ->date('d F Y'),

                                TextEntry::make('end_date')
                                    ->label(__('End Date'))
                                    ->date('d F Y'),

                                TextEntry::make('duration_days')
                                    ->label(__('Duration'))
                                    ->suffix(' ' . __('Days')),
                            ]),

                        TextEntry::make('location')
                            ->label(__('Location / Venue'))
                            ->columnSpanFull(),
                    ]),

                Section::make(__('Quota & Publication'))
                    ->components([
                        Grid::make(3)
                            ->components([
                                TextEntry::make('max_quota')
                                    ->label(__('Maximum Quota'))
                                    ->suffix(' ' . __('People')),

                                TextEntry::make('filled_quota')
                                    ->label(__('Filled Quota'))
                                    ->suffix(' ' . __('People')),

                                IconEntry::make('is_active')
                                    ->label(__('Publication Status'))
                                    ->boolean(),
                            ]),

                        KeyValueEntry::make('metadata')
                            ->label(__('Additional Data (Metadata)'))
                            ->columnSpanFull(),

                        Grid::make(2)
                            ->components([
                                TextEntry::make('created_at')
                                    ->label(__('Created At'))
                                    ->dateTime('d F Y H:i:s'),

                                TextEntry::make('updated_at')
                                    ->label(__('Last Updated'))
                                    ->dateTime('d F Y H:i:s'),
                            ]),
                    ]),
            ]);
    }
}
