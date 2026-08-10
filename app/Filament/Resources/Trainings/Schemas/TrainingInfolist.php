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
                Section::make('Informasi Utama Pelatihan')
                    ->components([
                        TextEntry::make('name')
                            ->label('Nama Pelatihan')
                            ->weight('bold')
                            ->size('lg')
                            ->columnSpanFull(),

                        Grid::make(2)
                            ->components([
                                TextEntry::make('type')
                                    ->label('Jenis Pelatihan')
                                    ->badge()
                                    ->formatStateUsing(fn ($state) => $state instanceof TrainingType ? $state->label() : TrainingType::tryFrom($state)?->label() ?? $state)
                                    ->color(fn ($state) => match ($state instanceof TrainingType ? $state : TrainingType::tryFrom($state)) {
                                        TrainingType::TECHNICAL => 'primary',
                                        TrainingType::MANAGERIAL => 'warning',
                                        TrainingType::FUNCTIONAL => 'info',
                                        default => 'gray',
                                    }),

                                TextEntry::make('status')
                                    ->label('Status Pelatihan')
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
                            ->label('Deskripsi Pelatihan')
                            ->placeholder('Tidak ada deskripsi.')
                            ->columnSpanFull(),

                        TextEntry::make('requirements')
                            ->label('Persyaratan Peserta')
                            ->placeholder('Tidak ada persyaratan khusus.')
                            ->columnSpanFull(),
                    ]),

                Section::make('Jadwal & Tempat Pelaksanaan')
                    ->components([
                        Grid::make(3)
                            ->components([
                                TextEntry::make('start_date')
                                    ->label('Tanggal Mulai')
                                    ->date('d F Y'),

                                TextEntry::make('end_date')
                                    ->label('Tanggal Selesai')
                                    ->date('d F Y'),

                                TextEntry::make('duration_days')
                                    ->label('Durasi')
                                    ->suffix(' Hari'),
                            ]),

                        TextEntry::make('location')
                            ->label('Lokasi / Ruangan')
                            ->columnSpanFull(),
                    ]),

                Section::make('Kuota & Publikasi')
                    ->components([
                        Grid::make(3)
                            ->components([
                                TextEntry::make('max_quota')
                                    ->label('Kuota Maksimal')
                                    ->suffix(' Orang'),

                                TextEntry::make('filled_quota')
                                    ->label('Kuota Terisi')
                                    ->suffix(' Orang'),

                                IconEntry::make('is_active')
                                    ->label('Status Publikasi')
                                    ->boolean(),
                            ]),

                        KeyValueEntry::make('metadata')
                            ->label('Data Tambahan (Metadata)')
                            ->columnSpanFull(),

                        Grid::make(2)
                            ->components([
                                TextEntry::make('created_at')
                                    ->label('Dibuat Pada')
                                    ->dateTime('d F Y H:i:s'),

                                TextEntry::make('updated_at')
                                    ->label('Terakhir Diperbarui')
                                    ->dateTime('d F Y H:i:s'),
                            ]),
                    ]),
            ]);
    }
}
