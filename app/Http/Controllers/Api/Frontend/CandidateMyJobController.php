<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AppliedJob;
use Illuminate\Http\JsonResponse;

class CandidateMyJobController extends Controller
{
    /**
     * GET /api/candidate/my-jobs
     * List all jobs applied by the authenticated candidate (paginated)
     */
    public function index(): JsonResponse
    {
        $candidateId = auth()->user()->id;

        $appliedJobs = AppliedJob::with('job') // eager load job relation
            ->where('candidate_id', $candidateId)
            ->orderBy('id', 'DESC')
            ->paginate(10); // paginate 10 per page, can be customized

        return response()->json([
            'status' => true,
            'data' => $appliedJobs
        ]);
    }
}
