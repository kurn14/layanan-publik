<?php

namespace App\Models;

use App\Enums\BookingStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class FacilityBooking extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'facility_bookings';

    protected $fillable = [
        'facility_id',
        'customer_id',
        'event_name',
        'start_date',
        'end_date',
        'guest_count',
        'total_cost',
        'status',
        'arrival_confirmed',
        'cancellation_fee',
        'notes',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'guest_count' => 'integer',
            'total_cost' => 'decimal:2',
            'status' => BookingStatus::class,
            'arrival_confirmed' => 'boolean',
            'cancellation_fee' => 'decimal:2',
            'metadata' => 'array',
        ];
    }

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }
}
