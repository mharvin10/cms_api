<?php

namespace App\Http\Resources\navigations;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\Resource;

class LinkPublicBasicResource extends Resource
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
            'title' => $this->title, 40,
            'url' => $this->url,
            'thumb_image' => $this->thumb_image ? url(Storage::url($this->thumb_image)) : null
        ];
    }
}
