<?php

namespace App\Http\Resources\calendar_dates;

use Illuminate\Http\Resources\Json\Resource;

class CalendarDateAdminFullResource extends Resource
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
            'calendar_date' => $this->calendar_date,
            'title' => $this->title,
            'type' => $this->type,
            'holiday_type' => $this->holiday_type,
            'details' => $this->details,
            'hidden' => boolval($this->hidden),
            'created_by' => $this->created_by,
            'created_at' => \Carbon\Carbon::parse($this->created_at)->format('Y-m-d'),
            'updated_at' => \Carbon\Carbon::parse($this->updated_at)->format('Y-m-d')
        ];
    }
}
