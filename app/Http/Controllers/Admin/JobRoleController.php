<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobRoleCreateRequest;
use App\Http\Requests\Admin\JobRoleUpdateRequest;
use App\Services\Admin\JobRoleService;
use App\Services\Notify;
use App\Traits\Searchable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class JobRoleController extends Controller
{
    use Searchable;

    protected JobRoleService $jobRoleService;

    public function __construct(JobRoleService $jobRoleService)
    {
        $this->middleware(['permission:job role']);
        $this->jobRoleService = $jobRoleService;
    }

    /**
     * Hiển thị danh sách vai trò công việc
     */
    public function index(): View
    {
        $query = $this->jobRoleService->baseQuery();
        $this->search($query, ['name', 'slug']);
        $jobRoles = $query->paginate(20);

        return view('admin.job.job-role.index', compact('jobRoles'));
    }

    /**
     * Form tạo mới
     */
    public function create(): View
    {
        return view('admin.job.job-role.create');
    }

    /**
     * Lưu vai trò mới
     */
    public function store(JobRoleCreateRequest $request): RedirectResponse
    {
        $this->jobRoleService->create($request->validated());
        Notify::createdNotification('Thêm Mới Thành Công');

        return redirect()->route('admin.job-roles.index');
    }

    /**
     * Form chỉnh sửa
     */
    public function edit(string $id): View
    {
        $role = $this->jobRoleService->findOrFail($id);
        return view('admin.job.job-role.edit', compact('role'));
    }

    /**
     * Cập nhật vai trò
     */
    public function update(JobRoleUpdateRequest $request, string $id): RedirectResponse
    {
        $this->jobRoleService->update($id, $request->validated());
        Notify::updatedNotification('Cập Nhật Thành Công');

        return redirect()->route('admin.job-roles.index');
    }

    /**
     * Xóa vai trò
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $this->jobRoleService->delete($id);
 Notify::deletedNotification('Xóa Thành Công');            return response()->json(['message' => 'success'], 200);
        } catch (Throwable $e) {
            logger($e);
            return response()->json(['message' => 'Something went wrong. Please try again!'], 500);
        }
    }
}
