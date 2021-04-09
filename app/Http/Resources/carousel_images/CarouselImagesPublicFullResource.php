<?php

namespace App\Http\Resources\carousel_images;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Storage;

class CarouselImagesPublicFullResource extends Resource
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
            'url' => $this->url,
            'disposition' => $this->disposition,
            'hidden' => boolval($this->hidden),
            'created_by' => $this->created_by,
            'created_at' => \Carbon\Carbon::parse($this->created_at)->format('Y-m-d'),
            'updated_at' => \Carbon\Carbon::parse($this->updated_at)->format('Y-m-d')
        ];
    }
}