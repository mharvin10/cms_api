<?php

namespace App\Http\Controllers\Website;

use App\JobVacancy;
use App\Http\Resources\job_vacancies\JobVacancyPublicBasicResource;
use App\Http\Resources\job_vacancies\JobVacancyPublicFullResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JobVacancyController extends Controller
{
    protected $jobVacancies;

    public function __construct(JobVacancy $job_vacancies)
    {
        $this->jobVacancies = $job_vacancies;
    }

    public function jobVacancy($slug)
    {
    	$job_vacancy = $this->jobVacancies->where('slug', $slug)->first();

      return new JobVacancyPublicFullResource($job_vacancy);
    }

    public function list()
    {
    	$job_vacancies = $this->jobVacancies->all();

      return JobVacancyPublicBasicResource::collection($job_vacancies);
    }
}
