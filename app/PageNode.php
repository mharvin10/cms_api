<?php

namespace App;

use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageNode extends Model
{
		use NodeTrait, SoftDeletes;

    protected $fillable = [
        'id', 'title', 'short_title', 'created_by', 'hidden'
    ];

    protected $dates = ['deleted_at'];

    public $incrementing = false;

    public function pageContent()
    {
    	return $this->hasOne('App\PageContent');
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'created_by');
    }
}
