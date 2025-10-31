<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SocialIcon\SocialIconRequest;
use App\Services\Admin\SocialIconService;
use App\Services\Notify;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SocialIconController extends Controller
{
    protected SocialIconService $socialIconService;

    public function __construct(SocialIconService $socialIconService)
    {
        $this->middleware(['permission:site footer']);
        $this->socialIconService = $socialIconService;
    }

    public function index(): View
    {
        $icons = $this->socialIconService->getAll();
        return view('admin.social-icon.index', compact('icons'));
    }

    public function create(): View
    {
        return view('admin.social-icon.create');
    }

    public function store(SocialIconRequest $request): RedirectResponse
    {
        $this->socialIconService->store($request->validated());
        Notify::createdNotification('Thêm Mới Thành Công');

        return redirect()->route('admin.social-icon.index');
    }

    public function edit(string $id): View
    {
        $icon = $this->socialIconService->find($id);
        return view('admin.social-icon.edit', compact('icon'));
    }

    public function update(SocialIconRequest $request, string $id): RedirectResponse
    {
        $this->socialIconService->update($id, $request->validated());
        Notify::updatedNotification('Cập Nhật Thành Công');

        return redirect()->route('admin.social-icon.index');
    }

    public function destroy(string $id)
    {
        return $this->socialIconService->delete($id);
    }
}
