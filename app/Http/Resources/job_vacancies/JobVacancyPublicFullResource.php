<?php

namespace App\Http\Resources\job_vacancies;

use Illuminate\Http\Resources\Json\Resource;

class JobVacancyPublicFullResource extends Resource
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
            'closing_date' => \Carbon\Carbon::parse($this->closing_date)->format('M j, Y'),
            'created_by' => $this->user->name
        ];
    }
}
