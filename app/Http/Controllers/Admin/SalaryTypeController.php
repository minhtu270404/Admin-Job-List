<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SalaryTypeRequest;
use App\Models\SalaryType;
use App\Services\Notify;
use App\Services\Admin\SalaryTypeService;
use App\Traits\Searchable;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class SalaryTypeController extends Controller
{
    use Searchable;

    protected SalaryTypeService $salaryTypeService;

    public function __construct(SalaryTypeService $salaryTypeService)
    {
        $this->middleware(['permission:job attributes']);
        $this->salaryTypeService = $salaryTypeService;
    }

    /**
     * Danh sách loại lương
     */
    public function index(): View
    {
        $query = SalaryType::query();
        $this->search($query, ['name', 'slug']);
        $salaryTypes = $query->paginate(20);

        return view('admin.job.salary-type.index', compact('salaryTypes'));
    }

    /**
     * Form tạo loại lương
     */
    public function create(): View
    {
        return view('admin.job.salary-type.create');
    }

    /**
     * Lưu loại lương mới
     */
    public function store(SalaryTypeRequest $request): RedirectResponse
    {
        $this->salaryTypeService->create($request->validated());
        Notify::createdNotification('Tạo loại lương thành công.');

        return redirect()->route('admin.salary-types.index');
    }

    /**
     * Form chỉnh sửa
     */
    public function edit(string $id): View
    {
        $type = SalaryType::findOrFail($id);
        return view('admin.job.salary-type.edit', compact('type'));
    }

    /**
     * Cập nhật loại lương
     */
    public function update(SalaryTypeRequest $request, string $id): RedirectResponse
    {
        $this->salaryTypeService->update($id, $request->validated());
        Notify::updatedNotification('Cập nhật loại lương thành công.');

        return redirect()->route('admin.salary-types.index');
    }

    /**
     * Xóa loại lương
     */
    public function destroy(string $id)
    {
        try {
            $this->salaryTypeService->delete($id);
            Notify::deletedNotification('Xóa loại lương thành công.');

            return response(['message' => 'success'], 200);
        } catch (Throwable $e) {
            return response(['message' => $e->getMessage()], 500);
        }
    }
}
