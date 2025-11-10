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
use Illuminate\Http\Request;


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

    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'icon' => ['required', 'max:255'],
            'name' => ['required', 'max:255']
        ]);

        $category = new JobCategory();
        $category->icon = $request->icon;
        $category->name = $request->name;
        $category->show_at_popular = $request->show_at_popular;
        $category->show_at_featured = $request->show_at_featured;


        $category->save();

        Notify::createdNotification('Thêm Mới Thành Công');

        return to_route('admin.job-categories.index');
    }

    public function edit(string $id): View
    {
        $category = JobCategory::findOrFail($id);
        return view('admin.job.job-category.edit', compact('category'));
    }

    public function update(Request $request, string $id) 
    {
        $request->validate([
            'icon' => ['nullable', 'max:255'],
            'name' => ['required', 'max:255']
        ]);

        $category = JobCategory::findOrFail($id);
        if($request->filled('icon')) $category->icon = $request->icon;
        $category->name = $request->name;
        $category->show_at_popular = $request->show_at_popular;
        $category->show_at_featured = $request->show_at_featured;

        $category->save();

        Notify::updatedNotification('Cập Nhật Thành Công');

        return to_route('admin.job-categories.index');
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
