<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CityRequest;
use App\Services\Admin\CityService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class CityController extends Controller
{
    protected CityService $cityService;

    public function __construct(CityService $cityService)
    {
        $this->middleware(['permission:job locations']);
        $this->cityService = $cityService;
    }


    public function index(Request $request)
    {
        $cities = $this->cityService->getAllCities($request);
        return view('admin.location.city.index', compact('cities'));
    }

    public function create()
    {
        $countries = $this->cityService->getAllCountries();
        return view('admin.location.city.create', compact('countries'));
    }

    public function store(CityRequest $request)
    {
        $this->cityService->createCity($request);
        return redirect()->route('admin.cities.index')->with('success', 'Thêm thành phố thành công!');
    }

    public function edit(string $id): View
    {
        [$city, $countries, $states] = $this->cityService->getCityEditData($id);
        return view('admin.location.city.edit', compact('city', 'countries', 'states'));
    }

   
    public function update(CityRequest $request, string $id)
    {
        $this->cityService->updateCity($request, $id);
        return redirect()->route('admin.cities.index')->with('success', 'Cập nhật thành phố thành công!');
    }

   
    public function destroy(string $id)
    {
        return $this->cityService->deleteCity($id);
    }
}
