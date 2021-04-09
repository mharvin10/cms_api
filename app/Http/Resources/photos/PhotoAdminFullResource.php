<?php

namespace App\Http\Resources\photos;

use App\Http\Resources\albums\AlbumAdminBasicResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\Resource;

class PhotoAdminFullResource extends Resource
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
            'url' => $this->src ? url(Storage::url($this->src)) : null,
            'caption' => $this->caption,
            'album' => new AlbumAdminBasicResource($this->album),
            'created_by' => $this->created_by,
            'created_at' => \Carbon\Carbon::parse($this->posted_on)->format('Y-m-d')
        ];
    }
}
