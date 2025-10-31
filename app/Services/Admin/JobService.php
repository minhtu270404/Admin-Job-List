<?php

namespace App\Services\Admin;

use App\Models\Benefits;
use App\Models\Job;
use App\Models\JobBenefits;
use App\Models\JobSkills;
use App\Models\JobTag;
use Illuminate\Support\Facades\DB;
use Throwable;

class JobService
{
    public function createOrUpdate(array $data, ?Job $job = null): Job
    {
        return DB::transaction(function () use ($data, $job) {

            $job = $job ?? new Job();
            $job->fill([
                'title'             => $data['title'],
                'company_id'        => $data['company'],
                'job_category_id'   => $data['category'],
                'vacancies'         => $data['vacancies'],
                'deadline'          => $data['deadline'],
                'country_id'        => $data['country'],
                'state_id'          => $data['state'],
                'city_id'           => $data['city'],
                'address'           => $data['address'] ?? null,
                'salary_mode'       => $data['salary_mode'],
                'min_salary'        => $data['min_salary'] ?? null,
                'max_salary'        => $data['max_salary'] ?? null,
                'custom_salary'     => $data['custom_salary'] ?? null,
                'salary_type_id'    => $data['salary_type'],
                'job_experience_id' => $data['experience'],
                'job_role_id'       => $data['job_role'],
                'education_id'      => $data['education'],
                'job_type_id'       => $data['job_type'],
                'featured'          => $data['featured'] ?? 0,
                'highlight'         => $data['highlight'] ?? 0,
                'description'       => $data['description'],
                'status'            => $job->status ?? 'active',
            ]);

            $job->save();

            // === Sync Tags ===
            JobTag::where('job_id', $job->id)->delete();
            if (!empty($data['tags'])) {
                foreach ($data['tags'] as $tagId) {
                    JobTag::create(['job_id' => $job->id, 'tag_id' => $tagId]);
                }
            }

            // === Sync Benefits ===
            JobBenefits::where('job_id', $job->id)->each(function ($b) {
                Benefits::find($b->benefit_id)?->delete();
                $b->delete();
            });

            if (!empty($data['benefits'])) {
                foreach (explode(',', $data['benefits']) as $benefit) {
                    $benefit = trim($benefit);
                    if ($benefit === '') continue;
                    $b = Benefits::create([
                        'company_id' => $job->company_id,
                        'name' => $benefit
                    ]);
                    JobBenefits::create(['job_id' => $job->id, 'benefit_id' => $b->id]);
                }
            }

            // === Sync Skills ===
            JobSkills::where('job_id', $job->id)->delete();
            if (!empty($data['skills'])) {
                foreach ($data['skills'] as $skillId) {
                    JobSkills::create(['job_id' => $job->id, 'skill_id' => $skillId]);
                }
            }

            return $job;
        });
    }

    public function delete(string $id): void
    {
        DB::transaction(function () use ($id) {
            $job = Job::findOrFail($id);
            JobTag::where('job_id', $id)->delete();
            JobSkills::where('job_id', $id)->delete();
            JobBenefits::where('job_id', $id)->each(function ($b) {
                Benefits::find($b->benefit_id)?->delete();
                $b->delete();
            });
            $job->delete();
        });
    }
}
