<?php

namespace App\Http\Resources\page_nodes;

use Illuminate\Http\Resources\Json\Resource;

class PagePublicFullResource extends Resource
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
            'title' => $this->title,
            'short_title' => $this->short_title,
            'slug' => $this->pageContent->slug,
            'body' => $this->pageContent->body,
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
