<?php

namespace App\Enums;

enum InvoiceStatus: string
{
    case DRAFT = 'draft';
    case SENT = 'sent';
    case PAID = 'paid';
    case SETTLED = 'settled';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::SENT => 'Terkirim ke Klien',
            self::PAID => 'Sudah Dibayar (Menunggu Verifikasi)',
            self::SETTLED => 'Lunas / Terverifikasi',
            self::CANCELLED => 'Dibatalkan',
        };
    }
}
