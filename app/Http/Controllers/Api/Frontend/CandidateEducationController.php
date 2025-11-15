<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CandidateEducationStoreRequest;
use App\Models\CandidateEducation;
use Illuminate\Http\JsonResponse;

class CandidateEducationController extends Controller
{
    /**
     * GET /api/candidate/educations
     * Display a listing of candidate's educations
     */
    public function index(): JsonResponse
    {
        $candidateId = auth()->user()->candidateProfile->id;

        $candidateEducations = CandidateEducation::where('candidate_id', $candidateId)
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $candidateEducations
        ]);
    }

    /**
     * POST /api/candidate/educations
     * Store a newly created education
     */
    public function store(CandidateEducationStoreRequest $request): JsonResponse
    {
        $education = CandidateEducation::create([
            'candidate_id' => auth()->user()->candidateProfile->id,
            'level'        => $request->level,
            'degree'       => $request->degree,
            'year'         => $request->year,
            'note'         => $request->note,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Created Successfully',
            'data' => $education
        ]);
    }

    /**
     * GET /api/candidate/educations/{id}
     * Display a specific education
     */
    public function show(string $id): JsonResponse
    {
        $education = CandidateEducation::findOrFail($id);

        if(auth()->user()->candidateProfile->id !== $education->candidate_id) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        return response()->json([
            'status' => true,
            'data' => $education
        ]);
    }

    /**
     * PUT /api/candidate/educations/{id}
     * Update a specific education
     */
    public function update(CandidateEducationStoreRequest $request, string $id): JsonResponse
    {
        $education = CandidateEducation::findOrFail($id);

        if(auth()->user()->candidateProfile->id !== $education->candidate_id) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $education->update([
            'level' => $request->level,
            'degree' => $request->degree,
            'year' => $request->year,
            'note' => $request->note,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Updated Successfully',
            'data' => $education
        ]);
    }

    /**
     * DELETE /api/candidate/educations/{id}
     * Delete a specific education
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $education = CandidateEducation::findOrFail($id);

            if(auth()->user()->candidateProfile->id !== $education->candidate_id) {
                return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
            }

            $education->delete();

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
