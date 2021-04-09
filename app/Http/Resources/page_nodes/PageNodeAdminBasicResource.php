<?php

namespace App\Http\Resources\page_nodes;

use Illuminate\Http\Resources\Json\Resource;

class PageNodeAdminBasicResource extends Resource
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
            'isPage' => $this->pageContent ? true : false,
            'depth' => $this->depth,
            'hidden' => boolval($this->hidden),
            'created_by' => $this->created_by !== 'system' ? $this->user->name : NULL,
            'created_at' => \Carbon\Carbon::parse($this->created_at)->format('Y-m-d'),
            'updated_at' => \Carbon\Carbon::parse($this->updated_at)->format('Y-m-d')
        ];
    }
}
