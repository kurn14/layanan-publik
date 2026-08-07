<?php

namespace App\Enums;

enum FacilityType: string
{
    case CLASSROOM = 'classroom';
    case MODULE = 'module';
    case CATERING = 'catering';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::CLASSROOM => 'Ruang Kelas / Aula',
            self::MODULE => 'Modul Pelatihan / Materi',
            self::CATERING => 'Konsumsi / Katering',
            self::OTHER => 'Fasilitas Lainnya',
        };
    }
}
