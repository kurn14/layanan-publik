<?php

namespace App\Livewire\Frontend;

use App\Enums\TrainingStatus;
use App\Models\Facility;
use App\Models\Training;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Home extends Component
{
    public function render()
    {
        $trainings = Training::where('is_active', true)
            ->where('status', TrainingStatus::OPEN)
            ->orderBy('start_date', 'asc')
            ->take(3)
            ->get();

        $facilities = Facility::where('is_active', true)
            ->with(['photos' => function ($query) {
                $query->orderBy('sort', 'asc')->limit(1);
            }])
            ->take(3)
            ->get();

        return view('livewire.frontend.home', [
            'trainings' => $trainings,
            'facilities' => $facilities,
        ]);
    }
}
