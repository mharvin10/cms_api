<?php

namespace App\Http\Resources\announcements;

use Illuminate\Http\Resources\Json\Resource;

class AnnouncementAdminBasicResource extends Resource
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
            'slug' => $this->slug,
            'title' => str_limit($this->title, 40),
            'hidden' => boolval($this->hidden),
            'created_by' => $this->created_by,
            'posted_at' => \Carbon\Carbon::parse($this->posted_at)->format('Y-m-d'),
            'updated_at' => \Carbon\Carbon::parse($this->updated_at)->format('Y-m-d')
        ];
    }
}