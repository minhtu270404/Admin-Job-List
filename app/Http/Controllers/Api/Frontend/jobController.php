<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\JobCreateRequest;
use App\Models\AppliedJob;
use App\Models\Benefits;
use App\Models\City;
use App\Models\Company;
use App\Models\Country;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Job;
use App\Models\JobBenefits;
use App\Models\JobCategory;
use App\Models\JobRole;
use App\Models\JobSkills;
use App\Models\JobTag;
use App\Models\JobType;
use App\Models\SalaryType;
use App\Models\Skill;
use App\Models\State;
use App\Models\Tag;
use App\Services\Notify;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class jobController extends Controller
{
    use Searchable;

    /**
     * GET /api/company/jobs
     * Lấy danh sách job của công ty
     */
    public function index(Request $request): JsonResponse
    {
        $query = Job::query()->where('company_id', auth()->user()->company?->id);
        $query->withCount('applications');
        $this->search($query, ['title', 'slug']);
        $jobs = $query->orderBy('id', 'DESC')->paginate(20);

        return response()->json([
            'status' => true,
            'data' => $jobs
        ]);
    }

    /**
     * GET /api/company/jobs/{id}/applications
     * Lấy danh sách ứng viên apply job
     */
    public function applications(string $id): JsonResponse
    {
        $job = Job::findOrFail($id);
        if($job->company_id !== auth()->user()->company->id) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $applications = AppliedJob::where('job_id', $id)->paginate(20);

        return response()->json([
            'status' => true,
            'data' => [
                'job_title' => $job->title,
                'applications' => $applications
            ]
        ]);
    }

    /**
     * POST /api/company/jobs
     * Tạo job mới
     */
    public function store(JobCreateRequest $request): JsonResponse
    {
        $userPlan = session('user_plan');
        if (!$userPlan) {
            return response()->json(['status' => false, 'message' => 'Plan information not found'], 400);
        }

        if ($userPlan->featured_job_limit < 1) {
            return response()->json(['status' => false, 'message' => 'You have reached your Featured job limit'], 400);
        }
        if ($userPlan->highlight_job_limit < 1) {
            return response()->json(['status' => false, 'message' => 'You have reached your Highlight job limit'], 400);
        }

        $job = new Job();
        $job->title = $request->title;
        $job->company_id = auth()->user()->company->id;
        $job->job_category_id = $request->category;
        $job->vacancies = $request->vacancies;
        $job->deadline = $request->deadline;
        $job->country_id = $request->country;
        $job->state_id = $request->state;
        $job->city_id = $request->city;
        $job->address = $request->address;
        $job->salary_mode = $request->salary_mode;
        $job->min_salary = $request->min_salary;
        $job->max_salary = $request->max_salary;
        $job->custom_salary = $request->custom_salary;
        $job->salary_type_id = $request->salary_type;
        $job->job_experience_id = $request->experience;
        $job->job_role_id = $request->job_role;
        $job->education_id = $request->education;
        $job->job_type_id = $request->job_type;
        $job->featured = $request->featured;
        $job->highlight = $request->highlight;
        $job->description = $request->description;
        $job->save();

        // Tags
        foreach ($request->tags as $tag) {
            JobTag::create(['job_id' => $job->id, 'tag_id' => $tag]);
        }

        // Benefits
        $benefits = explode(',', $request->benefits);
        foreach ($benefits as $benefit) {
            $b = Benefits::create(['company_id' => $job->company_id, 'name' => $benefit]);
            JobBenefits::create(['job_id' => $job->id, 'benefit_id' => $b->id]);
        }

        // Skills
        foreach ($request->skills as $skill) {
            JobSkills::create(['job_id' => $job->id, 'skill_id' => $skill]);
        }

        // Update plan
        $userPlan->job_limit -= 1;
        if ($job->featured) $userPlan->featured_job_limit -= 1;
        if ($job->highlight) $userPlan->highlight_job_limit -= 1;
        $userPlan->save();
        storePlanInformation();

        return response()->json([
            'status' => true,
            'message' => 'Job created successfully',
            'data' => $job
        ]);
    }

    /**
     * PUT /api/company/jobs/{id}
     * Cập nhật job
     */
    public function update(JobCreateRequest $request, string $id): JsonResponse
    {
        $job = Job::findOrFail($id);
        if ($job->company_id !== auth()->user()->company->id) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $job->update([
            'title' => $request->title,
            'job_category_id' => $request->category,
            'vacancies' => $request->vacancies,
            'deadline' => $request->deadline,
            'country_id' => $request->country,
            'state_id' => $request->state,
            'city_id' => $request->city,
            'address' => $request->address,
            'salary_mode' => $request->salary_mode,
            'min_salary' => $request->min_salary,
            'max_salary' => $request->max_salary,
            'custom_salary' => $request->custom_salary,
            'salary_type_id' => $request->salary_type,
            'job_experience_id' => $request->experience,
            'job_role_id' => $request->job_role,
            'education_id' => $request->education,
            'job_type_id' => $request->job_type,
            'featured' => $request->featured,
            'highlight' => $request->highlight,
            'description' => $request->description
        ]);

        // Update tags
        JobTag::where('job_id', $id)->delete();
        foreach ($request->tags as $tag) {
            JobTag::create(['job_id' => $job->id, 'tag_id' => $tag]);
        }

        // Update benefits
        $existingBenefits = JobBenefits::where('job_id', $id)->get();
        foreach ($existingBenefits as $b) {
            Benefits::find($b->benefit_id)?->delete();
        }
        JobBenefits::where('job_id', $id)->delete();

        $benefits = explode(',', $request->benefits);
        foreach ($benefits as $benefit) {
            $b = Benefits::create(['company_id' => $job->company_id, 'name' => $benefit]);
            JobBenefits::create(['job_id' => $job->id, 'benefit_id' => $b->id]);
        }

        // Update skills
        JobSkills::where('job_id', $id)->delete();
        foreach ($request->skills as $skill) {
            JobSkills::create(['job_id' => $job->id, 'skill_id' => $skill]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Job updated successfully',
            'data' => $job
        ]);
    }

    /**
     * DELETE /api/company/jobs/{id}
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $job = Job::findOrFail($id);
            if ($job->company_id !== auth()->user()->company->id) {
                return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
            }
            $job->delete();
            return response()->json(['status' => true, 'message' => 'Job deleted successfully']);
        } catch (\Exception $e) {
            logger($e);
            return response()->json(['status' => false, 'message' => 'Something went wrong'], 500);
        }
    }
}
