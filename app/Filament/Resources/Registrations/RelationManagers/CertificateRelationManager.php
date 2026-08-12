<?php

namespace App\Filament\Resources\Registrations\RelationManagers;

use App\Enums\CertificateStatus;
use App\Services\CertificateService;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CertificateRelationManager extends RelationManager
{
    protected static string $relationship = 'certificate';

    protected static ?string $title = 'Sertifikat';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('certificate_number')
                ->label('Nomor Sertifikat')
                ->disabled()
                ->dehydrated(false),
            DatePicker::make('issued_date')
                ->label('Tanggal Terbit')
                ->required(),
            Select::make('status')
                ->options(CertificateStatus::class)
                ->required()
                ->default(CertificateStatus::DRAFT)
                ->label('Status'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('certificate_number')
            ->columns([
                TextColumn::make('certificate_number')
                    ->label('Nomor Sertifikat')
                    ->copyable()
                    ->searchable(),
                TextColumn::make('issued_date')
                    ->label('Tanggal Terbit')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                TextColumn::make('file_path')
                    ->label('File PDF')
                    ->formatStateUsing(fn ($state) => $state ? '📄 Tersedia' : '—'),
            ])
            ->headerActions([
                \Filament\Actions\Action::make('generate_certificate')
                    ->label('Generate Sertifikat')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function () {
                        $registration = $this->getOwnerRecord();
                        try {
                            CertificateService::createForRegistration($registration);
                            Notification::make()->title('Sertifikat berhasil digenerate.')->success()->send();
                        } catch (\Exception $e) {
                            Notification::make()->title('Gagal: ' . $e->getMessage())->danger()->send();
                        }
                    }),
            ])
            ->recordActions([
                EditAction::make(),
                \Filament\Actions\Action::make('download_pdf')
                    ->label('Download PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('info')
                    ->visible(fn ($record) => $record->file_path)
                    ->url(fn ($record) => asset('storage/' . $record->file_path), shouldOpenInNewTab: true),
                \Filament\Actions\Action::make('regenerate')
                    ->label('Regenerate PDF')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        CertificateService::generatePdf($record);
                        Notification::make()->title('PDF sertifikat berhasil diregenerate.')->success()->send();
                    }),
                DeleteAction::make(),
            ]);
    }
}
