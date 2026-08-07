<?php

namespace Database\Seeders;

use App\Enums\TrainingStatus;
use App\Enums\TrainingType;
use App\Models\Training;
use Illuminate\Database\Seeder;

class TrainingSeeder extends Seeder
{
    public function run(): void
    {
        $trainings = [
            [
                'name' => 'Pelatihan Audit Investigatif & Penghitungan Kerugian Keuangan Negara (PKKN)',
                'type' => TrainingType::TECHNICAL,
                'description' => 'Pelatihan teknis pengumpulan bukti digital dan fisik, wawancara investigatif, serta metodologi perhitungan kerugian keuangan negara sesuai standar audit BPKP.',
                'duration_days' => 5,
                'requirements' => 'Minimal S1/D4 Akuntansi, Hukum, atau Teknik; Berpengalaman di bidang pengawasan minimal 2 tahun.',
                'start_date' => '2026-09-01',
                'end_date' => '2026-09-05',
                'location' => 'Gedung Diklat BPKP DIY — Ruang Kelas Malioboro',
                'max_quota' => 30,
                'filled_quota' => 3,
                'status' => TrainingStatus::OPEN,
                'is_active' => true,
                'metadata' => [
                    'curriculum_version' => '2026.1',
                    'lead_instructor' => 'Dr. H. Sukamto, Ak., M.Si., CFrA.',
                ],
            ],
            [
                'name' => 'Pelatihan Penilaian Maturitas Penyelenggaraan SPIP Terintegrasi',
                'type' => TrainingType::FUNCTIONAL,
                'description' => 'Bimbingan teknis implementasi Sistem Pengendalian Intern Pemerintah (SPIP) terintegrasi menuju Level 3/4 bagi APIP dan Satgas OPD.',
                'duration_days' => 4,
                'requirements' => 'Anggota Tim Satgas SPIP atau Pejabat Pengawas Urusan Pemerintahan Daerah.',
                'start_date' => '2026-09-15',
                'end_date' => '2026-09-18',
                'location' => 'Gedung Diklat BPKP DIY — Ruang Kelas Prambanan',
                'max_quota' => 40,
                'filled_quota' => 40,
                'status' => TrainingStatus::FULL,
                'is_active' => true,
                'metadata' => [
                    'curriculum_version' => '2026.2',
                    'lead_instructor' => 'Agung Wibowo, S.E., M.Acc., Ak.',
                ],
            ],
            [
                'name' => 'Pelatihan Manajemen Risiko Sektor Publik & Good Governance (GRC)',
                'type' => TrainingType::MANAGERIAL,
                'description' => 'Penguatan kapabilitas pimpinan dan administrator instansi dalam identifikasi risiko strategis, mitigasi fraud, dan kepatuhan regulasi.',
                'duration_days' => 3,
                'requirements' => 'Pejabat Administrator, Pejabat Pengawas, atau Pimpinan Satker/BLU/BUMD.',
                'start_date' => '2026-10-06',
                'end_date' => '2026-10-08',
                'location' => 'Auditorium Merapi BPKP DIY',
                'max_quota' => 50,
                'filled_quota' => 12,
                'status' => TrainingStatus::OPEN,
                'is_active' => true,
                'metadata' => [
                    'curriculum_version' => '2025.3',
                    'lead_instructor' => 'Dra. Endang Purwanti, M.M., CA.',
                ],
            ],
            [
                'name' => 'Pelatihan Teknik Audit Berbantuan Komputer (TABK) dengan Data Analytics',
                'type' => TrainingType::TECHNICAL,
                'description' => 'Pelatihan pengolahan data transaksi skala besar, deteksi anomali anggaran, dan analisis forensik digital menggunakan alat bantu audit modern.',
                'duration_days' => 5,
                'requirements' => 'Auditor APIP / Internal Auditor BUMD; Membawa laptop RAM minimal 8 GB.',
                'start_date' => '2026-07-20',
                'end_date' => '2026-07-24',
                'location' => 'Laboratorium Komputer BPKP DIY',
                'max_quota' => 25,
                'filled_quota' => 25,
                'status' => TrainingStatus::COMPLETED,
                'is_active' => true,
                'metadata' => [
                    'curriculum_version' => '2026.1',
                    'software' => 'ACL Analytics v16 / Python Pandas',
                ],
            ],
            [
                'name' => 'Pelatihan Pengawasan Pengadaan Barang & Jasa (PBJ) Pemerintah',
                'type' => TrainingType::TECHNICAL,
                'description' => 'Probity audit PBJ dari tahap perencanaan, pemilihan penyedia, hingga serah terima hasil pekerjaan konstruksi dan non-konstruksi.',
                'duration_days' => 4,
                'requirements' => 'Memiliki sertifikat Tingkat Dasar PBJ dari LKPP.',
                'start_date' => '2026-11-10',
                'end_date' => '2026-11-13',
                'location' => 'Gedung Diklat BPKP DIY — Ruang Borobudur',
                'max_quota' => 35,
                'filled_quota' => 0,
                'status' => TrainingStatus::DRAFT,
                'is_active' => true,
                'metadata' => [
                    'curriculum_version' => '2026.2',
                ],
            ],
        ];

        foreach ($trainings as $training) {
            Training::updateOrCreate(
                ['name' => $training['name']],
                $training
            );
        }
    }
}
