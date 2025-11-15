<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Models\JobBookmark;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class CandidateJobBookmarkController extends Controller
{
    /**
     * GET /api/candidate/bookmarks
     * List candidate job bookmarks (paginated)
     */
    public function index(): JsonResponse
    {
        $candidateId = auth()->user()->candidateProfile->id;

        $bookmarks = JobBookmark::where('candidate_id', $candidateId)
            ->with('job') // eager load job relation
            ->paginate(10);

        return response()->json([
            'status' => true,
            'data' => $bookmarks
        ]);
    }

    /**
     * POST /api/candidate/bookmarks/{jobId}
     * Add a job bookmark
     */
    public function save(string $jobId): JsonResponse
    {
        if (!auth()->check()) {
            throw ValidationException::withMessages(['login' => 'Please login first for bookmark']);
        }

        if (auth()->user()->role !== 'candidate') {
            throw ValidationException::withMessages(['role' => 'Only candidates can add bookmarks']);
        }

        $candidateId = auth()->user()->candidateProfile->id;

        $alreadyMarked = JobBookmark::where([
            'job_id' => $jobId,
            'candidate_id' => $candidateId
        ])->exists();

        if ($alreadyMarked) {
            throw ValidationException::withMessages(['bookmark' => 'Post is already bookmarked!']);
        }

        $bookmark = JobBookmark::create([
            'job_id' => $jobId,
            'candidate_id' => $candidateId
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Bookmark added successfully!',
            'data' => ['id' => $bookmark->id, 'job_id' => $jobId]
        ]);
    }
}
