<?php

namespace App\Filament\Resources\Registrations\RelationManagers;

use App\Enums\AttendanceStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AttendancesRelationManager extends RelationManager
{
    protected static string $relationship = 'attendances';

    protected static ?string $title = 'Presensi';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            DatePicker::make('date')
                ->required()
                ->label('Tanggal'),
            Select::make('status')
                ->options(AttendanceStatus::class)
                ->required()
                ->default(AttendanceStatus::PRESENT)
                ->label('Status Kehadiran'),
            TimePicker::make('check_in_time')
                ->label('Jam Masuk'),
            TimePicker::make('check_out_time')
                ->label('Jam Keluar'),
            Textarea::make('remarks')
                ->label('Keterangan')
                ->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('date')
            ->columns([
                TextColumn::make('date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                TextColumn::make('check_in_time')
                    ->label('Jam Masuk')
                    ->time('H:i'),
                TextColumn::make('check_out_time')
                    ->label('Jam Keluar')
                    ->time('H:i'),
                TextColumn::make('remarks')
                    ->label('Keterangan')
                    ->limit(30),
            ])
            ->defaultSort('date')
            ->headerActions([
                CreateAction::make(),
                \Filament\Tables\Actions\Action::make('generate_all')
                    ->label('Generate Semua Hari')
                    ->icon('heroicon-o-calendar-days')
                    ->color('info')
                    ->requiresConfirmation()
                    ->action(function () {
                        $registration = $this->getOwnerRecord();
                        $training = $registration->training;

                        if (!$training) {
                            Notification::make()->title('Training tidak ditemukan.')->danger()->send();
                            return;
                        }

                        $start = \Carbon\Carbon::parse($training->start_date);
                        $end = \Carbon\Carbon::parse($training->end_date);
                        $created = 0;

                        while ($start->lte($end)) {
                            $exists = $registration->attendances()->where('date', $start->toDateString())->exists();
                            if (!$exists) {
                                $registration->attendances()->create([
                                    'date' => $start->toDateString(),
                                    'status' => AttendanceStatus::PRESENT,
                                ]);
                                $created++;
                            }
                            $start->addDay();
                        }

                        Notification::make()->title("$created record presensi berhasil dibuat.")->success()->send();
                    }),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
