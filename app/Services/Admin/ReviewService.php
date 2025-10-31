<?php

namespace App\Services\Admin;

use App\Models\Review;
use App\Services\Notify;
use App\Traits\FileUploadTrait;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReviewService
{
    use FileUploadTrait, Searchable;

    // Lấy danh sách + tìm kiếm
    public function getAllWithSearch()
    {
        $query = Review::query();
        $this->search($query, ['name', 'title', 'rating']);
        return $query->latest()->paginate(20);
    }

    // Tìm theo ID
    public function find(string $id): Review
    {
        return Review::findOrFail($id);
    }

    // Thêm mới
    public function create(Request $request): void
    {
        $imagePath = $this->uploadFile($request, 'image');

        Review::create([
            'image'  => $imagePath,
            'name'   => $request->name,
            'title'  => $request->title,
            'review' => $request->review,
            'rating' => $request->rating,
        ]);

        Notify::createdNotification('Thêm Mới Thành Công');
    }

    // Cập nhật
    public function update(string $id, Request $request): void
    {
        $review = $this->find($id);
        $imagePath = $this->uploadFile($request, 'image');

        if ($imagePath) {
            $review->image = $imagePath;
        }

        $review->fill([
            'name'   => $request->name,
            'title'  => $request->title,
            'review' => $request->review,
            'rating' => $request->rating,
        ])->save();

        Notify::updatedNotification('Cập Nhật Thành Công');
    }

    // Xoá
    public function delete(string $id)
    {
        try {
            $this->find($id)->delete();
 Notify::deletedNotification('Xóa Thành Công');            return response(['message' => 'Xoá thành công'], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response(['message' => 'Đã có lỗi xảy ra, vui lòng thử lại!'], 500);
        }
    }
}
