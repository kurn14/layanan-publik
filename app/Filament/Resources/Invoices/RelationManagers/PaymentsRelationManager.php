<?php

namespace App\Filament\Resources\Invoices\RelationManagers;

use App\Enums\InvoiceStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    protected static ?string $title = 'Pembayaran';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('amount')
                ->numeric()
                ->required()
                ->prefix('Rp')
                ->label('Jumlah Bayar'),
            Select::make('payment_method')
                ->options(PaymentMethod::class)
                ->required()
                ->label('Metode Pembayaran'),
            Select::make('status')
                ->options(PaymentStatus::class)
                ->required()
                ->default(PaymentStatus::PENDING)
                ->label('Status'),
            DateTimePicker::make('paid_at')
                ->label('Tanggal Bayar'),
            FileUpload::make('proof_file_path')
                ->label('Bukti Pembayaran')
                ->directory('payment-proofs')
                ->image()
                ->columnSpanFull(),
            Textarea::make('notes')
                ->label('Catatan')
                ->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('amount')
                    ->label('Jumlah')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('payment_method')
                    ->label('Metode')
                    ->badge(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                TextColumn::make('paid_at')
                    ->label('Tanggal Bayar')
                    ->dateTime('d M Y H:i')
                    ->placeholder('—'),
                TextColumn::make('verifier.name')
                    ->label('Diverifikasi Oleh')
                    ->placeholder('—'),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                \Filament\Actions\Action::make('verify')
                    ->label('Verifikasi')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status === PaymentStatus::PENDING)
                    ->action(function ($record) {
                        $record->update([
                            'status' => PaymentStatus::VERIFIED,
                            'verified_by' => auth()->id(),
                        ]);

                        // Update invoice status
                        $invoice = $record->invoice;
                        $totalPaid = $invoice->payments()->where('status', PaymentStatus::VERIFIED)->sum('amount');
                        if ($totalPaid >= $invoice->total_amount) {
                            $invoice->update([
                                'status' => InvoiceStatus::SETTLED,
                                'paid_at' => now(),
                            ]);
                        } else {
                            $invoice->update(['status' => InvoiceStatus::PAID]);
                        }

                        Notification::make()->title('Pembayaran terverifikasi.')->success()->send();
                    }),
                \Filament\Actions\Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status === PaymentStatus::PENDING)
                    ->action(function ($record) {
                        $record->update(['status' => PaymentStatus::REJECTED]);
                        Notification::make()->title('Pembayaran ditolak.')->warning()->send();
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
