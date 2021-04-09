<?php

namespace App\Http\Resources\albums;

use App\Http\Resources\photos\PhotoAdminBasicResource;
use Illuminate\Http\Resources\Json\Resource;

class AlbumAdminFullResource extends Resource
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
            'description' => $this->description,
            'photos' => PhotoAdminBasicResource::collection($this->photos),
            'photo_count' => count($this->photos),
            'hidden' => boolval($this->hidden),
            'created_by' => $this->created_by,
            'created_at' => \Carbon\Carbon::parse($this->posted_on)->format('Y-m-d')
        ];
    }
}
