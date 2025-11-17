<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CountryStoreRequest;
use App\Http\Requests\Admin\CountryUpdateRequest;
use App\Services\Admin\CountryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class CountryController extends Controller
{
    protected CountryService $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->middleware(['permission:job locations']);
        $this->countryService = $countryService;
    }

    public function index(): View
    {
        $countries = $this->countryService->getPaginatedCountries();
        return view('admin.location.country.index', compact('countries'));
    }

    public function create(): View
    {
        return view('admin.location.country.create');
    }

    public function store(CountryStoreRequest $request): RedirectResponse
    {
        try {
            $this->countryService->createCountry($request->validated());
            return redirect()->route('admin.countries.index')->with('success', 'Thêm quốc gia thành công');
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Không thể tạo quốc gia');
        }
    }

    public function edit(string $id): View
    {
        $country = $this->countryService->findCountryById($id);
        return view('admin.location.country.edit', compact('country'));
    }

    public function update(CountryUpdateRequest $request, string $id): RedirectResponse
    {
        try {
            $this->countryService->updateCountry($id, $request->validated());
            return redirect()->route('admin.countries.index')->with('success', 'Cập nhật quốc gia thành công');
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Không thể cập nhật quốc gia');
        }
    }

    public function destroy(string $id): RedirectResponse
    {
        try {
            $this->countryService->deleteCountry($id);
            return redirect()->route('admin.countries.index')->with('success', 'Xóa quốc gia thành công');
        } catch (Throwable $e) {
            return redirect()->route('admin.countries.index')->with('error', 'Không thể xóa quốc gia');
        }
    }
}
