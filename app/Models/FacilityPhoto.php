<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacilityPhoto extends Model
{
    protected $fillable = [
        'facility_id',
        'description',
        'path',
        'sort',
    ];

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }
}
