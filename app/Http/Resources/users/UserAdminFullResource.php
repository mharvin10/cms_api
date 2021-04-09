<?php

namespace App\Http\Resources\users;

use Illuminate\Http\Resources\Json\Resource;

class UserAdminFullResource extends Resource
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
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'suspended' => $this->suspended,
            'components' => $this->components
                ->map(function ($item, $key) {
                    return $item->id;
                }),
            'created_by' => $this->created_by,
            'ceated_at' => \Carbon\Carbon::parse($this->ceated_at)->format('Y-m-d'),
            'updated_at' => \Carbon\Carbon::parse($this->updated_at)->format('Y-m-d')
        ];
    }
}
