<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FrontendBlogPageController extends Controller
{
    use Searchable;

    /**
     * GET /api/blogs
     * Trả danh sách blog (có phân trang + tìm kiếm)
     */
    public function index(Request $request): JsonResponse
    {
        $query = Blog::query()->where('status', 1);

        // Tìm kiếm nếu có
        if ($search = $request->query('search')) {
            $this->search($query, ['title', 'slug'], $search);
        }

        $blogs = $query->orderBy('id', 'DESC')->paginate(20);

        $featured = Blog::where('status', 1)
            ->where('featured', 1)
            ->orderBy('id', 'DESC')
            ->take(10)
            ->get();

        return response()->json([
            'status' => true,
            'data' => [
                'blogs' => $blogs,
                'featured' => $featured,
            ]
        ]);
    }

    /**
     * GET /api/blogs/{slug}
     * Trả chi tiết blog
     */
    public function show(string $slug): JsonResponse
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();

        return response()->json([
            'status' => true,
            'data' => $blog
        ]);
    }
}
