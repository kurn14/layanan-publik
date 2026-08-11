<?php

namespace App\Livewire\Frontend\Trainings;

use App\Enums\TrainingStatus;
use App\Models\Training;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class TrainingList extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $trainings = Training::where('is_active', true)
            ->where('status', TrainingStatus::OPEN)
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy('start_date', 'asc')
            ->paginate(9);

        return view('livewire.frontend.trainings.training-list', [
            'trainings' => $trainings,
        ]);
    }
}
