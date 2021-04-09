<?php

namespace App\Http\Resources\photos;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\Resource;

class PhotoAdminBasicResource extends Resource
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
            'caption' => str_limit($this->caption, 100),
            // 'created_by' => $this->created_by,
            // 'created_at' => \Carbon\Carbon::parse($this->posted_on)->format('Y-m-d')
        ];
    }
}
