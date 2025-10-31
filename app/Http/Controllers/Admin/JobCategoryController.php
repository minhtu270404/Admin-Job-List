<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobCategoryRequest;
use App\Models\Job;
use App\Models\JobCategory;
use App\Services\Notify;
use App\Traits\Searchable;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class JobCategoryController extends Controller
{
    use Searchable;

    public function __construct()
    {
        $this->middleware(['permission:job category create|job category update|job category delete'])->only('index');
        $this->middleware(['permission:job category create'])->only(['create', 'store']);
        $this->middleware(['permission:job category update'])->only(['edit', 'update']);
        $this->middleware(['permission:job category delete'])->only('destroy');
    }

    public function index(): View
    {
        $query = JobCategory::query();
        $this->search($query, ['name', 'slug']);

        $categories = $query->paginate(20);

        return view('admin.job.job-category.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.job.job-category.create');
    }

    public function store(JobCategoryRequest $request): RedirectResponse
    {
        JobCategory::create([
            'icon' => $request->icon,
            'name' => $request->name,
            'show_at_popular' => $request->boolean('show_at_popular'),
            'show_at_featured' => $request->boolean('show_at_featured'),
        ]);

        Notify::createdNotification('Thêm Mới Thành Công');

        return redirect()->route('admin.job-categories.index');
    }

    public function edit(string $id): View
    {
        $category = JobCategory::findOrFail($id);
        return view('admin.job.job-category.edit', compact('category'));
    }

    public function update(JobCategoryRequest $request, string $id): RedirectResponse
    {
        $category = JobCategory::findOrFail($id);

        $category->fill([
            'name' => $request->name,
            'show_at_popular' => $request->boolean('show_at_popular'),
            'show_at_featured' => $request->boolean('show_at_featured'),
        ]);

        if ($request->filled('icon')) {
            $category->icon = $request->icon;
        }

        $category->save();

        Notify::updatedNotification('Cập Nhật Thành Công');

        return redirect()->route('admin.job-categories.index');
    }

    public function destroy(string $id)
    {
        if (Job::where('job_category_id', $id)->exists()) {
            return response(['message' => "This item is already been used can't delete!"], 500);
        }

        try {
            JobCategory::findOrFail($id)->delete();
 Notify::deletedNotification('Xóa Thành Công');            return response(['message' => 'success'], 200);
        } catch (Throwable $e) {
            logger()->error($e->getMessage(), ['id' => $id]);
            return response(['message' => 'Something went wrong, please try again!'], 500);
        }
    }
}
