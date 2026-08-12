<?php

namespace App\Livewire\Frontend\Customer;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class UploadPayment extends Component
{
    use WithFileUploads;

    public Invoice $invoice;

    public $payment_method = '';
    public $proof_file;
    public $notes = '';

    public function mount(Invoice $invoice)
    {
        $this->invoice = $invoice;

        // Verify the invoice belongs to the logged-in customer
        $customer = Auth::guard('customer')->user();
        $ownsInvoice = false;

        if ($invoice->registration && $invoice->registration->customer_id === $customer->id) {
            $ownsInvoice = true;
        }
        if ($invoice->facilityBooking && $invoice->facilityBooking->customer_id === $customer->id) {
            $ownsInvoice = true;
        }

        if (!$ownsInvoice) {
            abort(403, 'Anda tidak memiliki akses ke invoice ini.');
        }

        if ($invoice->status !== \App\Enums\InvoiceStatus::SENT) {
            session()->flash('message', 'Invoice ini sudah dibayar atau tidak valid untuk pembayaran.');
            $this->redirect(route('dashboard'), navigate: true);
            return;
        }

        if ($invoice->payments()->where('status', \App\Enums\PaymentStatus::PENDING)->exists()) {
            session()->flash('message', 'Anda sudah mengunggah bukti pembayaran. Harap tunggu verifikasi admin.');
            $this->redirect(route('dashboard'), navigate: true);
            return;
        }

        if ($invoice->facilityBooking && in_array($invoice->facilityBooking->status, [\App\Enums\BookingStatus::COMPLETED, \App\Enums\BookingStatus::CANCELLED])) {
            session()->flash('message', 'Pemesanan ini sudah selesai atau dibatalkan.');
            $this->redirect(route('dashboard'), navigate: true);
            return;
        }

        if ($invoice->registration && in_array($invoice->registration->status, [\App\Enums\RegistrationStatus::REJECTED, \App\Enums\RegistrationStatus::CANCELLED])) {
            session()->flash('message', 'Pendaftaran ini sudah dibatalkan atau ditolak.');
            $this->redirect(route('dashboard'), navigate: true);
            return;
        }
    }

    public function rules()
    {
        return [
            'payment_method' => 'required|string',
            'proof_file' => 'required|image|max:2048',
            'notes' => 'nullable|string|max:500',
        ];
    }

    public function submit()
    {
        $this->validate();

        $path = $this->proof_file->store('payment-proofs', 'public');

        Payment::create([
            'invoice_id' => $this->invoice->id,
            'amount' => $this->invoice->total_amount,
            'payment_method' => $this->payment_method,
            'proof_file_path' => $path,
            'status' => PaymentStatus::PENDING,
            'paid_at' => now(),
            'notes' => $this->notes,
        ]);

        session()->flash('message', 'Bukti pembayaran berhasil diunggah! Menunggu verifikasi admin.');
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.frontend.customer.upload-payment', [
            'paymentMethods' => PaymentMethod::cases(),
        ]);
    }
}
