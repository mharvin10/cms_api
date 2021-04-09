<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class CalendarDate extends Model
{
	use Sluggable;

    protected $fillable = [
        'id', 'calendar_date', 'title', 'type', 'holiday_type', 'details', 'created_by', 'hidden'
    ];

    public $incrementing = false;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
