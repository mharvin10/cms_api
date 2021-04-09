<?php

namespace App\Http\Resources\navigations;

use App\Http\Resources\page_nodes\PageNodePublicBasicWithCollectionResource;
use Illuminate\Http\Resources\Json\Resource;

class MainMenuPublicBasicWithCollectionResource extends Resource
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
            'title' => $this->pageNode->short_title ? $this->pageNode->short_title : $this->pageNode->title,
            'type' => $this->pageNode->pageContent ? 'page' : 'section',
            'url' => !$this->pageNode->pageContent ? NULL : '/' . $this->pageNode->pageContent->slug,
            'pages' => $this->pageNode->pageContent ? NULL : PageNodePublicBasicWithCollectionResource::collection($this->pageNode->children()->where('hidden', 0)->defaultOrder()->get())
        ];
    }
}
