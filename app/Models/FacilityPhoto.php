<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Translatable\HasTranslations;

class FacilityPhoto extends Model
{
    use HasTranslations;

    public $translatable = ['description'];
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
