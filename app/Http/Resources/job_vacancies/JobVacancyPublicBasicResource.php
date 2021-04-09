<?php

namespace App\Http\Resources\job_vacancies;

use Illuminate\Http\Resources\Json\Resource;

class JobVacancyPublicBasicResource extends Resource
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
            'url' => '/job-vacancies/' . $this->slug,
            // 'content' => str_limit(strip_tags($this->content), 150),
            'closing_date' => \Carbon\Carbon::parse($this->closing_date)->format('M j, Y'),
            'posted_at' => \Carbon\Carbon::parse($this->posted_at)->format('M j, Y')
        ];
    }
}
