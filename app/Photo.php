<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'id', 'src', 'caption', 'album_id', 'created_by'
    ];

    public $incrementing = false;

    public function album()
    {
    	return $this->belongsTo('App\Album');
    }

    public function createdBy()
    {
    	return $this->belongsTo('App\User', 'created_by');
    }
}
