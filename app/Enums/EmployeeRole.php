<?php

namespace App\Enums;

enum EmployeeRole: string
{
    case ADMIN = 'admin';
    case OPERATOR = 'operator';
    case LEADER = 'leader';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrator',
            self::OPERATOR => 'Operator Layanan',
            self::LEADER => 'Pimpinan / Kepala',
        };
    }
}
