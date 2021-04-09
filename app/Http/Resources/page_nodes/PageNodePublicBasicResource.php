<?php

namespace App\Http\Resources\page_nodes;

use Illuminate\Http\Resources\Json\Resource;

class PageNodePublicBasicResource extends Resource
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
            'title' => $this->short_title ? $this->short_title : $this->title,
            'type' => $this->pageContent ? 'page' : 'section',
            'url' => !$this->pageContent ? NULL : '/' . $this->pageContent->slug
        ];
    }
}
