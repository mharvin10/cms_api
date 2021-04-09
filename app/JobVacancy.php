<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class JobVacancy extends Model
{
	use Sluggable;

    const CREATED_AT = 'posted_at';

    protected $fillable = [
        'id', 'title', 'content', 'closing_date', 'created_by', 'hidden'
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

    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}
