<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

use App\Models\Training;
use App\Enums\TrainingStatus;
use App\Models\Facility;
use App\Models\FacilityBooking;

class DashboardStatsWidget extends StatsOverviewWidget
{
    protected function getColumns(): int
    {
        return 4;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Pelatihan Berlangsung', Training::where('status', TrainingStatus::ONGOING)->count())
                ->description('Sedang berjalan')
                ->descriptionIcon('heroicon-m-play')
                ->color('primary'),
            Stat::make('Pelatihan Selesai', Training::where('status', TrainingStatus::COMPLETED)->count())
                ->description('Telah selesai')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            Stat::make('Total Fasilitas', Facility::count())
                ->description('Jumlah keseluruhan')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('info'),
            Stat::make('Total Pemesanan', FacilityBooking::count())
                ->description('Sejauh ini')
                ->descriptionIcon('heroicon-m-ticket')
                ->color('warning'),
        ];
    }
}
