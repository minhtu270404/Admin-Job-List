<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogCreateRequest;
use App\Http\Requests\Admin\BlogUpdateRequest;
use App\Services\Admin\BlogService;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected BlogService $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->middleware(['permission:blogs']);
        $this->blogService = $blogService;
    }

    public function index(Request $request)
    {
        $blogs = $this->blogService->getAllBlogs($request);
        return view('admin.blog.index', compact('blogs'));
    }

  
    public function create(): View
    {
        return view('admin.blog.create');
    }

    public function store(BlogCreateRequest $request)
    {
        $this->blogService->createBlog($request);
        return redirect()->route('admin.blogs.index')->with('success', 'Tạo bài viết mới thành công!');
    }

    public function edit(string $id)
    {
        $blog = $this->blogService->getBlogById($id);
        return view('admin.blog.edit', compact('blog'));
    }


    public function update(BlogUpdateRequest $request, string $id)
    {
        $this->blogService->updateBlog($request, $id);
        return redirect()->route('admin.blogs.index')->with('success', 'Cập nhật bài viết thành công!');
    }


    public function destroy(string $id)
    {
        return $this->blogService->deleteBlog($id);
    }
}
