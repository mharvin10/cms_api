<?php

namespace App\Http\Resources\page_nodes;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Storage;

class PageAdminBasicResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => str_limit($this->title, 40),
            'short_title' => str_limit($this->short_title, 40),
            'slug' => $this->pageContent->slug,
            'url' => '/' . $this->pageContent->slug,
            'body' => str_limit($this->pageContent->body, 150),
            'header_image' => $this->pageContent->header_image ? url(Storage::url($this->pageContent->header_image)) : null,
            'redirect_url' => $this->pageContent->redirect_url,
            'depth' => $this->depth,
            'hidden' => boolval($this->hidden),
            'created_by' => $this->created_by,
            'created_at' => \Carbon\Carbon::parse($this->created_at)->format('Y-m-d'),
            'updated_at' => \Carbon\Carbon::parse($this->updated_at)->format('Y-m-d')
        ];
    }
}
