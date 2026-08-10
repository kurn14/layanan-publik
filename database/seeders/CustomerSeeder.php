<?php

namespace Database\Seeders;

use App\Enums\ClientType;
use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'name' => 'Budi Santoso, S.E., Ak.',
                'email' => 'budi.santoso@slemankab.go.id',
                'password' => Hash::make('password'),
                'id_number' => '3404011205880001',
                'phone' => '081223344556',
                'position' => 'Auditor Muda',
                'origin_institution' => 'Inspektorat Kabupaten Sleman',
                'client_type' => ClientType::INSTITUTIONAL,
                'is_active' => true,
            ],
            [
                'name' => 'Dewi Anggraeni, S.Tr.Ak.',
                'email' => 'dewi.anggraeni@jogjakota.go.id',
                'password' => Hash::make('password'),
                'id_number' => '3471025508920003',
                'phone' => '081334455667',
                'position' => 'Bendahara Pengeluaran',
                'origin_institution' => 'BPKAD Kota Yogyakarta',
                'client_type' => ClientType::INSTITUTIONAL,
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Hendro Prasetyo, M.Kes.',
                'email' => 'hendro.prasetyo@sardjito.co.id',
                'password' => Hash::make('password'),
                'id_number' => '3404071903750002',
                'phone' => '081445566778',
                'position' => 'Kepala SPI',
                'origin_institution' => 'RSUP Dr. Sardjito Yogyakarta',
                'client_type' => ClientType::INSTITUTIONAL,
                'is_active' => true,
            ],
            [
                'name' => 'Rina Wahyuningsih, S.Sos.',
                'email' => 'rina.wahyu@bantulkab.go.id',
                'password' => Hash::make('password'),
                'id_number' => '3402034907950005',
                'phone' => '081556677889',
                'position' => 'Staf Perencanaan',
                'origin_institution' => 'Dinas Pendidikan Kepemudaan dan Olahraga Kab. Bantul',
                'client_type' => ClientType::INSTITUTIONAL,
                'is_active' => true,
            ],
            [
                'name' => 'Agus Triyono, S.Kom., M.T.I.',
                'email' => 'agus.triyono@gmail.com',
                'password' => Hash::make('password'),
                'id_number' => '3404062111890004',
                'phone' => '081667788990',
                'position' => 'Konsultan Manajemen Risiko & Audit TI',
                'origin_institution' => 'Independen / Konsultan Publik',
                'client_type' => ClientType::INDIVIDUAL,
                'is_active' => true,
            ],
            [
                'name' => 'Tri Hastuti, S.E.',
                'email' => 'tri.hastuti@kulonprogokab.go.id',
                'password' => Hash::make('password'),
                'id_number' => '3401026004910002',
                'phone' => '081778899001',
                'position' => 'Pengawas Penyelenggaraan Urusan Pemerintahan Daerah (PPUPD)',
                'origin_institution' => 'Inspektorat Daerah Kabupaten Kulon Progo',
                'client_type' => ClientType::INSTITUTIONAL,
                'is_active' => true,
            ],
        ];

        foreach ($customers as $customer) {
            Customer::updateOrCreate(
                ['email' => $customer['email']],
                $customer
            );
        }
    }
}
