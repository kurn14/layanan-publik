<?php

namespace App\Enums;

enum ConfirmationChannel: string
{
    case SYSTEM = 'system';
    case WHATSAPP = 'whatsapp';
    case EMAIL = 'email';
    case PHONE = 'phone';

    public function label(): string
    {
        return match ($this) {
            self::SYSTEM => 'Sistem / Portal',
            self::WHATSAPP => 'WhatsApp',
            self::EMAIL => 'Email',
            self::PHONE => 'Telepon / SMS',
        };
    }
}
