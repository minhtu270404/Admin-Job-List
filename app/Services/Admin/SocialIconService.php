<?php

namespace App\Services\Admin;

use App\Models\SocialIcon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Exception;

class SocialIconService
{
    public function getAll()
    {
        return SocialIcon::paginate(20);
    }

    public function find(string $id): SocialIcon
    {
        return SocialIcon::findOrFail($id);
    }

    public function store(array $data): SocialIcon
    {
        return SocialIcon::create($data);
    }

    public function update(string $id, array $data): SocialIcon
    {
        $social = SocialIcon::findOrFail($id);
        $social->update($data);
        return $social;
    }

    public function delete(string $id): Response
    {
        try {
            SocialIcon::findOrFail($id)->delete();
 Notify::deletedNotification('Xóa Thành Công');            return response(['message' => 'Xóa thành công!'], 200);
        } catch (Exception $e) {
            Log::error($e);
            return response(['message' => 'Đã xảy ra lỗi, vui lòng thử lại sau!'], 500);
        }
    }
}
