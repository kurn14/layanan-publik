<?php

namespace App\Filament\Resources\Invoices;

use App\Enums\InvoiceStatus;
use App\Filament\Resources\Invoices\Pages\CreateInvoice;
use App\Filament\Resources\Invoices\Pages\EditInvoice;
use App\Filament\Resources\Invoices\Pages\ListInvoices;
use App\Filament\Resources\Invoices\Pages\ViewInvoice;
use App\Filament\Resources\Invoices\RelationManagers\PaymentsRelationManager;
use App\Models\Invoice;
use App\Services\InvoiceService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
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

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentText;

    public static function getModelLabel(): string
    {
        return __('Invoice');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Invoices');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Finance');
    }

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('status', InvoiceStatus::SENT)->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('Invoice Information'))->components([
                Grid::make(2)->components([
                    TextInput::make('invoice_number')
                        ->label(__('Invoice Number'))
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),
                    Select::make('status')
                        ->options(InvoiceStatus::class)
                        ->required()
                        ->default(InvoiceStatus::DRAFT)
                        ->label(__('Status')),
                    Select::make('registration_id')
                        ->relationship('registration', 'registration_code')
                        ->searchable()
                        ->preload()
                        ->label(__('Registration')),
                    Select::make('facility_booking_id')
                        ->relationship('facilityBooking', 'purpose')
                        ->searchable()
                        ->preload()
                        ->label(__('Facility Booking')),
                    TextInput::make('total_amount')
                        ->numeric()
                        ->required()
                        ->prefix('Rp')
                        ->label(__('Total Amount')),
                    DatePicker::make('due_date')
                        ->required()
                        ->label(__('Due Date')),
                ]),
                Textarea::make('notes')
                    ->label(__('Notes'))
                    ->columnSpanFull(),
            ]),
            Section::make(__('Line Items'))->components([
                Repeater::make('line_items')
                    ->label('')
                    ->schema([
                        TextInput::make('description')
                            ->required()
                            ->label(__('Description'))
                            ->columnSpan(2),
                        TextInput::make('quantity')
                            ->numeric()
                            ->required()
                            ->default(1)
                            ->label(__('Qty')),
                        TextInput::make('unit_price')
                            ->numeric()
                            ->required()
                            ->prefix('Rp')
                            ->label(__('Unit Price')),
                        TextInput::make('total')
                            ->numeric()
                            ->required()
                            ->prefix('Rp')
                            ->label(__('Total')),
                    ])
                    ->columns(5)
                    ->columnSpanFull()
                    ->defaultItems(1),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_number')
                    ->label(__('Invoice #'))
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                TextColumn::make('registration.registration_code')
                    ->label(__('Registration'))
                    ->placeholder('—')
                    ->sortable(),
                TextColumn::make('facilityBooking.purpose')
                    ->label(__('Booking'))
                    ->placeholder('—')
                    ->limit(30),
                TextColumn::make('total_amount')
                    ->label(__('Total'))
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('due_date')
                    ->label(__('Due Date'))
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('paid_at')
                    ->label(__('Paid At'))
                    ->dateTime('d M Y H:i')
                    ->placeholder('—')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options(InvoiceStatus::class)
                    ->label(__('Status')),
            ])
            ->recordActions([
                \Filament\Actions\ViewAction::make(),
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\Action::make('generate_pdf')
                    ->label(__('Generate PDF'))
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('info')
                    ->action(function (Invoice $record) {
                        $path = InvoiceService::generatePdf($record);
                        Notification::make()->title('PDF invoice berhasil digenerate.')->success()->send();
                    }),
                \Filament\Actions\Action::make('download_pdf')
                    ->label(__('Download'))
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function (Invoice $record) {
                        $path = InvoiceService::generatePdf($record);
                        return response()->download(storage_path('app/public/' . $path));
                    }),
                \Filament\Actions\Action::make('mark_sent')
                    ->label(__('Mark Sent'))
                    ->icon('heroicon-o-paper-airplane')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->visible(fn (Invoice $record) => $record->status === InvoiceStatus::DRAFT)
                    ->action(function (Invoice $record) {
                        $record->update(['status' => InvoiceStatus::SENT]);
                        Notification::make()->title('Invoice ditandai terkirim.')->success()->send();
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
            PaymentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInvoices::route('/'),
            'create' => CreateInvoice::route('/create'),
            'view' => ViewInvoice::route('/{record}'),
            'edit' => EditInvoice::route('/{record}/edit'),
        ];
    }
}
