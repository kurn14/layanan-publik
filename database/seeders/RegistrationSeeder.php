<?php

namespace Database\Seeders;

use App\Enums\ConfirmationChannel;
use App\Enums\GraduationStatus;
use App\Enums\RegistrationStatus;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Registration;
use App\Models\Training;
use Illuminate\Database\Seeder;

class RegistrationSeeder extends Seeder
{
    public function run(): void
    {
        $operator = Employee::where('email', 'operator@bpkp.go.id')->first();
        $operator2 = Employee::where('email', 'operator2@bpkp.go.id')->first();

        $trainings = Training::all()->keyBy('name');
        $customers = Customer::all()->keyBy('email');

        $t1 = $trainings->get('Pelatihan Audit Investigatif & Penghitungan Kerugian Keuangan Negara (PKKN)');
        $t2 = $trainings->get('Pelatihan Penilaian Maturitas Penyelenggaraan SPIP Terintegrasi');
        $t3 = $trainings->get('Pelatihan Manajemen Risiko Sektor Publik & Good Governance (GRC)');
        $t4 = $trainings->get('Pelatihan Teknik Audit Berbantuan Komputer (TABK) dengan Data Analytics');

        $c1 = $customers->get('budi.santoso@slemankab.go.id');
        $c2 = $customers->get('dewi.anggraeni@jogjakota.go.id');
        $c3 = $customers->get('hendro.prasetyo@sardjito.co.id');
        $c4 = $customers->get('rina.wahyu@bantulkab.go.id');
        $c5 = $customers->get('agus.triyono@gmail.com');
        $c6 = $customers->get('tri.hastuti@kulonprogokab.go.id');

        $registrations = [
            [
                'registration_code' => 'REG-202608-0001',
                'training_id' => $t1?->id,
                'customer_id' => $c1?->id,
                'verified_by' => $operator?->id,
                'status' => RegistrationStatus::CONFIRMED,
                'graduation_status' => GraduationStatus::PASSED,
                'notes' => 'Mohon difasilitasi materi softcopy sebelum hari H.',
                'operator_notes' => 'Dokumen persyaratan lengkap (SK Auditor & Ijazah telah diverifikasi).',
                'confirmed_at' => now()->subDays(5),
                'confirmed_via' => ConfirmationChannel::WHATSAPP,
                'metadata' => [
                    'tshirt_size' => 'L',
                    'dietary_restriction' => 'Tidak ada',
                ],
            ],
            [
                'registration_code' => 'REG-202608-0002',
                'training_id' => $t1?->id,
                'customer_id' => $c2?->id,
                'verified_by' => $operator?->id,
                'status' => RegistrationStatus::CONFIRMED,
                'graduation_status' => GraduationStatus::NOT_ASSESSED,
                'notes' => 'Pendaftaran delegasi resmi BPKAD Kota Yogyakarta.',
                'operator_notes' => 'Surat tugas kepala dinas terlampir valid.',
                'confirmed_at' => now()->subDays(3),
                'confirmed_via' => ConfirmationChannel::SYSTEM,
                'metadata' => [
                    'tshirt_size' => 'M',
                    'dietary_restriction' => 'Vegetarian',
                ],
            ],
            [
                'registration_code' => 'REG-202608-0003',
                'training_id' => $t2?->id,
                'customer_id' => $c3?->id,
                'verified_by' => $operator2?->id,
                'status' => RegistrationStatus::CONFIRMED,
                'graduation_status' => GraduationStatus::PASSED,
                'notes' => 'Fokus penguatan SPI RSUP Sardjito.',
                'operator_notes' => 'Verifikasi selesai, kuota instansi BLU terpenuhi.',
                'confirmed_at' => now()->subDays(8),
                'confirmed_via' => ConfirmationChannel::EMAIL,
                'metadata' => [
                    'tshirt_size' => 'XL',
                    'dietary_restriction' => 'Rendah Gula',
                ],
            ],
            [
                'registration_code' => 'REG-202608-0004',
                'training_id' => $t3?->id,
                'customer_id' => $c4?->id,
                'verified_by' => null,
                'status' => RegistrationStatus::PENDING,
                'graduation_status' => GraduationStatus::NOT_ASSESSED,
                'notes' => 'Menunggu disposisi surat tugas dari Sekretaris Dinas.',
                'operator_notes' => null,
                'confirmed_at' => null,
                'confirmed_via' => null,
                'metadata' => [
                    'tshirt_size' => 'S',
                ],
            ],
            [
                'registration_code' => 'REG-202607-0005',
                'training_id' => $t4?->id,
                'customer_id' => $c5?->id,
                'verified_by' => $operator?->id,
                'status' => RegistrationStatus::CONFIRMED,
                'graduation_status' => GraduationStatus::PASSED,
                'notes' => 'Peserta mandiri pelatihan TABK.',
                'operator_notes' => 'Pembayaran lunas dan lulus evaluasi post-test skor 92.',
                'confirmed_at' => now()->subDays(25),
                'confirmed_via' => ConfirmationChannel::SYSTEM,
                'metadata' => [
                    'tshirt_size' => 'L',
                    'post_test_score' => 92,
                ],
            ],
            [
                'registration_code' => 'REG-202607-0006',
                'training_id' => $t4?->id,
                'customer_id' => $c6?->id,
                'verified_by' => $operator?->id,
                'status' => RegistrationStatus::CONFIRMED,
                'graduation_status' => GraduationStatus::PASSED,
                'notes' => 'Peserta Inspektorat Kulon Progo.',
                'operator_notes' => 'Lulus evaluasi post-test skor 88.',
                'confirmed_at' => now()->subDays(25),
                'confirmed_via' => ConfirmationChannel::WHATSAPP,
                'metadata' => [
                    'tshirt_size' => 'M',
                    'post_test_score' => 88,
                ],
            ],
        ];

        foreach ($registrations as $reg) {
            if ($reg['training_id'] && $reg['customer_id']) {
                Registration::updateOrCreate(
                    ['registration_code' => $reg['registration_code']],
                    $reg
                );
            }
        }
    }
}
