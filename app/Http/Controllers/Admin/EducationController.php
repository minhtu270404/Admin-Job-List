<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EducationRequest;
use App\Models\Education;
use App\Services\Admin\EducationService;
use App\Services\Notify;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Exception;

class EducationController extends Controller
{
    protected $educationService;

    public function __construct(EducationService $educationService)
    {
        $this->middleware(['permission:job attributes']);
        $this->educationService = $educationService;
    }

    public function index(Request $request): View
    {
        $educations = $this->educationService->getAll($request->get('search'));
        return view('admin.job.education.index', compact('educations'));
    }

    public function create(): View
    {
        return view('admin.job.education.create');
    }

    public function store(EducationRequest $request): RedirectResponse
    {
        $this->educationService->create($request->validated());
        Notify::createdNotification('Thêm Mới Thành Công');

        return redirect()->route('admin.educations.index')
            ->with('success', 'Đã thêm trình độ học vấn thành công!');
    }

    public function edit(Education $education): View
    {
        return view('admin.job.education.edit', compact('education'));
    }

    public function update(EducationRequest $request, Education $education): RedirectResponse
    {
        $this->educationService->update($education, $request->validated());
        Notify::updatedNotification('Cập Nhật Thành Công');

        return redirect()->route('admin.educations.index')
            ->with('success', 'Cập nhật thành công!');
    }

    public function destroy(int $id)
    {
        try {
            $this->educationService->delete($id);
 Notify::deletedNotification('Xóa Thành Công');            return response(['message' => 'success'], 200);
        } catch (Exception $e) {
            logger($e);
            return response(['message' => $e->getMessage()], 500);
        }
    }
}
