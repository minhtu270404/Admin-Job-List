<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrganizationTypeRequest;
use App\Services\Admin\OrganizationTypeService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class OrganizationTypeController extends Controller
{
    protected OrganizationTypeService $organizationTypeService;

    public function __construct(OrganizationTypeService $organizationTypeService)
    {
        $this->middleware(['permission:job attributes']);
        $this->organizationTypeService = $organizationTypeService;
    }

    /**
     * Danh sách loại hình tổ chức
     */
    public function index(Request $request): View
    {
        $organizationTypes = $this->organizationTypeService->getPaginatedList($request);
        return view('admin.organization-type.index', compact('organizationTypes'));
    }

    /**
     * Form tạo mới
     */
    public function create(): View
    {
        return view('admin.organization-type.create');
    }

    /**
     * Lưu loại hình tổ chức mới
     */
    public function store(OrganizationTypeRequest $request): RedirectResponse
    {
        $this->organizationTypeService->create($request->validated());
        return redirect()->route('admin.organization-types.index');
    }

    /**
     * Form chỉnh sửa
     */
    public function edit(string $id): View
    {
        $organizationType = $this->organizationTypeService->findById($id);
        return view('admin.organization-type.edit', compact('organizationType'));
    }

    /**
     * Cập nhật loại hình tổ chức
     */
    public function update(OrganizationTypeRequest $request, string $id): RedirectResponse
    {
        $this->organizationTypeService->update($id, $request->validated());
        return redirect()->route('admin.organization-types.index');
    }

    /**
     * Xóa loại hình tổ chức
     */
    public function destroy(string $id): Response
    {
        return $this->organizationTypeService->delete($id);
    }
}
