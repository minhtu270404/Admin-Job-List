<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LearnMoreRequest;
use App\Services\Admin\LearnMoreService;
use App\Services\Notify;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LearnMoreController extends Controller
{
    protected LearnMoreService $learnMoreService;

    public function __construct(LearnMoreService $learnMoreService)
    {
        $this->middleware(['permission:sections']);
        $this->learnMoreService = $learnMoreService;
    }

    public function index(): View
    {
        $learn = $this->learnMoreService->getLearnMore();
        return view('admin.learn-more.index', compact('learn'));
    }

    public function update(LearnMoreRequest $request, string $id): RedirectResponse
    {
        $this->learnMoreService->updateOrCreate($request->validated());
        Notify::updatedNotification('Cập nhật Learn More thành công!');
        return back();
    }
}
