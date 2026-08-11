<?php

namespace App\Livewire\Frontend\Facilities;

use App\Models\Customer;
use App\Models\Facility;
use App\Models\FacilityBooking as BookingModel;
use App\Enums\ClientType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class FacilityBooking extends Component
{
    public Facility $facility;

    // Customer fields
    public $name = '';
    public $email = '';
    public $phone = '';
    public $nik = '';
    public $institution = '';
    public $password = '';
    public $password_confirmation = '';
    
    // Booking fields
    public $start_date;
    public $end_date;
    public $purpose = '';
    public $agree_terms = false;

    public function mount(Facility $facility)
    {
        $this->facility = $facility;
        
        if (!$facility->is_active) {
            abort(404, 'Fasilitas ini sedang tidak tersedia.');
        }

        // If customer is already logged in, pre-fill data
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
            
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'purpose' => 'required|string',
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

        $startDate = Carbon::parse($this->start_date)->startOfDay();
        $endDate = Carbon::parse($this->end_date)->endOfDay();

        // Check for overlapping bookings
        $overlappingBookings = BookingModel::where('facility_id', $this->facility->id)
            ->whereIn('status', ['pending', 'confirmed', 'ongoing'])
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                      ->orWhereBetween('end_date', [$startDate, $endDate])
                      ->orWhere(function ($q) use ($startDate, $endDate) {
                          $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                      });
            })
            ->exists();

        if ($overlappingBookings) {
            $this->addError('start_date', 'Fasilitas sudah dipesan pada tanggal tersebut.');
            return;
        }

        try {
            DB::transaction(function () use ($startDate, $endDate) {
                $customer = Auth::guard('customer')->user();

                if (!$customer) {
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
                    
                    Auth::guard('customer')->login($customer);
                }

                $totalDays = $startDate->diffInDays($endDate) + 1;
                $totalPrice = $totalDays * $this->facility->price_per_day;

                BookingModel::create([
                    'facility_id' => $this->facility->id,
                    'customer_id' => $customer->id,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'purpose' => $this->purpose,
                    'total_cost' => $totalPrice,
                    'status' => 'pending',
                ]);
            });

            session()->flash('message', 'Pemesanan fasilitas berhasil diajukan! Silakan cek dashboard Anda.');
            return redirect()->route('dashboard');
            
        } catch (\Exception $e) {
            $this->addError('general', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.frontend.facilities.facility-booking');
    }
}
