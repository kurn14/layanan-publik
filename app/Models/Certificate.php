<?php

namespace App\Models;

use App\Enums\CertificateStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    use HasFactory;

    protected $table = 'certificates';

    protected $fillable = [
        'registration_id',
        'certificate_number',
        'issued_date',
        'status',
        'file_path',

    ];

    protected function casts(): array
    {
        return [
            'issued_date' => 'date',
            'status' => CertificateStatus::class,

        ];
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }
}
