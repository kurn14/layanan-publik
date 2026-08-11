<?php

namespace App\Livewire\Frontend\Facilities;

use App\Models\Facility;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class FacilityDetail extends Component
{
    public Facility $facility;

    public function mount(Facility $facility)
    {
        $this->facility = $facility->load('photos');
        
        if (!$facility->is_active) {
            abort(404, 'Fasilitas tidak ditemukan atau sudah tidak aktif.');
        }
    }

    public function render()
    {
        return view('livewire.frontend.facilities.facility-detail');
    }
}
