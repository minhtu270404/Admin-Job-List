<?php

namespace App\Services\Admin;

use App\Services\Notify;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ProfileService
{
    use FileUploadTrait;

    public function updateProfile(Request $request): void
    {
        $admin = auth()->guard('admin')->user();

        // Upload ảnh mới nếu có
        $imagePath = $this->uploadFile($request, 'image', 'uploads/admins');

        if ($imagePath) {
            $admin->image = $imagePath;
        }

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->save();

        Notify::updatedNotification();
    }

    public function updatePassword(Request $request): void
    {
        $admin = auth()->guard('admin')->user();
        $admin->password = Hash::make($request->password);
        $admin->save();

        Notify::updatedNotification();
    }
}
