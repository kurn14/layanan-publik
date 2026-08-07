<?php

namespace App\Enums;

enum CertificateStatus: string
{
    case DRAFT = 'draft';
    case ISSUED = 'issued';
    case REVOKED = 'revoked';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::ISSUED => 'Diterbitkan',
            self::REVOKED => 'Dicabut',
        };
    }
}
