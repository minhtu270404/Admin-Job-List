<?php

namespace App\Services\Admin;

use App\Models\About;
use App\Services\Notify;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class AboutService
{
    use FileUploadTrait;

    /**
     * Lấy thông tin trang "Giới thiệu"
     */
    public function getAboutInfo(): ?About
    {
        return About::first();
    }

    /**
     * Cập nhật hoặc tạo mới nội dung trang "Giới thiệu"
     */
    public function updateAbout(Request $request): void
    {
        $imagePath = $this->uploadFile($request, 'image', 'uploads/about');

        $formData = [
            'title' => $request->title,
            'description' => $request->description,
            'url' => $request->url,
        ];

        // Nếu có hình mới thì cập nhật
        if ($imagePath) {
            $formData['image'] = $imagePath;
        }

        About::updateOrCreate(
            ['id' => 1],
            $formData
        );

        Notify::updatedNotification('Cập Nhật Thành Công');
    }
}
