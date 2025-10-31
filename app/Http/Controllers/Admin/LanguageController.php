<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LanguageRequest;
use App\Services\Admin\LanguageService;
use App\Services\Notify;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Response;

class LanguageController extends Controller
{
    protected LanguageService $languageService;

    public function __construct(LanguageService $languageService)
    {
        $this->middleware(['permission:job attributes']);
        $this->languageService = $languageService;
    }

    public function index(Request $request): View
    {
        $languages = $this->languageService->getAllPaginated(20, $request->search);
        return view('admin.language.index', compact('languages'));
    }

    public function create(): View
    {
        return view('admin.language.create');
    }

    public function store(LanguageRequest $request): RedirectResponse
    {
        $this->languageService->create($request->validated());
        Notify::createdNotification('Thêm Mới Thành Công');
        return redirect()->route('admin.languages.index');
    }

    public function edit(string $id): View
    {
        $language = \App\Models\Language::findOrFail($id);
        return view('admin.language.edit', compact('language'));
    }

    public function update(LanguageRequest $request, string $id): RedirectResponse
    {
        $this->languageService->update($id, $request->validated());
        Notify::updatedNotification('Cập Nhật Thành Công');
        return redirect()->route('admin.languages.index');
    }

    public function destroy(string $id): Response
    {
        try {
            $this->languageService->delete($id);
 Notify::deletedNotification('Xóa Thành Công');            return response(['message' => 'success'], 200);
        } catch (\Exception $e) {
            logger($e->getMessage());
            return response(['message' => $e->getMessage()], 500);
        }
    }
}
