<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case BANK_TRANSFER = 'bank_transfer';
    case CASH = 'cash';
    case QRIS = 'qris';

    public function label(): string
    {
        return match ($this) {
            self::BANK_TRANSFER => 'Transfer Bank',
            self::CASH => 'Tunai / Kasir',
            self::QRIS => 'QRIS',
        };
    }
}
