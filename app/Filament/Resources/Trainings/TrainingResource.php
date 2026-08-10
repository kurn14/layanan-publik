<?php

namespace App\Filament\Resources\Trainings;

use App\Enums\TrainingStatus;
use App\Filament\Resources\Trainings\Pages\CreateTraining;
use App\Filament\Resources\Trainings\Pages\EditTraining;
use App\Filament\Resources\Trainings\Pages\ListTrainings;
use App\Filament\Resources\Trainings\Pages\ViewTraining;
use App\Filament\Resources\Trainings\Schemas\TrainingForm;
use App\Filament\Resources\Trainings\Schemas\TrainingInfolist;
use App\Filament\Resources\Trainings\Tables\TrainingsTable;
use App\Models\Training;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;

class TrainingResource extends Resource
{
    use Translatable;
    protected static ?string $model = Training::class;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return __('Training');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Training Data');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Training Services');
    }

    protected static ?int $navigationSort = 1;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::AcademicCap;

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('status', TrainingStatus::OPEN)->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }

    public static function form(Schema $schema): Schema
    {
        return TrainingForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TrainingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TrainingsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTrainings::route('/'),
            'create' => CreateTraining::route('/create'),
            'view' => ViewTraining::route('/{record}'),
            'edit' => EditTraining::route('/{record}/edit'),
        ];
    }
}
