<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    protected $fillable = [
        'id', 'page_node_id', 'type', 'title', 'thumb_image', 'url', 'disposition', 'hidden'
    ];

    // public $timestamps = false;

    public function pageNode()
    {
    	return $this->belongsTo('App\PageNode');
    }
}
