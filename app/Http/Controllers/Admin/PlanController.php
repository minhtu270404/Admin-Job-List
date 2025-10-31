<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PlanRequest;
use App\Services\Admin\PlanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Response;

class PlanController extends Controller
{
    protected PlanService $planService;

    public function __construct(PlanService $planService)
    {
        $this->middleware(['permission:price plan']);
        $this->planService = $planService;
    }

    /**
     * Danh sách gói dịch vụ
     */
    public function index(): View
    {
        $plans = $this->planService->getAll();
        return view('admin.plan.index', compact('plans'));
    }

    /**
     * Form tạo gói dịch vụ mới
     */
    public function create(): View
    {
        return view('admin.plan.create');
    }

    /**
     * Lưu gói dịch vụ mới
     */
    public function store(PlanRequest $request): RedirectResponse
    {
        $this->planService->create($request->validated());
        return redirect()->route('admin.plans.index');
    }

    /**
     * Form chỉnh sửa gói dịch vụ
     */
    public function edit(string $id): View
    {
        $plan = $this->planService->findById($id);
        return view('admin.plan.edit', compact('plan'));
    }

    /**
     * Cập nhật gói dịch vụ
     */
    public function update(PlanRequest $request, string $id): RedirectResponse
    {
        $this->planService->update($id, $request->validated());
        return redirect()->route('admin.plans.index');
    }

    /**
     * Xóa gói dịch vụ
     */
    public function destroy(string $id): Response
    {
        return $this->planService->delete($id);
    }
}
