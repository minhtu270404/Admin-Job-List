<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TagRequest;
use App\Models\JobTag;
use App\Models\Tag;
use App\Services\Admin\TagService;
use App\Services\Notify;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class TagController extends Controller
{
    protected TagService $tagService;

    public function __construct(TagService $tagService)
    {
        $this->middleware(['permission:job attributes']);
        $this->tagService = $tagService;
    }

    public function index(Request $request): View
    {
        $search = $request->input('search');
        $tags = $this->tagService->getAll($search);
        return view('admin.job.tag.index', compact('tags'));
    }

    public function create(): View
    {
        return view('admin.job.tag.create');
    }

    public function store(TagRequest $request): RedirectResponse
    {
        $this->tagService->create($request->validated());
        Notify::createdNotification('Thêm Mới Thành Công');
        return redirect()->route('admin.tags.index');
    }

    public function edit(Tag $tag): View
    {
        return view('admin.job.tag.edit', compact('tag'));
    }

    public function update(TagRequest $request, Tag $tag): RedirectResponse
    {
        $this->tagService->update($tag, $request->validated());
        Notify::updatedNotification('Cập Nhật Thành Công');
        return redirect()->route('admin.tags.index');
    }

    public function destroy(Tag $tag)
    {
        // Kiểm tra liên kết trước khi xóa
        if (JobTag::where('tag_id', $tag->id)->exists()) {
            return response(['message' => 'Tag này đã được sử dụng, không thể xóa!'], 400);
        }

        try {
            $this->tagService->delete($tag);
 Notify::deletedNotification('Xóa Thành Công');            return response(['message' => 'success'], 200);
        } catch (Throwable $e) {
            return response(['message' => 'Đã xảy ra lỗi, vui lòng thử lại sau!'], 500);
        }
    }
}
