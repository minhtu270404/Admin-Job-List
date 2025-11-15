<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CandidateAccountInfoUpdateRequest;
use App\Http\Requests\Frontend\CandidateBasicProfileUpdateRequest;
use App\Http\Requests\Frontend\CandidateProfileInfoUpdateRequest;
use App\Models\Candidate;
use App\Models\CandidateEducation;
use App\Models\CandidateExperience;
use App\Models\CandidateLanguage;
use App\Models\CandidateSkill;
use App\Models\City;
use App\Models\Country;
use App\Models\Experience;
use App\Models\Language;
use App\Models\Profession;
use App\Models\Skill;
use App\Models\State;
use App\Services\Notify;
use App\Traits\FileUploadTrait;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

class CandidateProfileController extends Controller
{
    use FileUploadTrait;

    /**
     * GET /api/candidate/profile
     * Get full profile data
     */
    public function index(): JsonResponse
    {
        $candidate = Candidate::with(['skills'])->where('user_id', auth()->id())->first();
        $candidateExperiences = CandidateExperience::where('candidate_id', $candidate?->id)->orderBy('id', 'DESC')->get();
        $candidateEducation = CandidateEducation::where('candidate_id', $candidate?->id)->orderBy('id', 'DESC')->get();

        $experiences = Experience::all();
        $professions = Profession::all();
        $skills = Skill::all();
        $languages = Language::all();
        $countries = Country::all();
        $states = State::where('country_id', $candidate?->country)->get();
        $cities = City::where('state_id', $candidate?->state)->get();

        return response()->json([
            'status' => true,
            'data' => [
                'candidate' => $candidate,
                'experiences' => $experiences,
                'professions' => $professions,
                'skills' => $skills,
                'languages' => $languages,
                'candidate_experiences' => $candidateExperiences,
                'candidate_education' => $candidateEducation,
                'countries' => $countries,
                'states' => $states,
                'cities' => $cities
            ]
        ]);
    }

    /**
     * Update basic profile info
     */
    public function basicInfoUpdate(CandidateBasicProfileUpdateRequest $request): JsonResponse
    {
        $imagePath = $this->uploadFile($request, 'profile_picture');
        $cvPath = $this->uploadFile($request, 'cv');

        $data = array_filter([
            'image' => $imagePath,
            'cv' => $cvPath,
            'full_name' => $request->full_name,
            'title' => $request->title,
            'experience_id' => $request->experience_level,
            'website' => $request->website,
            'birth_date' => $request->date_of_birth,
        ]);

        Candidate::updateOrCreate(
            ['user_id' => auth()->id()],
            $data
        );

        $this->updateProfileStatus();
        Notify::updatedNotification('Cập nhập thông tin thành công');

        return response()->json(['status' => true, 'message' => 'Basic info updated successfully']);
    }

    /**
     * Update profile info (skills, languages, bio, profession)
     */
    public function profileInfoUpdate(CandidateProfileInfoUpdateRequest $request): JsonResponse
    {
        $data = [
            'gender' => $request->gender,
            'marital_status' => $request->marital_status,
            'profession_id' => $request->profession,
            'status' => $request->availability,
            'bio' => $request->biography
        ];

        Candidate::updateOrCreate(['user_id' => auth()->id()], $data);

        $candidate = Candidate::where('user_id', auth()->id())->first();

        CandidateLanguage::where('candidate_id', $candidate->id)->delete();
        foreach ($request->language_you_know as $language) {
            CandidateLanguage::create([
                'candidate_id' => $candidate->id,
                'language_id' => $language
            ]);
        }

        CandidateSkill::where('candidate_id', $candidate->id)->delete();
        foreach ($request->skill_you_have as $skill) {
            CandidateSkill::create([
                'candidate_id' => $candidate->id,
                'skill_id' => $skill
            ]);
        }

        $this->updateProfileStatus();
        Notify::updatedNotification('Cập nhập thông tin thành công');

        return response()->json(['status' => true, 'message' => 'Profile info updated successfully']);
    }

    /**
     * Update account info (address, phone, email)
     */
    public function accountInfoUpdate(CandidateAccountInfoUpdateRequest $request): JsonResponse
    {
        Candidate::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'address' => $request->address,
                'phone_one' => $request->phone,
                'phone_two' => $request->secondary_phone,
                'email' => $request->email,
            ]
        );

        $this->updateProfileStatus();
        Notify::updatedNotification('Cập nhập thông tin thành công');

        return response()->json(['status' => true, 'message' => 'Account info updated successfully']);
    }

    /**
     * Update account email
     */
    public function accountEmailUpdate(Request $request): JsonResponse
    {
        $request->validate([
            'account_email' => ['required', 'email']
        ]);

        Auth::user()->update(['email' => $request->account_email]);
        Notify::updatedNotification('Cập nhập thông tin thành công');

        return response()->json(['status' => true, 'message' => 'Email updated successfully']);
    }

    /**
     * Update account password
     */
    public function accountPasswordUpdate(Request $request): JsonResponse
    {
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()]
        ]);

        Auth::user()->update(['password' => bcrypt($request->password)]);
        Notify::updatedNotification('Cập nhập thông tin thành công');

        return response()->json(['status' => true, 'message' => 'Password updated successfully']);
    }

    /**
     * Update profile complete status
     */
    private function updateProfileStatus(): void
    {
        if (isCandidateProfileComplete()) {
            $candidate = Candidate::where('user_id', auth()->id())->first();
            $candidate->profile_complete = 1;
            $candidate->visibility = 1;
            $candidate->save();
        }
    }
}
