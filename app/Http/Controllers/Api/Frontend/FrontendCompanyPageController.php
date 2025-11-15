<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Company;
use App\Models\Country;
use App\Models\IndustryType;
use App\Models\Job;
use App\Models\OrganizationType;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FrontendCompanyPageController extends Controller
{
    /**
     * GET /api/companies
     * Trả danh sách companies (có filter & phân trang)
     */
    public function index(Request $request): JsonResponse
    {
        $countries = Country::all();
        $industryTypes = IndustryType::withCount('companies')->get();
        $organizations = OrganizationType::withCount('companies')->get();
        $selectedStates = null;
        $selectedCities = null;

        $query = Company::query()->withCount([
            'jobs' => function($q) {
                $q->where('status', 'active')->where('deadline', '>=', date('Y-m-d'));
            }
        ])->where(['profile_completion' => 1, 'visibility' => 1]);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        if ($request->filled('state')) {
            $query->where('state', $request->state);
            $selectedStates = State::where('country_id', $request->country)->get();
            $selectedCities = City::where('state_id', $request->state)->get();
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('industry')) {
            $query->whereHas('industryType', function($q) use ($request) {
                $q->where('slug', $request->industry);
            });
        }

        if ($request->filled('organization')) {
            $query->whereHas('organizationType', function($q) use ($request) {
                $q->where('slug', $request->organization);
            });
        }

        $companies = $query->paginate(21);

        return response()->json([
            'status' => true,
            'data' => [
                'companies' => $companies,
                'countries' => $countries,
                'states' => $selectedStates,
                'cities' => $selectedCities,
                'industry_types' => $industryTypes,
                'organization_types' => $organizations,
            ]
        ]);
    }

    /**
     * GET /api/companies/{slug}
     * Trả chi tiết company và các job active
     */
    public function show(string $slug): JsonResponse
    {
        $company = Company::where([
            'profile_completion' => 1,
            'visibility' => 1,
            'slug' => $slug
        ])->firstOrFail();

        $openJobs = Job::where('company_id', $company->id)
            ->where('status', 'active')
            ->where('deadline', '>=', date('Y-m-d'))
            ->paginate(10);

        return response()->json([
            'status' => true,
            'data' => [
                'company' => $company,
                'open_jobs' => $openJobs,
            ]
        ]);
    }
}
