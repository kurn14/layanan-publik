<?php

namespace Database\Seeders;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $operator = Employee::where('email', 'operator@bpkp.go.id')->first();
        $operator2 = Employee::where('email', 'operator2@bpkp.go.id')->first();

        $inv1 = Invoice::where('invoice_number', 'INV-202608-0001')->first();
        $inv3 = Invoice::where('invoice_number', 'INV-202607-0003')->first();
        $inv4 = Invoice::where('invoice_number', 'INV-202608-0004')->first();

        $payments = [
            [
                'invoice_id' => $inv1?->id,
                'amount' => 3500000.00,
                'payment_method' => PaymentMethod::BANK_TRANSFER,
                'proof_file_path' => 'payments/proof_inv_202608_0001.jpg',
                'status' => PaymentStatus::PENDING,
                'verified_by' => null,
                'paid_at' => now()->subDays(2),
                'notes' => 'Transfer dari Bank BPD DIY ke Rekening Giro BPKP DIY.',
            ],
            [
                'invoice_id' => $inv3?->id,
                'amount' => 4000000.00,
                'payment_method' => PaymentMethod::QRIS,
                'proof_file_path' => 'payments/proof_inv_202607_0003.jpg',
                'status' => PaymentStatus::VERIFIED,
                'verified_by' => $operator?->id,
                'paid_at' => '2026-07-10 14:20:00',
                'notes' => 'Pembayaran QRIS melalui Mobile Banking BCA terverifikasi otomatis.',
            ],
            [
                'invoice_id' => $inv4?->id,
                'amount' => 10000000.00,
                'payment_method' => PaymentMethod::BANK_TRANSFER,
                'proof_file_path' => 'payments/proof_inv_202608_0004.pdf',
                'status' => PaymentStatus::VERIFIED,
                'verified_by' => $operator2?->id,
                'paid_at' => '2026-08-02 09:30:00',
                'notes' => 'SP2D Pemkot Yogyakarta telah dicocokkan dengan mutasi rekening koran kas negara.',
            ],
        ];

        foreach ($payments as $payment) {
            if ($payment['invoice_id']) {
                Payment::updateOrCreate(
                    [
                        'invoice_id' => $payment['invoice_id'],
                        'amount' => $payment['amount'],
                    ],
                    $payment
                );
            }
        }
    }
}
