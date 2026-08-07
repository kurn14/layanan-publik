<?php

namespace App\Enums;

enum GraduationStatus: string
{
    case NOT_ASSESSED = 'not_assessed';
    case PASSED = 'passed';
    case FAILED = 'failed';

    public function label(): string
    {
        return match ($this) {
            self::NOT_ASSESSED => 'Belum Dinilai',
            self::PASSED => 'Lulus',
            self::FAILED => 'Tidak Lulus',
        };
    }
}
