<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
	use Sluggable, SoftDeletes;

    const CREATED_AT = 'posted_at';

    protected $fillable = [
        'id', 'title', 'author', 'content', 'featured', 'thumb_image', 'photo_album', 'created_by', 'hidden'
    ];
    
    protected $dates = ['deleted_at'];

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
