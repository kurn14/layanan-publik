<?php

namespace App\Filament\Widgets;

use App\Models\Training;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class TrainingChartWidget extends ChartWidget
{
    protected ?string $heading = 'Grafik Pelatihan Dilaksanakan';
    protected static ?int $sort = 2;
    
    protected function getData(): array
    {
        $trainings = Training::whereYear('start_date', now()->year)->get();
        
        $data = [];
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        
        foreach (range(1, 12) as $month) {
            $data[] = $trainings->filter(fn ($t) => Carbon::parse($t->start_date)->month === $month)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pelatihan',
                    'data' => $data,
                    'backgroundColor' => '#3b82f6',
                    'borderColor' => '#3b82f6',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
