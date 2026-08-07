<?php

namespace Database\Seeders;

use App\Enums\FacilityType;
use App\Models\Facility;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $facilities = [
            [
                'name' => 'Ruang Kelas Malioboro',
                'type' => FacilityType::CLASSROOM,
                'description' => 'Ruang kelas ber-AC lengkap dengan smart display 75 inch, sound system nirkabel, mic podium, meja formasi U-shape/Classroom, dan akses WiFi berkecepatan tinggi.',
                'capacity' => 35,
                'price_per_day' => 1500000.00,
                'photo_path' => 'facilities/malioboro.jpg',
                'is_active' => true,
                'metadata' => [
                    'floor' => 'Lantai 2 Gedung Utama',
                    'screen_type' => 'Smart Interactive Flat Panel 75"',
                ],
            ],
            [
                'name' => 'Ruang Kelas Prambanan',
                'type' => FacilityType::CLASSROOM,
                'description' => 'Ruang kelas representatif dengan kapasitas hingga 45 peserta, dilengkapi dual proyektor laser HD, acoustic wall panel, podium digital, dan tata suara surround.',
                'capacity' => 45,
                'price_per_day' => 2000000.00,
                'photo_path' => 'facilities/prambanan.jpg',
                'is_active' => true,
                'metadata' => [
                    'floor' => 'Lantai 2 Gedung Utama',
                    'screen_type' => 'Dual Laser Projector',
                ],
            ],
            [
                'name' => 'Auditorium Merapi',
                'type' => FacilityType::CLASSROOM,
                'description' => 'Aula serbaguna untuk seminar, pelantikan, rapat koordinasi pengawasan, dan lokakarya berskala besar hingga 150 tamu dengan panggung VIP dan ruang transit pimpinan.',
                'capacity' => 150,
                'price_per_day' => 5000000.00,
                'photo_path' => 'facilities/merapi.jpg',
                'is_active' => true,
                'metadata' => [
                    'floor' => 'Lantai 1 Sayap Barat',
                    'has_vip_room' => true,
                    'videotron' => 'LED Videotron P2.5 (6x3 meter)',
                ],
            ],
            [
                'name' => 'Laboratorium Komputer & Forensik Digital',
                'type' => FacilityType::CLASSROOM,
                'description' => 'Laboratorium dengan 30 PC workstation spesifikasi tinggi (Core i7, 32GB RAM, SSD NVMe), jaringan LAN gigabit terisolasi, dan lisensi software analitik audit.',
                'capacity' => 30,
                'price_per_day' => 3000000.00,
                'photo_path' => 'facilities/lab_komputer.jpg',
                'is_active' => true,
                'metadata' => [
                    'pc_count' => 30,
                    'lan_speed' => '1 Gbps Dedicated',
                ],
            ],
            [
                'name' => 'Paket Modul Pembelajaran & Panduan Teknis Audit',
                'type' => FacilityType::MODULE,
                'description' => 'Buku pedoman cetak hardcopy eksklusif, suplemen studi kasus, template kertas kerja audit Excel terstandar BPKP, dan akses flashdisk materi.',
                'capacity' => null,
                'price_per_day' => 250000.00,
                'photo_path' => 'facilities/modul.jpg',
                'is_active' => true,
                'metadata' => [
                    'format' => 'Cetak Hardcover + Softcopy USB',
                ],
            ],
            [
                'name' => 'Layanan Catering Prasmanan & 2x Coffee Break VIP',
                'type' => FacilityType::CATERING,
                'description' => 'Menu makan siang prasmanan nusantara bergizi seimbang, 2 kali rehat kopi/teh beserta aneka kudapan tradisional Yogyakarta.',
                'capacity' => null,
                'price_per_day' => 110000.00,
                'photo_path' => 'facilities/catering.jpg',
                'is_active' => true,
                'metadata' => [
                    'unit' => 'per orang per hari',
                    'halal_certified' => true,
                ],
            ],
            [
                'name' => 'Kamar Wisma Tamu / Asrama Diklat BPKP (Twin-Bed)',
                'type' => FacilityType::OTHER,
                'description' => 'Akomodasi penginapan nyaman ber-AC, 2 tempat tidur single, kamar mandi dalam dengan water heater, smart TV, dan sarapan pagi.',
                'capacity' => 2,
                'price_per_day' => 350000.00,
                'photo_path' => 'facilities/wisma.jpg',
                'is_active' => true,
                'metadata' => [
                    'room_type' => 'Twin Superior',
                    'breakfast_included' => true,
                ],
            ],
        ];

        foreach ($facilities as $facility) {
            Facility::updateOrCreate(
                ['name' => $facility['name']],
                $facility
            );
        }
    }
}
