<?php

namespace App\Http\Resources\news;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\Resource;

class NewsPublicBasicResource extends Resource
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
            'url' => '/news/' . $this->slug,
            'content' => str_limit(strip_tags($this->content), 200),
            'thumb_image' => $this->thumb_image ? url(Storage::url($this->thumb_image)) : null,
            'posted_at' => \Carbon\Carbon::parse($this->posted_at)->format('M j, Y')
        ];
    }
}
