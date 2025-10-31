<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AboutUsUpdateRequest;
use App\Services\Admin\AboutService;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AboutController extends Controller
{
    protected AboutService $aboutService;

    public function __construct(AboutService $aboutService)
    {
        $this->aboutService = $aboutService;
        $this->middleware(['permission:site pages']);
    }

    public function index()
    {
        $about = $this->aboutService->getAboutInfo();
        return view('admin.about-us.index', compact('about'));
    }
    
    public function update(AboutUsUpdateRequest $request, string $id)
    {
        $this->aboutService->updateAbout($request);
        return redirect()->back()->with('success', 'Cập nhật thông tin trang Giới thiệu thành công!');
    }
}
