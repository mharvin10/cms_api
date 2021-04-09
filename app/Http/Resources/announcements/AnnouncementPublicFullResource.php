<?php

namespace App\Http\Resources\announcements;

use Illuminate\Http\Resources\Json\Resource;

class AnnouncementPublicFullResource extends Resource
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
            'content' => $this->content,
            'posted_at' => \Carbon\Carbon::parse($this->posted_at)->format('M j, Y'),
            'created_by' => $this->user->name
        ];
    }
}
