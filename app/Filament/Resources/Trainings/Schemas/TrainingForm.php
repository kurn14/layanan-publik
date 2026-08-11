<?php

namespace App\Filament\Resources\Trainings\Schemas;

use App\Enums\TrainingStatus;
use App\Enums\TrainingType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TrainingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Main Training Information'))
                    ->description(__('Details of name, training type classification, and material description.'))
                    ->components([
                        TextInput::make('name')
                            ->label(__('Training Name'))
                            ->placeholder(__('Example: Investigative Audit & PKKN Training'))
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Grid::make(2)
                            ->components([
                                Select::make('type')
                                    ->label(__('Training Type'))
                                    ->options(collect(TrainingType::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()]))
                                    ->required()
                                    ->native(false),

                                Select::make('status')
                                    ->label(__('Training Status'))
                                    ->options(collect(TrainingStatus::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()]))
                                    ->default(TrainingStatus::DRAFT->value)
                                    ->required()
                                    ->native(false),
                            ]),

                        Textarea::make('description')
                            ->label(__('Training Description'))
                            ->placeholder(__('Write a summary of the material and learning objectives...'))
                            ->rows(3)
                            ->columnSpanFull(),

                        Textarea::make('requirements')
                            ->label(__('Participant Requirements'))
                            ->placeholder(__('Example: Minimum education level, task background, etc.'))
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Section::make(__('Schedule & Location'))
                    ->description(__('Execution time, duration in days, and training venue.'))
                    ->components([
                        Grid::make(3)
                            ->components([
                                DatePicker::make('start_date')
                                    ->label(__('Start Date'))
                                    ->required()
                                    ->native(false),

                                DatePicker::make('end_date')
                                    ->label(__('End Date'))
                                    ->required()
                                    ->afterOrEqual('start_date')
                                    ->native(false),

                                TextInput::make('duration_days')
                                    ->label(__('Duration (Days)'))
                                    ->numeric()
                                    ->minValue(1)
                                    ->suffix(__('Days'))
                                    ->required(),
                            ]),

                        TextInput::make('location')
                            ->label(__('Location / Venue'))
                            ->placeholder(__('Example: BPKP DIY Training Building — Malioboro Classroom'))
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ]),

                Section::make(__('Quota & Configuration'))
                    ->description(__('Registration quota limits and additional training data.'))
                    ->components([
                        Grid::make(3)
                            ->components([
                                TextInput::make('max_quota')
                                    ->label(__('Maximum Quota'))
                                    ->numeric()
                                    ->default(50)
                                    ->minValue(1)
                                    ->required(),

                                TextInput::make('filled_quota')
                                    ->label(__('Filled Quota'))
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->required(),

                                Toggle::make('is_active')
                                    ->label(__('Active Status'))
                                    ->default(true)
                                    ->inline(false)
                                    ->helperText(__('Show training on public portal.')),
                            ]),

                        FileUpload::make('image')
                            ->label(__('Poster / Image'))
                            ->image()
                            ->directory('trainings')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
