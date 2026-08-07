<?php

namespace App\Enums;

enum ClientType: string
{
    case INDIVIDUAL = 'individual';
    case INSTITUTIONAL = 'institutional';

    public function label(): string
    {
        return match ($this) {
            self::INDIVIDUAL => 'Perorangan / Individu',
            self::INSTITUTIONAL => 'Instansi / Lembaga',
        };
    }
}
