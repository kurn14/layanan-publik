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
                'name' => ['id' => 'Pelatihan Audit Investigatif & Penghitungan Kerugian Keuangan Negara (PKKN)', 'en' => 'Investigative Audit & State Financial Loss Calculation Training'],
                'type' => TrainingType::TECHNICAL,
                'description' => ['id' => 'Pelatihan teknis pengumpulan bukti digital dan fisik, wawancara investigatif, serta metodologi perhitungan kerugian keuangan negara sesuai standar audit BPKP.', 'en' => 'Technical training on collecting digital and physical evidence, investigative interviews, and methodology for calculating state financial losses.'],
                'duration_days' => 5,
                'requirements' => ['id' => 'Minimal S1/D4 Akuntansi, Hukum, atau Teknik; Berpengalaman di bidang pengawasan minimal 2 tahun.', 'en' => 'Minimum Bachelor degree in Accounting, Law, or Engineering; Minimum 2 years experience in supervision.'],
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
                'name' => ['id' => 'Pelatihan Penilaian Maturitas Penyelenggaraan SPIP Terintegrasi', 'en' => 'Integrated SPIP Maturity Assessment Training'],
                'type' => TrainingType::FUNCTIONAL,
                'description' => ['id' => 'Bimbingan teknis implementasi Sistem Pengendalian Intern Pemerintah (SPIP) terintegrasi menuju Level 3/4 bagi APIP dan Satgas OPD.', 'en' => 'Technical guidance on implementing the integrated Government Internal Control System (SPIP) towards Level 3/4.'],
                'duration_days' => 4,
                'requirements' => ['id' => 'Anggota Tim Satgas SPIP atau Pejabat Pengawas Urusan Pemerintahan Daerah.', 'en' => 'Member of SPIP Task Force or Regional Government Supervisory Official.'],
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
                'name' => ['id' => 'Pelatihan Manajemen Risiko Sektor Publik & Good Governance (GRC)', 'en' => 'Public Sector Risk Management & Good Governance Training'],
                'type' => TrainingType::MANAGERIAL,
                'description' => ['id' => 'Penguatan kapabilitas pimpinan dan administrator instansi dalam identifikasi risiko strategis, mitigasi fraud, dan kepatuhan regulasi.', 'en' => 'Strengthening capabilities of leaders and administrators in identifying strategic risks, fraud mitigation, and regulatory compliance.'],
                'duration_days' => 3,
                'requirements' => ['id' => 'Pejabat Administrator, Pejabat Pengawas, atau Pimpinan Satker/BLU/BUMD.', 'en' => 'Administrator, Supervisory Official, or Head of Work Unit/BLU/BUMD.'],
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
                'name' => ['id' => 'Pelatihan Teknik Audit Berbantuan Komputer (TABK) dengan Data Analytics', 'en' => 'Computer-Assisted Audit Techniques (CAATs) with Data Analytics Training'],
                'type' => TrainingType::TECHNICAL,
                'description' => ['id' => 'Pelatihan pengolahan data transaksi skala besar, deteksi anomali anggaran, dan analisis forensik digital menggunakan alat bantu audit modern.', 'en' => 'Training on processing large-scale transaction data, detecting budget anomalies, and digital forensic analysis using modern audit tools.'],
                'duration_days' => 5,
                'requirements' => ['id' => 'Auditor APIP / Internal Auditor BUMD; Membawa laptop RAM minimal 8 GB.', 'en' => 'APIP Auditor / BUMD Internal Auditor; Bring a laptop with at least 8 GB RAM.'],
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
                'name' => ['id' => 'Pelatihan Pengawasan Pengadaan Barang & Jasa (PBJ) Pemerintah', 'en' => 'Government Procurement Supervision Training'],
                'type' => TrainingType::TECHNICAL,
                'description' => ['id' => 'Probity audit PBJ dari tahap perencanaan, pemilihan penyedia, hingga serah terima hasil pekerjaan konstruksi dan non-konstruksi.', 'en' => 'Probity audit of procurement from planning, vendor selection, to handover of construction and non-construction work results.'],
                'duration_days' => 4,
                'requirements' => ['id' => 'Memiliki sertifikat Tingkat Dasar PBJ dari LKPP.', 'en' => 'Hold a Basic Procurement Certificate from LKPP.'],
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

        Training::query()->delete();

        foreach ($trainings as $training) {
            Training::create($training);
        }
    }
}
