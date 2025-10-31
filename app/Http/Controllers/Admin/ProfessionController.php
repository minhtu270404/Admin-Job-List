<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfessionRequest;
use App\Services\Admin\ProfessionService;
use App\Traits\Searchable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfessionController extends Controller
{
    use Searchable;

    protected ProfessionService $professionService;

    public function __construct(ProfessionService $professionService)
    {
        $this->middleware(['permission:job attributes']);
        $this->professionService = $professionService;
    }

    public function index(): View
    {
        $query = $this->professionService->queryWithSearch(request(), ['name']);
        $professions = $query->paginate(20);

        return view('admin.profession.index', compact('professions'));
    }

    public function create(): View
    {
        return view('admin.profession.create');
    }

    public function store(ProfessionRequest $request): RedirectResponse
    {
        $this->professionService->create($request->validated());
        return redirect()->route('admin.professions.index');
    }

    public function edit(string $id): View
    {
        $profession = $this->professionService->find($id);
        return view('admin.profession.edit', compact('profession'));
    }

    public function update(ProfessionRequest $request, string $id): RedirectResponse
    {
        $this->professionService->update($id, $request->validated());
        return redirect()->route('admin.professions.index');
    }

    public function destroy(string $id)
    {
        return $this->professionService->delete($id);
    }
}
