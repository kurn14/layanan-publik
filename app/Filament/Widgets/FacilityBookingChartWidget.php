<?php

namespace App\Filament\Widgets;

use App\Models\FacilityBooking;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class FacilityBookingChartWidget extends ChartWidget
{
    protected ?string $heading = 'Grafik Pemesanan Fasilitas';
    protected static ?int $sort = 3;
    
    protected function getData(): array
    {
        $bookings = FacilityBooking::whereYear('start_date', now()->year)->get();
        
        $data = [];
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        
        foreach (range(1, 12) as $month) {
            $data[] = $bookings->filter(fn ($b) => Carbon::parse($b->start_date)->month === $month)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pemesanan',
                    'data' => $data,
                    'backgroundColor' => '#f59e0b',
                    'borderColor' => '#f59e0b',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
