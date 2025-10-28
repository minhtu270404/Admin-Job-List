<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileUpdateRequest;
use App\Http\Requests\Admin\PasswordUpdateRequest;
use App\Services\Admin\ProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileUpdateController extends Controller
{
    protected ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }


    public function index(): View
    {
        $admin = auth()->guard('admin')->user();
        return view('admin.profile.index', compact('admin'));
    }


    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $this->profileService->updateProfile($request);
        return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
    }


    public function passwordUpdate(PasswordUpdateRequest $request): RedirectResponse
    {
        $this->profileService->updatePassword($request);
        return redirect()->back()->with('success', 'Cập nhật mật khẩu thành công!');
    }
}
