<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\State\StateRequest;
use App\Services\Admin\StateService;
use App\Services\Notify;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
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
        Notify::createdNotification('Thêm Mới Thành Công');
        return redirect()->route('admin.states.index');
    }

    public function edit(string $id): View
    {
        [$countries, $state] = $this->stateService->edit($id);
        return view('admin.location.state.edit', compact('countries', 'state'));
    }

    public function update(StateRequest $request, string $id): RedirectResponse
    {
        $this->stateService->update($id, $request->validated());
        Notify::updatedNotification('Cập Nhật Thành Công');
        return redirect()->route('admin.states.index');
    }

    public function destroy(string $id): Response
    {
        return $this->stateService->delete($id);
    }
}
