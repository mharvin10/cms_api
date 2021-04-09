<?php

namespace App\Http\Resources\news;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Storage;

class NewsAdminFullResource extends Resource
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
            'author' => $this->author,
            'featured' => $this->featured,
            'thumb_image' => $this->thumb_image ? url(Storage::url($this->thumb_image)) : null,
            'photo_album' => $this->photo_album,
            'content' => $this->content,
            'hidden' => boolval($this->hidden),
            'created_by' => $this->created_by,
            'posted_at' => \Carbon\Carbon::parse($this->posted_at)->format('Y-m-d'),
            'updated_at' => \Carbon\Carbon::parse($this->updated_at)->format('Y-m-d')
        ];
    }
}
