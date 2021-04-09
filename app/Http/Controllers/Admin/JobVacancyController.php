<?php

namespace App\Http\Controllers\Admin;

use App\JobVacancy;
use App\Http\Resources\job_vacancies\JobVacancyAdminBasicResource;
use App\Http\Resources\job_vacancies\JobVacancyAdminFullResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class JobVacancyController extends Controller
{
    protected $jobVacancy;

    public function __construct(JobVacancy $jobVacancy)
    {
        $this->jobVacancy = $jobVacancy;
    }

    public function jobVacancies()
    {
        $jobVacancys = $this->jobVacancy
            ->orderBy('posted_at', 'desc')
            ->get();

        return JobVacancyAdminBasicResource::collection($jobVacancys);
    }

    public function jobVacancy(Request $request, JobVacancy $jobVacancy)
    {
        return new JobVacancyAdminFullResource($jobVacancy);
    }

    public function store(Request $request)
    {
        $validations = [
            'title' => 'required|max:150',
            'closingDate' => 'nullable|date'
        ];

        $errors = [
            'title.required' => 'Title is required.',
            'title.max' => 'Title title must be 150 characters or less.'
        ];

        $this->validate($request, $validations, $errors);

        do {
            $id = str_random(14);
            $jobVacancy = $this->jobVacancy->find($id);
        } while ($jobVacancy);

        $this->jobVacancy->create([
            'id' => $id,
            'title' => $request->title,
            'content' => $request->content,
            'closing_date' => $request->closingDate,
            'created_by' => $request->user()->id
        ]);
    }

    public function update(Request $request, JobVacancy $jobVacancy)
    {
        $validations = [
            'title' => 'required|max:150',
            'closingDate' => 'date'
        ];

        $errors = [
            'title.required' => 'Title is required.',
            'title.max' => 'Title title must be 150 characters or less.'
        ];

        $this->validate($request, $validations, $errors);

        $jobVacancy->update([
            'title' => $request->title,
            'content' => $request->content,
            'closing_date' => $request->closingDate,
            'hidden' => $request->hidden
        ]);
    }

    public function destroy(JobVacancy $jobVacancy)
    {
        $jobVacancy->delete();
    }
}
