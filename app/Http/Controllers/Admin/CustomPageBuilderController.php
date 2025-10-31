<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CustomPageBuilder\StoreCustomPageRequest;
use App\Http\Requests\Admin\CustomPageBuilder\UpdateCustomPageRequest;
use App\Services\Admin\CustomPageBuilderService;
use App\Traits\Searchable;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomPageBuilderController extends Controller
{
    use Searchable;

    protected CustomPageBuilderService $pageService;

    public function __construct(CustomPageBuilderService $pageService)
    {
        $this->middleware(['permission:site pages']);
        $this->pageService = $pageService;
    }

    public function index(Request $request): View
    {
        $pages = $this->pageService->getAllWithSearch($request, ['page_name']);
        return view('admin.page-builder.index', compact('pages'));
    }

    public function create(): View
    {
        return view('admin.page-builder.create');
    }

    public function store(StoreCustomPageRequest $request): RedirectResponse
    {
        try {
            $this->pageService->create($request->validated());
            return redirect()->route('admin.page-builder.index');
        } catch (\Throwable $e) {
            Log::error('Error creating page: '.$e->getMessage());
            return back()->with('error', 'Không thể tạo trang, vui lòng thử lại.');
        }
    }

    public function edit(string $id): View
    {
        $page = $this->pageService->find($id);
        return view('admin.page-builder.edit', compact('page'));
    }

    public function update(UpdateCustomPageRequest $request, string $id): RedirectResponse
    {
        try {
            $this->pageService->update($id, $request->validated());
            return redirect()->route('admin.page-builder.index');
        } catch (\Throwable $e) {
            Log::error('Error updating page: '.$e->getMessage());
            return back()->with('error', 'Không thể cập nhật trang, vui lòng thử lại.');
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->pageService->delete($id);
            return response(['message' => 'success'], 200);
        } catch (\Throwable $e) {
            Log::error('Error deleting page: '.$e->getMessage());
            return response(['message' => 'Something went wrong. Please try again!'], 500);
        }
    }
}
