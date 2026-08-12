<?php

namespace App\Livewire\Frontend\Customer;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public function render()
    {
        $customer = Auth::guard('customer')->user();
        
        // Eager load relations for performance
        $customer->load([
            'registrations.training', 
            'registrations.invoice',
            'registrations.certificate',
            'facilityBookings.facility',
            'facilityBookings.invoice',
        ]);

        return view('livewire.frontend.customer.dashboard', [
            'customer' => $customer
        ]);
    }
}
