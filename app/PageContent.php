<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
	use Sluggable;

    protected $primaryKey = 'page_node_id';

	protected $touches = ['pageNode'];

    protected $fillable = [
        'page_node_id', 'slug', 'body', 'header_image', 'redirect_url'
    ];

    public $incrementing = false;

    public $timestamps = false;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'pageNode.title'
            ]
        ];
    }

    public function pageNode()
    {
    	return $this->belongsTo('App\PageNode');
    }
}
