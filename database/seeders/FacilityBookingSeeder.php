<?php

namespace Database\Seeders;

use App\Enums\BookingStatus;
use App\Models\Customer;
use App\Models\Facility;
use App\Models\FacilityBooking;
use Illuminate\Database\Seeder;

class FacilityBookingSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::all()->keyBy('email');
        $facilities = Facility::all()->keyBy('name');

        $cDewi = $customers->get('dewi.anggraeni@jogjakota.go.id');
        $cHendro = $customers->get('hendro.prasetyo@sardjito.co.id');
        $cBudi = $customers->get('budi.santoso@slemankab.go.id');

        $fAuditorium = $facilities->get('Auditorium Merapi');
        $fPrambanan = $facilities->get('Ruang Kelas Prambanan');
        $fLab = $facilities->get('Laboratorium Komputer & Forensik Digital');

        $bookings = [
            [
                'facility_id' => $fAuditorium?->id,
                'customer_id' => $cDewi?->id,
                'event_name' => 'Rapat Koordinasi Tata Kelola Keuangan Pemerintah Daerah Se-DIY TA 2026',
                'start_date' => '2026-09-21',
                'end_date' => '2026-09-22',
                'guest_count' => 120,
                'total_cost' => 10000000.00,
                'status' => BookingStatus::CONFIRMED,
                'arrival_confirmed' => true,
                'cancellation_fee' => 0.00,
                'notes' => 'Membutuhkan konfigurasi meja round table untuk 12 meja @ 10 orang dan live streaming setup.',
            ],
            [
                'facility_id' => $fPrambanan?->id,
                'customer_id' => $cHendro?->id,
                'event_name' => 'Workshop Audit Mutu Klinis & Penguatan SPI Rumah Sakit',
                'start_date' => '2026-10-12',
                'end_date' => '2026-10-14',
                'guest_count' => 40,
                'total_cost' => 6000000.00,
                'status' => BookingStatus::CONFIRMED,
                'arrival_confirmed' => false,
                'cancellation_fee' => 0.00,
                'notes' => 'Susunan kursi classroom standard dengan 2 mic wireless tambahan.',
            ],
            [
                'facility_id' => $fLab?->id,
                'customer_id' => $cBudi?->id,
                'event_name' => 'In-House Training Analisis Data APIP Inspektorat Sleman',
                'start_date' => '2026-11-04',
                'end_date' => '2026-11-05',
                'guest_count' => 25,
                'total_cost' => 6000000.00,
                'status' => BookingStatus::PENDING,
                'arrival_confirmed' => false,
                'cancellation_fee' => 0.00,
                'notes' => 'Menunggu persetujuan DPA Perubahan Inspektorat.',
            ],
        ];

        foreach ($bookings as $booking) {
            if ($booking['facility_id'] && $booking['customer_id']) {
                FacilityBooking::updateOrCreate(
                    [
                        'facility_id' => $booking['facility_id'],
                        'start_date' => $booking['start_date'],
                        'end_date' => $booking['end_date'],
                    ],
                    $booking
                );
            }
        }
    }
}
