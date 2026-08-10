<?php

namespace Database\Seeders;

use App\Enums\FacilityType;
use App\Models\Facility;
use App\Models\FacilityPhoto;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $facilities = [
            [
                'name' => ['id' => 'Ruang Kelas Malioboro', 'en' => 'Malioboro Classroom'],
                'type' => FacilityType::CLASSROOM,
                'description' => ['id' => 'Ruang kelas ber-AC lengkap dengan smart display 75 inch, sound system nirkabel, mic podium, meja formasi U-shape/Classroom, dan akses WiFi berkecepatan tinggi.', 'en' => 'AC classroom complete with 75-inch smart display, wireless sound system, podium mic, U-shape/Classroom table formation, and high-speed WiFi access.'],
                'capacity' => 35,
                'price_per_day' => 1500000.00,
                'is_active' => true,
                'photo_path' => 'facilities/malioboro.jpg', // temporary for seeding photo
            ],
            [
                'name' => ['id' => 'Ruang Kelas Prambanan', 'en' => 'Prambanan Classroom'],
                'type' => FacilityType::CLASSROOM,
                'description' => ['id' => 'Ruang kelas representatif dengan kapasitas hingga 45 peserta, dilengkapi dual proyektor laser HD, acoustic wall panel, podium digital, dan tata suara surround.', 'en' => 'Representative classroom with a capacity of up to 45 participants, equipped with dual HD laser projectors, acoustic wall panels, digital podium, and surround sound system.'],
                'capacity' => 45,
                'price_per_day' => 2000000.00,
                'is_active' => true,
                'photo_path' => 'facilities/prambanan.jpg',
            ],
            [
                'name' => ['id' => 'Auditorium Merapi', 'en' => 'Merapi Auditorium'],
                'type' => FacilityType::CLASSROOM,
                'description' => ['id' => 'Aula serbaguna untuk seminar, pelantikan, rapat koordinasi pengawasan, dan lokakarya berskala besar hingga 150 tamu dengan panggung VIP dan ruang transit pimpinan.', 'en' => 'Multipurpose hall for seminars, inaugurations, coordination meetings, and large-scale workshops for up to 150 guests with a VIP stage and VIP transit room.'],
                'capacity' => 150,
                'price_per_day' => 5000000.00,
                'is_active' => true,
                'photo_path' => 'facilities/merapi.jpg',
            ],
            [
                'name' => ['id' => 'Laboratorium Komputer & Forensik Digital', 'en' => 'Computer & Digital Forensics Laboratory'],
                'type' => FacilityType::CLASSROOM,
                'description' => ['id' => 'Laboratorium dengan 30 PC workstation spesifikasi tinggi (Core i7, 32GB RAM, SSD NVMe), jaringan LAN gigabit terisolasi, dan lisensi software analitik audit.', 'en' => 'Laboratory with 30 high-spec PC workstations (Core i7, 32GB RAM, NVMe SSD), isolated gigabit LAN network, and audit analytic software licenses.'],
                'capacity' => 30,
                'price_per_day' => 3000000.00,
                'is_active' => true,
                'photo_path' => 'facilities/lab_komputer.jpg',
            ],
            [
                'name' => ['id' => 'Paket Modul Pembelajaran & Panduan Teknis Audit', 'en' => 'Learning Module & Audit Technical Guide Package'],
                'type' => FacilityType::MODULE,
                'description' => ['id' => 'Buku pedoman cetak hardcopy eksklusif, suplemen studi kasus, template kertas kerja audit Excel terstandar BPKP, dan akses flashdisk materi.', 'en' => 'Exclusive printed hardcopy guidebooks, case study supplements, standardized BPKP Excel audit working paper templates, and flash drive access to materials.'],
                'capacity' => null,
                'price_per_day' => 250000.00,
                'is_active' => true,
                'photo_path' => 'facilities/modul.jpg',
            ],
            [
                'name' => ['id' => 'Layanan Catering Prasmanan & 2x Coffee Break VIP', 'en' => 'Buffet Catering & 2x VIP Coffee Break Service'],
                'type' => FacilityType::CATERING,
                'description' => ['id' => 'Menu makan siang prasmanan nusantara bergizi seimbang, 2 kali rehat kopi/teh beserta aneka kudapan tradisional Yogyakarta.', 'en' => 'Balanced nutritious Indonesian buffet lunch menu, 2 times coffee/tea break along with various traditional Yogyakarta snacks.'],
                'capacity' => null,
                'price_per_day' => 110000.00,
                'is_active' => true,
                'photo_path' => 'facilities/catering.jpg',
            ],
            [
                'name' => ['id' => 'Kamar Wisma Tamu / Asrama Diklat BPKP (Twin-Bed)', 'en' => 'Guest House / BPKP Training Dormitory Room (Twin-Bed)'],
                'type' => FacilityType::OTHER,
                'description' => ['id' => 'Akomodasi penginapan nyaman ber-AC, 2 tempat tidur single, kamar mandi dalam dengan water heater, smart TV, dan sarapan pagi.', 'en' => 'Comfortable air-conditioned accommodation, 2 single beds, en-suite bathroom with water heater, smart TV, and breakfast.'],
                'capacity' => 2,
                'price_per_day' => 350000.00,
                'is_active' => true,
                'photo_path' => 'facilities/wisma.jpg',
            ],
        ];

        Facility::query()->delete();
        FacilityPhoto::query()->delete();

        foreach ($facilities as $facilityData) {
            $photoPath = $facilityData['photo_path'];
            unset($facilityData['photo_path']);

            $facility = Facility::create($facilityData);

            FacilityPhoto::create([
                'facility_id' => $facility->id,
                'path' => $photoPath,
                'description' => ['id' => 'Foto utama ' . $facility->name, 'en' => 'Main photo of ' . $facility->name],
                'sort' => 1,
            ]);
        }
    }
}
