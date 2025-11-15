<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Experience;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FrontendCandidatePageController extends Controller
{
    /**
     * GET /api/candidates
     * Trả danh sách candidates (có phân trang + filter theo skills và experience)
     */
    public function index(Request $request): JsonResponse
    {
        $skills = Skill::all();
        $experiences = Experience::all();

        $query = Candidate::query()->where([
            'profile_complete' => 1,
            'visibility' => 1,
        ]);

        // Filter theo skills
        if ($request->has('skills') && $request->filled('skills')) {
            $ids = Skill::whereIn('slug', $request->skills)->pluck('id')->toArray();
            $query->whereHas('skills', function($subquery) use ($ids) {
                $subquery->whereIn('skill_id', $ids);
            });
        }

        // Filter theo experience
        if ($request->has('experience') && $request->filled('experience')) {
            $query->where('experience_id', $request->experience);
        }

        $candidates = $query->paginate(24);

        return response()->json([
            'status' => true,
            'data' => [
                'candidates' => $candidates,
                'skills' => $skills,
                'experiences' => $experiences,
            ]
        ]);
    }

    /**
     * GET /api/candidates/{slug}
     * Trả chi tiết candidate
     */
    public function show(string $slug): JsonResponse
    {
        $candidate = Candidate::where([
            'profile_complete' => 1,
            'visibility' => 1,
            'slug' => $slug
        ])->firstOrFail();

        return response()->json([
            'status' => true,
            'data' => $candidate
        ]);
    }
}
