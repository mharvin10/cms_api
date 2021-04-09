<?php

namespace App\Http\Resources\navigations;

use Illuminate\Http\Resources\Json\Resource;

class MainMenuAdminBasicResource extends Resource
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
            'page_node_id' => $this->page_node_id,
            'hidden' => boolval($this->hidden)
        ];
    }
}
