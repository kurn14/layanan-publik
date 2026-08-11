<?php

namespace App\Livewire\Frontend\Facilities;

use App\Models\Facility;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class FacilityList extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $facilities = Facility::where('is_active', true)
            ->where('name', 'like', '%' . $this->search . '%')
            ->with(['photos' => function ($query) {
                $query->orderBy('sort', 'asc')->limit(1);
            }])
            ->paginate(9);

        return view('livewire.frontend.facilities.facility-list', [
            'facilities' => $facilities,
        ]);
    }
}
