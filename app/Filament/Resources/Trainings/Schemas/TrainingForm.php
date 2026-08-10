<?php

namespace App\Filament\Resources\Trainings\Schemas;

use App\Enums\TrainingStatus;
use App\Enums\TrainingType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\KeyValue;
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
                Section::make('Informasi Utama Pelatihan')
                    ->description('Detail nama, klasifikasi jenis pelatihan, dan deskripsi materi.')
                    ->components([
                        TextInput::make('name')
                            ->label('Nama Pelatihan')
                            ->placeholder('Contoh: Pelatihan Audit Investigatif & PKKN')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Grid::make(2)
                            ->components([
                                Select::make('type')
                                    ->label('Jenis Pelatihan')
                                    ->options(collect(TrainingType::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()]))
                                    ->required()
                                    ->native(false),

                                Select::make('status')
                                    ->label('Status Pelatihan')
                                    ->options(collect(TrainingStatus::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()]))
                                    ->default(TrainingStatus::DRAFT->value)
                                    ->required()
                                    ->native(false),
                            ]),

                        Textarea::make('description')
                            ->label('Deskripsi Pelatihan')
                            ->placeholder('Tuliskan ringkasan materi dan tujuan pembelajaran...')
                            ->rows(3)
                            ->columnSpanFull(),

                        Textarea::make('requirements')
                            ->label('Persyaratan Peserta')
                            ->placeholder('Contoh: Jenjang pendidikan minimal, latar belakang tugas, dsb.')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Section::make('Jadwal & Lokasi Pelaksanaan')
                    ->description('Waktu pelaksanaan, durasi hari, dan tempat berlangsungnya pelatihan.')
                    ->components([
                        Grid::make(3)
                            ->components([
                                DatePicker::make('start_date')
                                    ->label('Tanggal Mulai')
                                    ->required()
                                    ->native(false),

                                DatePicker::make('end_date')
                                    ->label('Tanggal Selesai')
                                    ->required()
                                    ->afterOrEqual('start_date')
                                    ->native(false),

                                TextInput::make('duration_days')
                                    ->label('Durasi (Hari)')
                                    ->numeric()
                                    ->minValue(1)
                                    ->suffix('Hari')
                                    ->required(),
                            ]),

                        TextInput::make('location')
                            ->label('Lokasi / Tempat Pelaksanaan')
                            ->placeholder('Contoh: Gedung Diklat BPKP DIY — Ruang Kelas Malioboro')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ]),

                Section::make('Kuota & Konfigurasi')
                    ->description('Batas kuota pendaftar dan data tambahan pelatihan.')
                    ->components([
                        Grid::make(3)
                            ->components([
                                TextInput::make('max_quota')
                                    ->label('Kuota Maksimal')
                                    ->numeric()
                                    ->default(50)
                                    ->minValue(1)
                                    ->required(),

                                TextInput::make('filled_quota')
                                    ->label('Kuota Terisi')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->required(),

                                Toggle::make('is_active')
                                    ->label('Status Aktif')
                                    ->default(true)
                                    ->inline(false)
                                    ->helperText('Tampilkan pelatihan di portal publik.'),
                            ]),

                        KeyValue::make('metadata')
                            ->label('Data Tambahan (Metadata)')
                            ->keyLabel('Atribut')
                            ->valueLabel('Nilai')
                            ->reorderable()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
