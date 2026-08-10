<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacilityPhoto extends Model
{
    protected $fillable = [
        'facility_id',
        'deskripsi',
        'path',
        'sort',
    ];

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }
}
