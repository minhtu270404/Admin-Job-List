<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PricingPageController extends Controller
{
    /**
     * GET /api/plans
     */
    public function index(Request $request): JsonResponse
    {
        // Chặn candidate truy cập
        if (auth()->user()?->role === 'candidate') {
            return response()->json([
                'status' => false,
                'message' => 'Not found'
            ], 404);
        }

        $plans = Plan::where('frontend_show', 1)->get();

        return response()->json([
            'status' => true,
            'message' => 'Plans retrieved successfully',
            'data' => $plans
        ]);
    }
}
