<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AppliedJob;
use App\Models\City;
use App\Models\Country;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\JobType;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class FrontendJobPageController extends Controller
{
    /**
     * GET /api/jobs
     * Trả danh sách job (filter & phân trang)
     */
    public function index(Request $request): JsonResponse
    {
        $countries = Country::all();
        $jobCategories = JobCategory::withCount(['jobs' => function ($query) {
            $query->where('status', 'active')->where('deadline', '>=', date('Y-m-d'));
        }])->get();
        $jobTypes = JobType::all();
        $selectedStates = null;
        $selectedCities = null;

        $query = Job::query()->where('status', 'active')->where('deadline', '>=', date('Y-m-d'));

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('country')) {
            $query->where('country_id', $request->country);
        }
        if ($request->filled('state')) {
            $query->where('state_id', $request->state);
            $selectedStates = State::where('country_id', $request->country)->get();
            $selectedCities = City::where('state_id', $request->state)->get();
        }
        if ($request->filled('city')) {
            $query->where('city_id', $request->city);
        }
        if ($request->filled('category')) {
            if (is_array($request->category)) {
                $categoryIds = JobCategory::whereIn('slug', $request->category)->pluck('id')->toArray();
                $query->whereIn('job_category_id', $categoryIds);
            } else {
                $category = JobCategory::where('slug', $request->category)->first();
                if ($category) {
                    $query->where('job_category_id', $category->id);
                }
            }
        }
        if ($request->filled('min_salary') && $request->min_salary > 0) {
            $query->where(function ($q) use ($request) {
                $q->where('min_salary', '>=', $request->min_salary)
                  ->orWhere('max_salary', '>=', $request->min_salary);
            });
        }
        if ($request->filled('jobtype')) {
            $typeIds = JobType::whereIn('slug', $request->jobtype)->pluck('id')->toArray();
            $query->whereIn('job_type_id', $typeIds);
        }

        $jobs = $query->paginate(8);

        return response()->json([
            'status' => true,
            'data' => [
                'jobs' => $jobs,
                'countries' => $countries,
                'job_categories' => $jobCategories,
                'job_types' => $jobTypes,
                'states' => $selectedStates,
                'cities' => $selectedCities
            ]
        ]);
    }

    /**
     * GET /api/jobs/{slug}
     * Chi tiết job
     */
    public function show(string $slug): JsonResponse
    {
        $job = Job::where('slug', $slug)->firstOrFail();
        $openJobs = Job::where('company_id', $job->company->id)
            ->where('status', 'active')
            ->where('deadline', '>=', date('Y-m-d'))
            ->count();

        $alreadyApplied = auth()->check()
            ? AppliedJob::where(['job_id' => $job->id, 'candidate_id' => auth()->user()->id])->exists()
            : false;

        return response()->json([
            'status' => true,
            'data' => [
                'job' => $job,
                'open_jobs_count' => $openJobs,
                'already_applied' => $alreadyApplied
            ]
        ]);
    }

    /**
     * POST /api/jobs/{id}/apply
     * Apply job
     */
    public function apply(string $id): JsonResponse
    {
        if (!auth()->check()) {
            throw ValidationException::withMessages(['message' => 'Please login for apply to the job.']);
        }

        $alreadyApplied = AppliedJob::where(['job_id' => $id, 'candidate_id' => auth()->user()->id])->exists();
        if ($alreadyApplied) {
            throw ValidationException::withMessages(['message' => 'You already applied to this job.']);
        }

        AppliedJob::create([
            'job_id' => $id,
            'candidate_id' => auth()->user()->id,
        ]);

        return response()->json(['status' => true, 'message' => 'Applied Successfully!']);
    }
}
