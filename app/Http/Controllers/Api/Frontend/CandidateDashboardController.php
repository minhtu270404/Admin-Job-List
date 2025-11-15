<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AppliedJob;
use App\Models\JobBookmark;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CandidateDashboardController extends Controller
{
    /**
     * GET /api/candidate/dashboard
     * Candidate dashboard data
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();

        // Candidate profile id
        $candidateId = $user->id;
        $candidateProfileId = $user->candidateProfile?->id;

        // Số job đã ứng tuyển
        $jobAppliedCount = AppliedJob::where('candidate_id', $candidateId)->count();

        // Số job đã bookmark
        $userBookmarksCount = JobBookmark::where('candidate_id', $candidateProfileId)->count();

        // 10 job ứng tuyển gần nhất
        $appliedJobs = AppliedJob::with([
            'job:id,title,company_id,status,deadline',
            'job.company:id,name,logo'
        ])
        ->where('candidate_id', $candidateId)
        ->latest()
        ->take(10)
        ->get();

        return response()->json([
            'status' => true,
            'data' => [
                'applied_job_count'   => $jobAppliedCount,
                'bookmark_count'      => $userBookmarksCount,
                'recent_applied_jobs' => $appliedJobs,
            ]
        ]);
    }
}
