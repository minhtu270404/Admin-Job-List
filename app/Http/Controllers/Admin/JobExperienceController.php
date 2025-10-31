<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobExperienceRequest;
use App\Models\Candidate;
use App\Models\Job;
use App\Models\JobExperience;
use App\Services\Notify;
use App\Traits\Searchable;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JobExperienceController extends Controller
{
    use Searchable;

    public function __construct()
    {
        $this->middleware(['permission:job attributes']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $query = JobExperience::query();
        $this->search($query, ['name', 'slug']);
        $jobExperiences = $query->orderBy('id', 'DESC')->paginate(20);

        return view('admin.job.job-experience.index', compact('jobExperiences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.job.job-experience.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobExperienceRequest $request): RedirectResponse
    {
        JobExperience::create([
            'name' => $request->name,
        ]);

        Notify::createdNotification('Thêm Mới Thành Công');
        return redirect()->route('admin.job-experiences.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $experience = JobExperience::findOrFail($id);
        return view('admin.job.job-experience.edit', compact('experience'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobExperienceRequest $request, string $id): RedirectResponse
    {
        $experience = JobExperience::findOrFail($id);
        $experience->update([
            'name' => $request->name,
        ]);

        Notify::updatedNotification('Cập Nhật Thành Công');
        return redirect()->route('admin.job-experiences.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // validation
        $jobExist = Job::where('job_experience_id', $id)->exists();
        $candidateExist = Candidate::where('experience_id', $id)->exists();

        if ($jobExist || $candidateExist) {
            return response(['message' => 'This item is already been used can\'t delete!'], 500);
        }

        try {
            JobExperience::findOrFail($id)->delete();
            Notify::deletedNotification('Xóa Thành Công');
            return response(['message' => 'success'], 200);

        } catch (\Exception $e) {
            logger($e);
            return response(['message' => 'Something Went Wrong Please Try Again!'], 500);
        }
    }
}
