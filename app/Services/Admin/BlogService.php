<?php

namespace App\Services\Admin;

use App\Models\Blog;
use App\Services\Notify;
use App\Traits\FileUploadTrait;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class BlogService
{
    use FileUploadTrait, Searchable;

    /**
     * Lấy danh sách blog với tìm kiếm và phân trang
     */
    public function getAllBlogs(Request $request)
    {
        $query = Blog::query();
        $this->search($query, ['title', 'slug']);
        return $query->orderBy('id', 'DESC')->paginate(20);
    }

    /**
     * Lấy thông tin chi tiết 1 blog theo ID
     */
    public function getBlogById(string $id): Blog
    {
        return Blog::findOrFail($id);
    }

    /**
     * Tạo blog mới
     */
    public function createBlog(Request $request): void
    {
        $imagePath = $this->uploadFile($request, 'image', 'uploads/blogs');

        $blog = new Blog();
        $blog->image = $imagePath;
        $blog->title = $request->title;
        $blog->author_id = auth()->user()->id;
        $blog->description = $request->description;
        $blog->status = $request->status;
        $blog->featured = $request->featured;
        $blog->save();

        Notify::createdNotification('Thêm Mới Thành Công');
    }

    /**
     * Cập nhật blog
     */
    public function updateBlog(Request $request, string $id): void
    {
        $blog = Blog::findOrFail($id);
        $imagePath = $this->uploadFile($request, 'image', 'uploads/blogs');

        if ($imagePath) {
            $blog->image = $imagePath;
        }

        $blog->title = $request->title;
        $blog->author_id = auth()->user()->id;
        $blog->description = $request->description;
        $blog->status = $request->status;
        $blog->featured = $request->featured;
        $blog->save();

        Notify::updatedNotification('Cập Nhật Thành Công');
    }

    /**
     * Xóa blog
     */
    public function deleteBlog(string $id): JsonResponse
    {
        try {
            $blog = Blog::findOrFail($id);
            $blog->delete();

 Notify::deletedNotification('Xóa Thành Công');            return response()->json(['message' => 'success'], 200);
        } catch (\Exception $e) {
            Log::error('Blog delete failed: ' . $e->getMessage());
            return response()->json(['message' => 'Đã xảy ra lỗi, vui lòng thử lại!'], 500);
        }
    }
}
