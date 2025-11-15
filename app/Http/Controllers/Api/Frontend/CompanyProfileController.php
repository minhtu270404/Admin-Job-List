<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CompanyFoundingInfoUpdateRequest;
use App\Http\Requests\Frontend\CompanyInfoUpdateRequest;
use App\Models\City;
use App\Models\Company;
use App\Models\Country;
use App\Models\IndustryType;
use App\Models\OrganizationType;
use App\Models\State;
use App\Models\TeamSize;
use App\Services\Notify;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class CompanyProfileController extends Controller
{
    use FileUploadTrait;

    /**
     * GET /api/company/profile
     */
    public function index(): JsonResponse
    {
        $companyInfo = Company::where('user_id', auth()->user()->id)->first();
        if (!$companyInfo) {
            return response()->json([
                'status' => false,
                'message' => 'Company profile not found'
            ], 404);
        }

        $industryTypes = IndustryType::all();
        $organizationTypes = OrganizationType::all();
        $teamSizes = TeamSize::all();
        $countries = Country::all();
        $states = State::select(['id', 'name', 'country_id'])->where('country_id', $companyInfo?->country)->get();
        $cities = City::select(['id', 'name', 'state_id', 'country_id'])->where('state_id', $companyInfo?->state)->get();

        return response()->json([
            'status' => true,
            'data' => compact('companyInfo', 'industryTypes', 'organizationTypes', 'teamSizes', 'countries', 'states', 'cities')
        ]);
    }

    /**
     * POST /api/company/profile/update-info
     */
    public function updateCompanyInfo(CompanyInfoUpdateRequest $request): JsonResponse
    {
        $logoPath = $this->uploadFile($request, 'logo');
        $bannerPath = $this->uploadFile($request, 'banner');

        $data = [
            'name' => $request->name,
            'bio' => $request->bio,
            'vision' => $request->vision,
        ];

        if(!empty($logoPath)) $data['logo'] = $logoPath;
        if(!empty($bannerPath)) $data['banner'] = $bannerPath;

        Company::updateOrCreate(['user_id' => auth()->user()->id], $data);

        $this->updateProfileStatus();

        Notify::updatedNotification('Cập nhập thông tin thành công');

        return response()->json(['status' => true, 'message' => 'Company info updated successfully']);
    }

    /**
     * POST /api/company/profile/update-founding
     */
    public function updateFoundingInfo(CompanyFoundingInfoUpdateRequest $request): JsonResponse
    {
        Company::updateOrCreate(
            ['user_id' => auth()->user()->id],
            [
                'industry_type_id' => $request->industry_type,
                'organization_type_id' => $request->organization_type,
                'team_size_id' => $request->team_size,
                'establishment_date' => $request->establishment_date,
                'website' => $request->website,
                'email' => $request->email,
                'phone' => $request->phone,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'address' => $request->address,
                'map_link' => $request->map_link
            ]
        );

        $this->updateProfileStatus();

        Notify::updatedNotification('Cập nhập thông tin thành công');

        return response()->json(['status' => true, 'message' => 'Founding info updated successfully']);
    }

    /**
     * POST /api/company/profile/update-account
     */
    public function updateAccountInfo(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email']
        ]);

        Auth::user()->update($validatedData);
        Notify::updatedNotification('Cập nhập thông tin thành công');

        return response()->json(['status' => true, 'message' => 'Account info updated successfully']);
    }

    /**
     * POST /api/company/profile/update-password
     */
    public function updatePassword(Request $request): JsonResponse
    {
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()]
        ]);

        Auth::user()->update(['password' => bcrypt($request->password)]);
        Notify::updatedNotification('Cập nhập thông tin thành công');

        return response()->json(['status' => true, 'message' => 'Password updated successfully']);
    }

    /**
     * Update company profile completion status
     */
    private function updateProfileStatus(): void
    {
        if (isCompanyProfileComplete()) {
            $companyProfile = Company::where('user_id', auth()->user()->id)->first();
            if ($companyProfile) {
                $companyProfile->profile_completion = 1;
                $companyProfile->visibility = 1;
                $companyProfile->save();
            }
        }
    }
}
