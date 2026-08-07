<?php

namespace App\Models;

use App\Enums\ConfirmationChannel;
use App\Enums\GraduationStatus;
use App\Enums\RegistrationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'registrations';

    protected $fillable = [
        'registration_code',
        'training_id',
        'customer_id',
        'verified_by',
        'status',
        'graduation_status',
        'notes',
        'operator_notes',
        'confirmed_at',
        'confirmed_via',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'status' => RegistrationStatus::class,
            'graduation_status' => GraduationStatus::class,
            'confirmed_at' => 'datetime',
            'confirmed_via' => ConfirmationChannel::class,
            'metadata' => 'array',
        ];
    }

    public function training(): BelongsTo
    {
        return $this->belongsTo(Training::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'verified_by');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function certificate(): HasOne
    {
        return $this->hasOne(Certificate::class);
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }
}
