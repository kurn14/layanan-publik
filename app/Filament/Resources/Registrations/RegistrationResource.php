<?php

namespace App\Filament\Resources\Registrations;

use App\Enums\GraduationStatus;
use App\Enums\RegistrationStatus;
use App\Filament\Resources\Registrations\Pages\CreateRegistration;
use App\Filament\Resources\Registrations\Pages\EditRegistration;
use App\Filament\Resources\Registrations\Pages\ListRegistrations;
use App\Filament\Resources\Registrations\Pages\ViewRegistration;
use App\Filament\Resources\Registrations\RelationManagers\AttendancesRelationManager;
use App\Filament\Resources\Registrations\RelationManagers\CertificateRelationManager;
use App\Models\Registration;
use App\Services\CertificateService;
use App\Services\InvoiceService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class RegistrationResource extends Resource
{
    protected static ?string $model = Registration::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ClipboardDocumentList;

    public static function getModelLabel(): string
    {
        return __('Registration');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Registrations');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Training Services');
    }

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('status', RegistrationStatus::PENDING)->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('Registration Data'))->components([
                Grid::make(2)->components([
                    TextInput::make('registration_code')
                        ->label(__('Registration Code'))
                        ->disabled()
                        ->dehydrated(false),
                    Select::make('training_id')
                        ->relationship('training', 'name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->label(__('Training')),
                    Select::make('customer_id')
                        ->relationship('customer', 'name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->label(__('Customer')),
                    Select::make('status')
                        ->options(RegistrationStatus::class)
                        ->required()
                        ->default(RegistrationStatus::PENDING)
                        ->label(__('Status')),
                    Select::make('graduation_status')
                        ->options(GraduationStatus::class)
                        ->default(GraduationStatus::NOT_ASSESSED)
                        ->label(__('Graduation Status')),
                    Select::make('verified_by')
                        ->relationship('verifier', 'name')
                        ->searchable()
                        ->preload()
                        ->label(__('Verified By')),
                    DateTimePicker::make('confirmed_at')
                        ->label(__('Confirmed At')),
                    Select::make('confirmed_via')
                        ->options(\App\Enums\ConfirmationChannel::class)
                        ->label(__('Confirmed Via')),
                ]),
                Textarea::make('notes')
                    ->label(__('Customer Notes'))
                    ->columnSpanFull(),
                Textarea::make('operator_notes')
                    ->label(__('Operator Notes'))
                    ->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('registration_code')
                    ->label(__('Code'))
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                TextColumn::make('customer.name')
                    ->label(__('Customer'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('training.name')
                    ->label(__('Training'))
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('graduation_status')
                    ->label(__('Graduation'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('Registered'))
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options(RegistrationStatus::class)
                    ->label(__('Status')),
                SelectFilter::make('graduation_status')
                    ->options(GraduationStatus::class)
                    ->label(__('Graduation')),
            ])
            ->recordActions([
                \Filament\Actions\ViewAction::make(),
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\Action::make('confirm')
                    ->label(__('Confirm'))
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Registration $record) => $record->status === RegistrationStatus::PENDING)
                    ->action(function (Registration $record) {
                        $record->update([
                            'status' => RegistrationStatus::CONFIRMED,
                            'confirmed_at' => now(),
                            'confirmed_via' => \App\Enums\ConfirmationChannel::SYSTEM,
                        ]);
                        // Auto-generate invoice
                        InvoiceService::createForRegistration($record);
                        Notification::make()->title('Registrasi dikonfirmasi & invoice dibuat.')->success()->send();
                    }),
                \Filament\Actions\Action::make('reject')
                    ->label(__('Reject'))
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Registration $record) => $record->status === RegistrationStatus::PENDING)
                    ->action(function (Registration $record) {
                        $record->update(['status' => RegistrationStatus::REJECTED]);
                        Notification::make()->title('Registrasi ditolak.')->warning()->send();
                    }),
                \Filament\Actions\Action::make('set_passed')
                    ->label(__('Set Passed'))
                    ->icon('heroicon-o-academic-cap')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Registration $record) => $record->status === RegistrationStatus::CONFIRMED && $record->graduation_status === GraduationStatus::NOT_ASSESSED)
                    ->action(function (Registration $record) {
                        $record->update(['graduation_status' => GraduationStatus::PASSED]);
                        CertificateService::createForRegistration($record);
                        Notification::make()->title('Peserta dinyatakan lulus & sertifikat digenerate.')->success()->send();
                    }),
                \Filament\Actions\Action::make('set_failed')
                    ->label(__('Set Failed'))
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Registration $record) => $record->status === RegistrationStatus::CONFIRMED && $record->graduation_status === GraduationStatus::NOT_ASSESSED)
                    ->action(function (Registration $record) {
                        $record->update(['graduation_status' => GraduationStatus::FAILED]);
                        Notification::make()->title('Peserta dinyatakan tidak lulus.')->warning()->send();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AttendancesRelationManager::class,
            CertificateRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRegistrations::route('/'),
            'create' => CreateRegistration::route('/create'),
            'view' => ViewRegistration::route('/{record}'),
            'edit' => EditRegistration::route('/{record}/edit'),
        ];
    }
}
