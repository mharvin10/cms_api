<?php

namespace App\Http\Resources\albums;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\Resource;

class AlbumAdminBasicResource extends Resource
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
            'title' => str_limit($this->title, 50),
            'description' => str_limit($this->description, 100),
            'rand_photo' => count($this->photos) ? url(Storage::url($this->photos->random(1)->first()->src)) : null,
            'photo_count' => count($this->photos),
            'hidden' => boolval($this->hidden),
            'created_by' => $this->created_by,
            'created_at' => \Carbon\Carbon::parse($this->posted_on)->format('Y-m-d')
        ];
    }
}
