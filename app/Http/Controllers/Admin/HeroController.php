<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HeroRequest;
use App\Services\Admin\HeroService;
use App\Services\Notify;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Exception;

class HeroController extends Controller
{
    protected HeroService $heroService;

    public function __construct(HeroService $heroService)
    {
        $this->middleware(['permission:sections']);
        $this->heroService = $heroService;
    }

    public function index(): View
    {
        $hero = $this->heroService->getHero();
        return view('admin.hero.index', compact('hero'));
    }

    public function update(HeroRequest $request, string $id): RedirectResponse
    {
        try {
            $this->heroService->update($request->validated());
            Notify::updatedNotification('Cập Nhật Thành Công');
            return redirect()
                ->back()
                ->with('success', 'Cập nhật Hero section thành công!');
        } catch (Exception $e) {
            logger($e);
            return redirect()
                ->back()
                ->with('error', 'Có lỗi xảy ra khi cập nhật Hero section.');
        }
    }
}
