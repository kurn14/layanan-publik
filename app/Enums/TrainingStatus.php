<?php

namespace App\Enums;

enum TrainingStatus: string
{
    case DRAFT = 'draft';
    case OPEN = 'open';
    case FULL = 'full';
    case ONGOING = 'ongoing';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::OPEN => 'Pendaftaran Dibuka',
            self::FULL => 'Kuota Penuh',
            self::ONGOING => 'Sedang Berlangsung',
            self::COMPLETED => 'Selesai',
            self::CANCELLED => 'Dibatalkan',
        };
    }
}
