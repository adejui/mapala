<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityDetail extends Model
{
    protected $fillable = [
        'activity_id',
        'start_time',
        'end_time',
        'participant_requirements',
        'location_detail',
        'map_link',
        'contact_name',
        'contact_phone',
        'contact_role',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
