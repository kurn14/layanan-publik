<?php

namespace App\Enums;

enum Permission: string
{
    case MANAGE_USERS = 'manage_users';
    case MANAGE_TRAININGS = 'manage_trainings';
    case MANAGE_FACILITIES = 'manage_facilities';
    case MANAGE_FINANCE = 'manage_finance';

    public function label(): string
    {
        return match ($this) {
            self::MANAGE_USERS => 'User Management',
            self::MANAGE_TRAININGS => 'Training Management',
            self::MANAGE_FACILITIES => 'Facility Management',
            self::MANAGE_FINANCE => 'Finance',
        };
    }
}
