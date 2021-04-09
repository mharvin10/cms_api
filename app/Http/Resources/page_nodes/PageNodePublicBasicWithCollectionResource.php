<?php

namespace App\Http\Resources\page_nodes;

use App\Http\Resources\page_nodes\PageNodePublicBasicResource;
use Illuminate\Http\Resources\Json\Resource;

class PageNodePublicBasicWithCollectionResource extends Resource
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
            'url' => !$this->pageContent ? NULL : '/' . $this->pageContent->slug,
            'pages' => $this->pageContent ? NULL : PageNodePublicBasicWithCollectionResource::collection($this->children()->where('hidden', 0)->defaultOrder()->get())
        ];
    }
}
