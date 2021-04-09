<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use Sluggable;

    protected $fillable = [
        'id', 'title', 'description', 'created_by', 'hidden'
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

    public function photos()
    {
    	return $this->hasMany('App\Photo');
    }

    public function createdBy()
    {
    	return $this->belongsTo('App\User', 'created_by');
    }
}
