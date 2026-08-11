<?php

namespace App\Livewire\Frontend\Auth;

use App\Enums\ClientType;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts.app')]
class Register extends Component
{
    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('required|string|email|max:255|unique:customers')]
    public $email = '';

    #[Validate('required|string|min:8|confirmed')]
    public $password = '';

    public $password_confirmation = '';

    #[Validate('nullable|string|max:50')]
    public $id_number = '';

    #[Validate('nullable|string|max:20')]
    public $phone = '';

    #[Validate('nullable|string|max:255')]
    public $position = '';

    #[Validate('nullable|string|max:255')]
    public $origin_institution = '';

    #[Validate('required|string')]
    public $client_type = 'INDIVIDUAL';

    public function register()
    {
        $this->validate();

        $customer = Customer::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'id_number' => $this->id_number,
            'phone' => $this->phone,
            'position' => $this->position,
            'origin_institution' => $this->origin_institution,
            'client_type' => $this->client_type,
            'is_active' => true,
        ]);

        Auth::guard('customer')->login($customer);

        return redirect()->intended('/pelatihan');
    }

    public function render()
    {
        return view('livewire.frontend.auth.register');
    }
}
