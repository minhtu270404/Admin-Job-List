<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobLocationCreateRequest;
use App\Http\Requests\Admin\JobLocationUpdateRequest;
use App\Models\Country;
use App\Services\Admin\JobLocationService;
use App\Services\Notify;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Throwable;

class JobLocationController extends Controller
{
    protected JobLocationService $jobLocationService;

    public function __construct(JobLocationService $jobLocationService)
    {
        $this->middleware(['permission:sections']);
        $this->jobLocationService = $jobLocationService;
    }

    /**
     * Hiển thị danh sách địa điểm làm việc
     */
    public function index(): View
    {
        $locations = $this->jobLocationService->getAllPaginated(20);
        return view('admin.job-location.index', compact('locations'));
    }

    /**
     * Form tạo mới
     */
    public function create(): View
    {
        $countries = Country::all(['id', 'name']);
        return view('admin.job-location.create', compact('countries'));
    }

    /**
     * Lưu địa điểm mới
     */
    public function store(JobLocationCreateRequest $request): RedirectResponse
    {
        $this->jobLocationService->create($request->validated());
        Notify::createdNotification('Thêm Mới Thành Công');

        return redirect()->route('admin.job-location.index');
    }

    /**
     * Form chỉnh sửa
     */
    public function edit(string $id): View
    {
        $location = $this->jobLocationService->findOrFail($id);
        $countries = Country::all(['id', 'name']);
        return view('admin.job-location.edit', compact('location', 'countries'));
    }

    /**
     * Cập nhật địa điểm
     */
    public function update(JobLocationUpdateRequest $request, string $id): RedirectResponse
    {
        $this->jobLocationService->update($id, $request->validated());
        Notify::updatedNotification('Cập Nhật Thành Công');

        return redirect()->route('admin.job-location.index');
    }

    /**
     * Xóa địa điểm
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $this->jobLocationService->delete($id);
 Notify::deletedNotification('Xóa Thành Công');            return response()->json(['message' => 'success'], 200);
        } catch (Throwable $e) {
            logger($e);
            return response()->json(['message' => 'Something went wrong. Please try again!'], 500);
        }
    }
}
