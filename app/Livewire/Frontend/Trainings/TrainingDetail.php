<?php

namespace App\Livewire\Frontend\Trainings;

use App\Models\Training;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class TrainingDetail extends Component
{
    public Training $training;

    public function mount(Training $training)
    {
        $this->training = $training;
        
        if (!$training->is_active) {
            abort(404, 'Pelatihan tidak ditemukan atau sudah tidak aktif.');
        }
    }

    public function render()
    {
        return view('livewire.frontend.trainings.training-detail');
    }
}
