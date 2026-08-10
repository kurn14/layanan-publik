<?php

namespace App\Models;

use App\Enums\FacilityType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facility extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'facilities';

    protected $fillable = [
        'name',
        'type',
        'description',
        'capacity',
        'price_per_day',

        'is_active',

    ];

    protected function casts(): array
    {
        return [
            'type' => FacilityType::class,
            'capacity' => 'integer',
            'price_per_day' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function photos()
    {
        return $this->hasMany(FacilityPhoto::class)->orderBy('sort');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(FacilityBooking::class);
    }
}
