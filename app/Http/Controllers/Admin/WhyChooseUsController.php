<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WhyChooseUsRequest;
use App\Services\Admin\WhyChooseUsService;
use App\Services\Notify;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class WhyChooseUsController extends Controller
{
    protected WhyChooseUsService $whyChooseUsService;

    public function __construct(WhyChooseUsService $whyChooseUsService)
    {
        $this->middleware(['permission:sections']);
        $this->whyChooseUsService = $whyChooseUsService;
    }

    public function index(): View
    {
        $whyChooseUs = $this->whyChooseUsService->getFirst();
        return view('admin.why-choose-us.index', compact('whyChooseUs'));
    }

    public function update(WhyChooseUsRequest $request, string $id): RedirectResponse
    {
        $data = $request->validated();

        // Giữ nguyên logic chỉ cập nhật icon nếu có nhập
        if (empty($data['icon_one'])) unset($data['icon_one']);
        if (empty($data['icon_two'])) unset($data['icon_two']);
        if (empty($data['icon_three'])) unset($data['icon_three']);

        $this->whyChooseUsService->updateOrCreate($data);

        Notify::updatedNotification('Cập Nhật Thành Công');

        return redirect()->back()->with('success', 'Cập nhật thành công!');
    }
}
