<?php

namespace App\Enums;

enum TrainingType: string
{
    case TECHNICAL = 'technical';
    case MANAGERIAL = 'managerial';
    case FUNCTIONAL = 'functional';

    public function label(): string
    {
        return match ($this) {
            self::TECHNICAL => 'Pelatihan Teknis',
            self::MANAGERIAL => 'Pelatihan Manajerial',
            self::FUNCTIONAL => 'Pelatihan Fungsional',
        };
    }
}
