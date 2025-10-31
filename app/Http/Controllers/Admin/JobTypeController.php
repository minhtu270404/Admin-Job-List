<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobTypeCreateRequest;
use App\Http\Requests\Admin\JobTypeUpdateRequest;
use App\Services\Admin\JobTypeService;
use App\Services\Notify;
use App\Traits\Searchable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class JobTypeController extends Controller
{
    use Searchable;

    protected JobTypeService $jobTypeService;

    public function __construct(JobTypeService $jobTypeService)
    {
        $this->middleware(['permission:job attributes']);
        $this->jobTypeService = $jobTypeService;
    }

    /**
     * Hiển thị danh sách loại công việc
     */
    public function index(): View
    {
        $query = $this->jobTypeService->baseQuery();
        $this->search($query, ['name', 'slug']);
        $jobTypes = $query->paginate(20);

        return view('admin.job.job-type.index', compact('jobTypes'));
    }

    /**
     * Form tạo mới
     */
    public function create(): View
    {
        return view('admin.job.job-type.create');
    }

    /**
     * Lưu loại công việc mới
     */
    public function store(JobTypeCreateRequest $request): RedirectResponse
    {
        $this->jobTypeService->create($request->validated());
        Notify::createdNotification('Thêm Mới Thành Công');

        return redirect()->route('admin.job-types.index');
    }

    /**
     * Form chỉnh sửa
     */
    public function edit(string $id): View
    {
        $type = $this->jobTypeService->findOrFail($id);
        return view('admin.job.job-type.edit', compact('type'));
    }

    /**
     * Cập nhật loại công việc
     */
    public function update(JobTypeUpdateRequest $request, string $id): RedirectResponse
    {
        $this->jobTypeService->update($id, $request->validated());
        Notify::updatedNotification('Cập Nhật Thành Công');

        return redirect()->route('admin.job-types.index');
    }

    /**
     * Xóa loại công việc
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $this->jobTypeService->delete($id);
 Notify::deletedNotification('Xóa Thành Công');            return response()->json(['message' => 'success'], 200);
        } catch (Throwable $e) {
            logger($e);
            return response()->json(['message' => $e->getMessage() ?? 'Có lỗi xảy ra, vui lòng thử lại!'], 500);
        }
    }
}
