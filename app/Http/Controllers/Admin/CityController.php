<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CityRequest;
use App\Services\Admin\CityService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CityController extends Controller
{
    protected CityService $cityService;

    public function __construct(CityService $cityService)
    {
        $this->middleware(['permission:job locations']);
        $this->cityService = $cityService;
    }

    public function index(): View
    {
        $cities = $this->cityService->getAllCities();
        return view('admin.location.city.index', compact('cities'));
    }

    public function create(): View
    {
        $countries = $this->cityService->getAllCountries();
        return view('admin.location.city.create', compact('countries'));
    }

    public function store(CityRequest $request): RedirectResponse
    {
        $this->cityService->createCity($request->validated());
        return redirect()->route('admin.cities.index')->with('success', 'Thêm thành phố thành công');
    }

    public function edit(string $id): View
    {
        [$city, $countries, $states] = $this->cityService->getCityEditData($id);
        return view('admin.location.city.edit', compact('city', 'countries', 'states'));
    }

    public function update(CityRequest $request, string $id): RedirectResponse
    {
        $this->cityService->updateCity($request->validated(), $id);
        return redirect()->route('admin.cities.index')->with('success', 'Cập nhật thành phố thành công');
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->cityService->deleteCity($id);
        return redirect()->route('admin.cities.index')->with('success', 'Xóa thành phố thành công');
    }

    /** AJAX: Lấy thành phố theo state */
    public function getCitiesByState($state_id)
    {
        $cities = \App\Models\City::where('state_id', $state_id)->get(['id', 'name']);
        return response()->json($cities);
    }
}
