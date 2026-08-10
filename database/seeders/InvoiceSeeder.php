<?php

namespace Database\Seeders;

use App\Enums\InvoiceStatus;
use App\Models\FacilityBooking;
use App\Models\Invoice;
use App\Models\Registration;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $reg1 = Registration::where('registration_code', 'REG-202608-0001')->first();
        $reg2 = Registration::where('registration_code', 'REG-202608-0002')->first();
        $reg5 = Registration::where('registration_code', 'REG-202607-0005')->first();

        $booking1 = FacilityBooking::where('event_name', 'like', '%Rapat Koordinasi Tata Kelola Keuangan%')->first();

        $invoices = [
            [
                'registration_id' => $reg1?->id,
                'facility_booking_id' => null,
                'invoice_number' => 'INV-202608-0001',
                'total_amount' => 3500000.00,
                'status' => InvoiceStatus::PAID,
                'due_date' => '2026-08-25',
                'paid_at' => now()->subDays(2),
                'line_items' => [
                    [
                        'description' => 'Biaya Kepesertaan Pelatihan Audit Investigatif & PKKN (5 Hari)',
                        'quantity' => 1,
                        'unit_price' => 3500000.00,
                        'total' => 3500000.00,
                    ],
                ],
                'notes' => 'Pembayaran via transfer rekening kas BLU BPKP.',
            ],
            [
                'registration_id' => $reg2?->id,
                'facility_booking_id' => null,
                'invoice_number' => 'INV-202608-0002',
                'total_amount' => 3500000.00,
                'status' => InvoiceStatus::SENT,
                'due_date' => '2026-08-25',
                'paid_at' => null,
                'line_items' => [
                    [
                        'description' => 'Biaya Kepesertaan Pelatihan Audit Investigatif & PKKN (5 Hari)',
                        'quantity' => 1,
                        'unit_price' => 3500000.00,
                        'total' => 3500000.00,
                    ],
                ],
                'notes' => 'Batas akhir pembayaran H-7 sebelum pelatihan dimulai.',
            ],
            [
                'registration_id' => $reg5?->id,
                'facility_booking_id' => null,
                'invoice_number' => 'INV-202607-0003',
                'total_amount' => 4000000.00,
                'status' => InvoiceStatus::SETTLED,
                'due_date' => '2026-07-13',
                'paid_at' => '2026-07-10 14:20:00',
                'line_items' => [
                    [
                        'description' => 'Biaya Kepesertaan Pelatihan TABK Data Analytics (5 Hari)',
                        'quantity' => 1,
                        'unit_price' => 4000000.00,
                        'total' => 4000000.00,
                    ],
                ],
                'notes' => 'Pembayaran lunas via QRIS.',
            ],
            [
                'registration_id' => null,
                'facility_booking_id' => $booking1?->id,
                'invoice_number' => 'INV-202608-0004',
                'total_amount' => 10000000.00,
                'status' => InvoiceStatus::SETTLED,
                'due_date' => '2026-09-14',
                'paid_at' => '2026-08-02 09:30:00',
                'line_items' => [
                    [
                        'description' => 'Sewa Auditorium Merapi BPKP DIY (2 Hari)',
                        'quantity' => 2,
                        'unit_price' => 5000000.00,
                        'total' => 10000000.00,
                    ],
                ],
                'notes' => 'Lunas SP2D Pemerintah Kota Yogyakarta.',
            ],
        ];

        foreach ($invoices as $invoice) {
            Invoice::updateOrCreate(
                ['invoice_number' => $invoice['invoice_number']],
                $invoice
            );
        }
    }
}
