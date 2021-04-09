<?php

namespace App\Http\Resources\announcements;

use Illuminate\Http\Resources\Json\Resource;

class AnnouncementPublicBasicResource extends Resource
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
            'title' => str_limit($this->title, 100),
            'url' => '/announcement/' . $this->slug,
            'content' => str_limit(strip_tags($this->content), 150),
            'content_first_image' => content_first_image($this->content),
            'posted_at' => \Carbon\Carbon::parse($this->posted_at)->format('M j, Y')
        ];
    }
}
