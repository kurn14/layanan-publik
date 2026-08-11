<?php

namespace App\Livewire\Frontend\Trainings;

use App\Models\Customer;
use App\Models\Registration;
use App\Models\Training;
use App\Enums\ClientType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class TrainingRegistration extends Component
{
    public Training $training;

    public $name = '';
    public $email = '';
    public $phone = '';
    public $nik = '';
    public $institution = '';
    public $password = '';
    public $password_confirmation = '';
    public $agree_terms = false;

    public function mount(Training $training)
    {
        $this->training = $training;
        
        if (!$training->is_active || $training->status !== \App\Enums\TrainingStatus::OPEN) {
            abort(404, 'Pendaftaran pelatihan ini sudah ditutup.');
        }

        // If customer is already logged in, pre-fill data and remove password requirement
        if (Auth::guard('customer')->check()) {
            $customer = Auth::guard('customer')->user();
            $this->name = $customer->name;
            $this->email = $customer->email;
            $this->phone = $customer->phone;
            $this->nik = $customer->id_number;
            $this->institution = $customer->origin_institution ?? '';
        }
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'nik' => 'required|string|size:16',
            'institution' => 'required|string|max:255',
            'agree_terms' => 'accepted',
        ];

        if (!Auth::guard('customer')->check()) {
            $rules['password'] = 'required|min:8|confirmed';
            $rules['email'] .= '|unique:customers,email';
            $rules['nik'] .= '|unique:customers,id_number';
        }

        return $rules;
    }

    public function submit()
    {
        $this->validate();

        try {
            DB::transaction(function () {
                // Lock training row to prevent race conditions during quota check
                $training = Training::where('id', $this->training->id)->lockForUpdate()->first();
                
                if ($training->filled_quota >= $training->max_quota) {
                    throw new \Exception('Maaf, kuota pelatihan sudah penuh.');
                }

                $customer = Auth::guard('customer')->user();

                if (!$customer) {
                    // Create new customer
                    $customer = Customer::create([
                        'name' => $this->name,
                        'email' => $this->email,
                        'phone' => $this->phone,
                        'id_number' => $this->nik,
                        'origin_institution' => $this->institution,
                        'password' => Hash::make($this->password),
                        'client_type' => ClientType::INDIVIDUAL,
                        'is_active' => true,
                    ]);

                    // Automatically log them in
                    Auth::guard('customer')->login($customer);
                }

                // Generate registration code
                $prefix = 'REG-' . date('Ym') . '-';
                $lastRegistration = Registration::where('registration_code', 'like', $prefix . '%')
                    ->orderBy('registration_code', 'desc')
                    ->lockForUpdate()
                    ->first();

                if ($lastRegistration) {
                    $lastSequence = intval(substr($lastRegistration->registration_code, -4));
                    $newSequence = str_pad($lastSequence + 1, 4, '0', STR_PAD_LEFT);
                } else {
                    $newSequence = '0001';
                }
                $registrationCode = $prefix . $newSequence;

                // Create registration
                $registration = Registration::create([
                    'registration_code' => $registrationCode,
                    'training_id' => $training->id,
                    'customer_id' => $customer->id,
                    'participant_name' => $this->name,
                    'nik' => $this->nik,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'institution' => $this->institution,
                    'status' => 'pending',
                ]);

                // Increment quota
                $training->increment('filled_quota');
            });

            session()->flash('message', 'Pendaftaran berhasil! Silakan cek dashboard Anda.');
            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            $this->addError('general', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.frontend.trainings.training-registration');
    }
}
