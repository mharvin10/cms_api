<?php

namespace App\Http\Resources\navigations;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Storage;

class LinkAdminFullResource extends Resource
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
            'url' => $this->url,
            'thumb_image' => $this->thumb_image ? url(Storage::url($this->thumb_image)) : null,
            'disposition' => $this->disposition,
            'hidden' => boolval($this->hidden),
            'created_by' => $this->created_by,
            'created_at' => \Carbon\Carbon::parse($this->created_at)->format('Y-m-d'),
            'updated_at' => \Carbon\Carbon::parse($this->updated_at)->format('Y-m-d')
        ];
    }
}
