<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarouselImage extends Model
{
    protected $fillable = [
        'id', 'title', 'src', 'url', 'disposition', 'created_by', 'hidden'
    ];

    public $incrementing = false;
}
