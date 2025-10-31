<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReviewCreateRequest;
use App\Http\Requests\Admin\ReviewUpdateRequest;
use App\Services\Admin\ReviewService;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ReviewController extends Controller
{
    protected ReviewService $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->middleware(['permission:sections']);
        $this->reviewService = $reviewService;
    }

    public function index(): View
    {
        $reviews = $this->reviewService->getAllWithSearch();
        return view('admin.review.index', compact('reviews'));
    }

    public function create(): View
    {
        return view('admin.review.create');
    }

    public function store(ReviewCreateRequest $request): RedirectResponse
    {
        $this->reviewService->create($request);
        return redirect()->route('admin.reviews.index');
    }

    public function edit(string $id): View
    {
        $review = $this->reviewService->find($id);
        return view('admin.review.edit', compact('review'));
    }

    public function update(ReviewUpdateRequest $request, string $id): RedirectResponse
    {
        $this->reviewService->update($id, $request);
        return redirect()->route('admin.reviews.index');
    }

    public function destroy(string $id)
    {
        return $this->reviewService->delete($id);
    }
}
