<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StateRequest;
use App\Services\Admin\StateService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StateController extends Controller
{
    protected StateService $stateService;

    public function __construct(StateService $stateService)
    {
        $this->middleware(['permission:job locations']);
        $this->stateService = $stateService;
    }

    public function index(): View
    {
        $states = $this->stateService->getAll();
        return view('admin.location.state.index', compact('states'));
    }

    public function create(): View
    {
        $countries = $this->stateService->getCountries();
        return view('admin.location.state.create', compact('countries'));
    }

    public function store(StateRequest $request): RedirectResponse
    {
        $this->stateService->store($request->validated());
        return redirect()->route('admin.states.index')->with('success', 'Thêm tỉnh/bang thành công');
    }

    public function edit(string $id): View
    {
        $data = $this->stateService->edit($id);
        return view('admin.location.state.edit', $data);
    }

    public function update(StateRequest $request, string $id): RedirectResponse
    {
        $this->stateService->update($id, $request->validated());
        return redirect()->route('admin.states.index')->with('success', 'Cập nhật tỉnh/bang thành công');
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->stateService->delete($id);
        return redirect()->route('admin.states.index')->with('success', 'Xóa tỉnh/bang thành công');
    }
}
