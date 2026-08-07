<?php

namespace Database\Seeders;

use App\Enums\CertificateStatus;
use App\Models\Certificate;
use App\Models\Registration;
use Illuminate\Database\Seeder;

class CertificateSeeder extends Seeder
{
    public function run(): void
    {
        $reg5 = Registration::where('registration_code', 'REG-202607-0005')->first();
        $reg6 = Registration::where('registration_code', 'REG-202607-0006')->first();

        $certificates = [
            [
                'registration_id' => $reg5?->id,
                'certificate_number' => 'CERT-202607-0001',
                'issued_date' => '2026-07-25',
                'status' => CertificateStatus::ISSUED,
                'file_path' => 'certificates/CERT-202607-0001.pdf',
                'metadata' => [
                    'signatory_name' => 'Drs. Bambang Sudiro, Ak., M.M., CA., CFrA.',
                    'signatory_position' => 'Kepala Perwakilan BPKP DIY',
                    'hours_credit' => 40,
                    'grade' => 'Sangat Baik (A)',
                ],
            ],
            [
                'registration_id' => $reg6?->id,
                'certificate_number' => 'CERT-202607-0002',
                'issued_date' => '2026-07-25',
                'status' => CertificateStatus::ISSUED,
                'file_path' => 'certificates/CERT-202607-0002.pdf',
                'metadata' => [
                    'signatory_name' => 'Drs. Bambang Sudiro, Ak., M.M., CA., CFrA.',
                    'signatory_position' => 'Kepala Perwakilan BPKP DIY',
                    'hours_credit' => 40,
                    'grade' => 'Baik (B+)',
                ],
            ],
        ];

        foreach ($certificates as $cert) {
            if ($cert['registration_id']) {
                Certificate::updateOrCreate(
                    ['certificate_number' => $cert['certificate_number']],
                    $cert
                );
            }
        }
    }
}
