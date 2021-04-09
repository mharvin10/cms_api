<?php

namespace App\Http\Resources\carousel_images;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Storage;

class CarouselImagesPublicBasicResource extends Resource
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
            'title' => $this->title,
            'src' => $this->src ? url(Storage::url($this->src)) : null,
            'url' => $this->url
        ];
    }
}
