<?php

namespace App\Filament\Resources\FacilityBookings;

use App\Enums\BookingStatus;
use App\Filament\Resources\FacilityBookings\Pages\CreateFacilityBooking;
use App\Filament\Resources\FacilityBookings\Pages\EditFacilityBooking;
use App\Filament\Resources\FacilityBookings\Pages\ListFacilityBookings;
use App\Filament\Resources\FacilityBookings\Pages\ViewFacilityBooking;
use App\Models\FacilityBooking;
use App\Services\InvoiceService;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FacilityBookingResource extends Resource
{
    protected static ?string $model = FacilityBooking::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CalendarDays;

    public static function getModelLabel(): string
    {
        return __('Facility Booking');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Facility Bookings');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Rental Services');
    }

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('status', BookingStatus::PENDING)->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('Booking Data'))->components([
                Grid::make(2)->components([
                    Select::make('facility_id')
                        ->relationship('facility', 'name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->label(__('Facility')),
                    Select::make('customer_id')
                        ->relationship('customer', 'name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->label(__('Customer')),
                    TextInput::make('purpose')
                        ->required()
                        ->maxLength(255)
                        ->label(__('Purpose'))
                        ->columnSpanFull(),
                    DatePicker::make('start_date')
                        ->required()
                        ->label(__('Start Date')),
                    DatePicker::make('end_date')
                        ->required()
                        ->afterOrEqual('start_date')
                        ->label(__('End Date')),
                    TextInput::make('guest_count')
                        ->numeric()
                        ->label(__('Guest Count')),
                    TextInput::make('total_cost')
                        ->numeric()
                        ->required()
                        ->prefix('Rp')
                        ->label(__('Total Cost')),
                    Select::make('status')
                        ->options(BookingStatus::class)
                        ->required()
                        ->default(BookingStatus::PENDING)
                        ->label(__('Status')),
                    TextInput::make('cancellation_fee')
                        ->numeric()
                        ->prefix('Rp')
                        ->default(0)
                        ->label(__('Cancellation Fee')),
                    Toggle::make('arrival_confirmed')
                        ->label(__('Arrival Confirmed'))
                        ->columnSpanFull(),
                    Textarea::make('notes')
                        ->label(__('Notes'))
                        ->columnSpanFull(),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('facility.name')
                    ->label(__('Facility'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('customer.name')
                    ->label(__('Customer'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('purpose')
                    ->label(__('Purpose'))
                    ->limit(30)
                    ->searchable(),
                TextColumn::make('start_date')
                    ->label(__('Start'))
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label(__('End'))
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('total_cost')
                    ->label(__('Total'))
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options(BookingStatus::class)
                    ->label(__('Status')),
            ])
            ->recordActions([
                \Filament\Tables\Actions\ViewAction::make(),
                \Filament\Tables\Actions\EditAction::make(),
                \Filament\Tables\Actions\Action::make('confirm')
                    ->label(__('Confirm'))
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (FacilityBooking $record) => $record->status === BookingStatus::PENDING)
                    ->action(function (FacilityBooking $record) {
                        $record->update(['status' => BookingStatus::CONFIRMED]);
                        InvoiceService::createForBooking($record);
                        Notification::make()->title('Booking dikonfirmasi & invoice dibuat.')->success()->send();
                    }),
                \Filament\Tables\Actions\Action::make('complete')
                    ->label(__('Complete'))
                    ->icon('heroicon-o-flag')
                    ->color('info')
                    ->requiresConfirmation()
                    ->visible(fn (FacilityBooking $record) => in_array($record->status, [BookingStatus::CONFIRMED, BookingStatus::ONGOING]))
                    ->action(function (FacilityBooking $record) {
                        $record->update(['status' => BookingStatus::COMPLETED]);
                        Notification::make()->title('Booking ditandai selesai.')->success()->send();
                    }),
                \Filament\Tables\Actions\Action::make('cancel')
                    ->label(__('Cancel'))
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (FacilityBooking $record) => in_array($record->status, [BookingStatus::PENDING, BookingStatus::CONFIRMED]))
                    ->action(function (FacilityBooking $record) {
                        $record->update(['status' => BookingStatus::CANCELLED]);
                        Notification::make()->title('Booking dibatalkan.')->warning()->send();
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFacilityBookings::route('/'),
            'create' => CreateFacilityBooking::route('/create'),
            'view' => ViewFacilityBooking::route('/{record}'),
            'edit' => EditFacilityBooking::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
