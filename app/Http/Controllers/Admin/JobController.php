<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobCreateRequest;
use App\Models\{Job, Company, JobCategory, Country, State, City, SalaryType, Experience, JobRole, Education, JobType, Tag, Skill};
use App\Services\Admin\JobService;
use App\Traits\Searchable;
use App\Services\Notify;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Response;
use Throwable;


class JobController extends Controller
{
    use Searchable;

    protected JobService $jobService;

    public function __construct(JobService $jobService)
    {
        $this->middleware(['permission:job create|job update|job delete'])->only('index');
        $this->middleware(['permission:job create'])->only(['create', 'store']);
        $this->middleware(['permission:job update'])->only(['edit', 'update', 'changeStatus']);
        $this->middleware(['permission:job delete'])->only('destroy');

        $this->jobService = $jobService;
    }

    public function index(): View
    {
        $query = Job::query();
        $this->search($query, ['title', 'slug']);
        $jobs = $query->orderByDesc('id')->paginate(20);
        return view('admin.job.index', compact('jobs'));
    }

    public function create(): View
    {
        return view('admin.job.create', [
            'companies' => Company::where(['profile_completion' => 1, 'visibility' => 1])->get(),
            'categories' => JobCategory::all(),
            'countries' => Country::all(),
            'salaryTypes' => SalaryType::all(),
            'experiences' => Experience::all(),
            'jobRoles' => JobRole::all(),
            'educations' => Education::all(),
            'jobTypes' => JobType::all(),
            'tags' => Tag::all(),
            'skills' => Skill::all(),
        ]);
    }

    public function store(JobCreateRequest $request): RedirectResponse
    {
        $this->jobService->createOrUpdate($request->validated());
        Notify::createdNotification('Thêm Mới Thành Công');
        return redirect()->route('admin.jobs.index');
    }

    public function edit(string $id): View
    {
        $job = Job::findOrFail($id);

        return view('admin.job.edit', [
            'job' => $job,
            'companies' => Company::where(['profile_completion' => 1, 'visibility' => 1])->get(),
            'categories' => JobCategory::all(),
            'countries' => Country::all(),
            'states' => State::where('country_id', $job->country_id)->get(),
            'cities' => City::where('state_id', $job->state_id)->get(),
            'salaryTypes' => SalaryType::all(),
            'experiences' => Experience::all(),
            'jobRoles' => JobRole::all(),
            'educations' => Education::all(),
            'jobTypes' => JobType::all(),
            'tags' => Tag::all(),
            'skills' => Skill::all(),
        ]);
    }

    public function update(JobCreateRequest $request, string $id): RedirectResponse
    {
        $job = Job::findOrFail($id);
        $this->jobService->createOrUpdate($request->validated(), $job);
        Notify::updatedNotification('Cập Nhật Thành Công');
        return redirect()->route('admin.jobs.index');
    }

    public function destroy(string $id): Response
    {
        try {
            $this->jobService->delete($id);
            Notify::deletedNotification('Xóa Thành Công');
            return response(['message' => 'success'], 200);
        } catch (Throwable $e) {
            logger()->error($e->getMessage());
            return response(['message' => 'Something went wrong, please try again!'], 500);
        }
    }

    public function changeStatus(string $id): Response
    {
        $job = Job::findOrFail($id);
        $job->update(['status' => $job->status === 'active' ? 'pending' : 'active']);
        Notify::updatedNotification('Cập Nhật Thành Công');
        return response(['message' => 'success'], 200);
    }
}
