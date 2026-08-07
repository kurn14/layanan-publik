<?php

namespace App\Models;

use App\Enums\TrainingStatus;
use App\Enums\TrainingType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Training extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'trainings';

    protected $fillable = [
        'name',
        'type',
        'description',
        'duration_days',
        'requirements',
        'start_date',
        'end_date',
        'location',
        'max_quota',
        'filled_quota',
        'status',
        'is_active',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'type' => TrainingType::class,
            'duration_days' => 'integer',
            'start_date' => 'date',
            'end_date' => 'date',
            'max_quota' => 'integer',
            'filled_quota' => 'integer',
            'status' => TrainingStatus::class,
            'is_active' => 'boolean',
            'metadata' => 'array',
        ];
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }
}
