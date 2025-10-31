<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CounterUpdateRequest;
use App\Services\Admin\CounterService;
use App\Services\Notify;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class CounterController extends Controller
{
    protected CounterService $counterService;

    public function __construct(CounterService $counterService)
    {
        $this->middleware(['permission:sections']);
        $this->counterService = $counterService;
    }

    public function index(): View
    {
        $counter = $this->counterService->getCounter();
        return view('admin.counter.index', compact('counter'));
    }

    public function update(CounterUpdateRequest $request, string $id): RedirectResponse
    {
        try {
            $this->counterService->updateCounter($request->validated());
            Notify::updatedNotification('Cập Nhật Thành Công');

            return redirect()->back();

        } catch (Throwable $e) {
            logger()->error('Lỗi cập nhật counter: ' . $e->getMessage(), ['exception' => $e]);
            Notify::errorNotification('Đã xảy ra lỗi khi cập nhật, vui lòng thử lại!');
            return redirect()->back()->withInput();
        }
    }
}
