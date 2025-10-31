<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FooterRequest;
use App\Services\Admin\FooterService;
use App\Services\Notify;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FooterController extends Controller
{
    protected FooterService $footerService;

    public function __construct(FooterService $footerService)
    {
        $this->middleware(['permission:site footer']);
        $this->footerService = $footerService;
    }

    public function index(): View
    {
        $footer = $this->footerService->getFooter();
        return view('admin.footer.index', compact('footer'));
    }

    public function update(FooterRequest $request, string $id): RedirectResponse
    {
        $this->footerService->update($request->validated());

        Notify::updatedNotification('Cập Nhật Thành Công');

        return redirect()
            ->back()
            ->with('success', 'Cập nhật thông tin footer thành công!');
    }
}
