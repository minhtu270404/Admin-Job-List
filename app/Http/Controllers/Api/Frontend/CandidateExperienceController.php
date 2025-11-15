<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CandidateExperienceStoreRequest;
use App\Models\CandidateExperience;
use Illuminate\Http\JsonResponse;

class CandidateExperienceController extends Controller
{
    /**
     * GET /api/candidate/experiences
     * List candidate experiences
     */
    public function index(): JsonResponse
    {
        $candidateId = auth()->user()->candidateProfile->id;

        $candidateExperiences = CandidateExperience::where('candidate_id', $candidateId)
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $candidateExperiences
        ]);
    }

    /**
     * POST /api/candidate/experiences
     * Store a new experience
     */
    public function store(CandidateExperienceStoreRequest $request): JsonResponse
    {
        $experience = CandidateExperience::create([
            'candidate_id' => auth()->user()->candidateProfile->id,
            'company' => $request->company,
            'department' => $request->department,
            'designation' => $request->designation,
            'start' => $request->start,
            'end' => $request->end,
            'currently_working' => $request->filled('currently_working') ? 1 : 0,
            'responsibilities' => $request->responsibilities,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Created Successfully',
            'data' => $experience
        ]);
    }

    /**
     * GET /api/candidate/experiences/{id}
     * Show a specific experience
     */
    public function show(string $id): JsonResponse
    {
        $experience = CandidateExperience::findOrFail($id);

        if(auth()->user()->candidateProfile->id !== $experience->candidate_id) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        return response()->json([
            'status' => true,
            'data' => $experience
        ]);
    }

    /**
     * PUT /api/candidate/experiences/{id}
     * Update an experience
     */
    public function update(CandidateExperienceStoreRequest $request, string $id): JsonResponse
    {
        $experience = CandidateExperience::findOrFail($id);

        if(auth()->user()->candidateProfile->id !== $experience->candidate_id) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $experience->update([
            'company' => $request->company,
            'department' => $request->department,
            'designation' => $request->designation,
            'start' => $request->start,
            'end' => $request->end,
            'currently_working' => $request->filled('currently_working') ? 1 : 0,
            'responsibilities' => $request->responsibilities,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Updated Successfully',
            'data' => $experience
        ]);
    }

    /**
     * DELETE /api/candidate/experiences/{id}
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $experience = CandidateExperience::findOrFail($id);

            if(auth()->user()->candidateProfile->id !== $experience->candidate_id) {
                return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
            }

            $experience->delete();

            return response()->json([
                'status' => true,
                'message' => 'Deleted Successfully'
            ]);

        } catch (\Exception $e) {
            logger($e);
            return response()->json([
                'status' => false,
                'message' => 'Something Went Wrong, Please Try Again!'
            ], 500);
        }
    }
}
