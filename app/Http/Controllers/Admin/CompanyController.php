<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CompanyRequest;
use App\Models\Company;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\IndustryType;
use App\Models\OrganizationType;
use App\Models\TeamSize;
use App\Services\Admin\CompanyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CompanyController extends Controller
{
    protected CompanyService $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function index(): View
    {
        $search = request()->get('search');
        $companies = $this->companyService->getAll($search);

        return view('admin.companies.index', compact('companies', 'search'));
    }

    public function create(): View
    {
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();
        $industries = IndustryType::all();
        $organizations = OrganizationType::all();
        $teamSizes = TeamSize::all();

        return view('admin.companies.create', compact('countries', 'states', 'cities', 'industries', 'organizations', 'teamSizes'));
    }

    public function store(CompanyRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $this->companyService->create($data);

        return redirect()->route('admin.companies.index')->with('success', 'Thêm công ty thành công');
    }

    public function edit(Company $company): View
    {
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();
        $industries = IndustryType::all();
        $organizations = OrganizationType::all();
        $teamSizes = TeamSize::all();

        return view('admin.companies.edit', compact('company', 'countries', 'states', 'cities', 'industries', 'organizations', 'teamSizes'));
    }

    public function update(CompanyRequest $request, Company $company): RedirectResponse
    {
        $data = $request->validated();
        $this->companyService->update($company, $data);

        return redirect()->route('admin.companies.index')->with('success', 'Cập nhật công ty thành công');
    }

    public function destroy(Company $company): RedirectResponse
    {
        $this->companyService->delete($company);

        return redirect()->route('admin.companies.index')->with('success', 'Xóa công ty thành công');
    }
}
