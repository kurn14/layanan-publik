<?php

namespace App\Enums;

enum AttendanceStatus: string
{
    case PRESENT = 'present';
    case PERMITTED = 'permitted';
    case SICK = 'sick';
    case ABSENT = 'absent';

    public function label(): string
    {
        return match ($this) {
            self::PRESENT => 'Hadir',
            self::PERMITTED => 'Izin',
            self::SICK => 'Sakit',
            self::ABSENT => 'Tanpa Keterangan (Alpa)',
        };
    }
}
