<?php

namespace App\Filament\Resources\Trainings\RelationManagers;

use App\Enums\GraduationStatus;
use App\Enums\RegistrationStatus;
use App\Services\CertificateService;
use App\Services\InvoiceService;
use App\Models\Registration;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RegistrationsRelationManager extends RelationManager
{
    protected static string $relationship = 'registrations';

    protected static ?string $title = 'Peserta Terdaftar';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('customer_id')
                ->relationship('customer', 'name')
                ->searchable()
                ->preload()
                ->required()
                ->label('Pelanggan'),
            Select::make('status')
                ->options(RegistrationStatus::class)
                ->required()
                ->default(RegistrationStatus::PENDING)
                ->label('Status'),
            Select::make('graduation_status')
                ->options(GraduationStatus::class)
                ->default(GraduationStatus::NOT_ASSESSED)
                ->label('Status Kelulusan'),
            Textarea::make('notes')
                ->label('Catatan')
                ->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('registration_code')
            ->columns([
                TextColumn::make('registration_code')
                    ->label('Kode')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('customer.name')
                    ->label('Peserta')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                TextColumn::make('graduation_status')
                    ->label('Kelulusan')
                    ->badge(),
                TextColumn::make('created_at')
                    ->label('Terdaftar')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                \Filament\Actions\Action::make('confirm')
                    ->label('Konfirmasi')
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
                        InvoiceService::createForRegistration($record);
                        Notification::make()->title('Dikonfirmasi & invoice dibuat.')->success()->send();
                    }),
                \Filament\Actions\Action::make('set_passed')
                    ->label('Lulus')
                    ->icon('heroicon-o-academic-cap')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Registration $record) => $record->status === RegistrationStatus::CONFIRMED && $record->graduation_status === GraduationStatus::NOT_ASSESSED)
                    ->action(function (Registration $record) {
                        $record->update(['graduation_status' => GraduationStatus::PASSED]);
                        CertificateService::createForRegistration($record);
                        Notification::make()->title('Lulus & sertifikat digenerate.')->success()->send();
                    }),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
