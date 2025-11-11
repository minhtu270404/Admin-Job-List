<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SkillRequest;
use App\Services\Admin\SkillService;
use App\Services\Notify;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    protected SkillService $skillService;

    public function __construct(SkillService $skillService)
    {
        $this->middleware(['permission:job attributes']);
        $this->skillService = $skillService;
    }

    /**
     * Danh sách skills
     */
    public function index(Request $request): View
    {
        $skills = $this->skillService->getAll($request);
        return view('admin.skill.index', compact('skills'));
    }

    /**
     * Form tạo skill mới
     */
    public function create(): View
    {
        return view('admin.skill.create');
    }

    /**
     * Lưu skill mới
     */
    public function store(SkillRequest $request): RedirectResponse
    {
        $this->skillService->store($request->validated());
        Notify::createdNotification('Thêm Mới Thành Công');
        return redirect()->route('admin.skills.index');
    }

    /**
     * Form chỉnh sửa skill
     */
    public function edit(string $id): View
    {
        $skill = $this->skillService->find($id);
        return view('admin.skill.edit', compact('skill'));
    }

    /**
     * Cập nhật skill
     */
    public function update(SkillRequest $request, string $id): RedirectResponse
    {
        $this->skillService->update($id, $request->validated());
        Notify::updatedNotification('Cập Nhật Thành Công');
        return redirect()->route('admin.skills.index');
    }

    /**
     * Xóa skill
     * Hỗ trợ cả Ajax và form submit
     */
    public function destroy(string $id)
    {
        try {
            $this->skillService->delete($id);
            return redirect()->route('admin.skills.index')
                ->with('success', 'Xóa kỹ năng thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.skills.index')
                ->with('error', $e->getMessage());
        }
    }
}
