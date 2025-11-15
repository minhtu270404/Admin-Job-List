<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Order;
use App\Models\UserPlan;
use Illuminate\Http\JsonResponse;

class CompanyDashboardController extends Controller
{
    /**
     * GET /api/company/dashboard
     * Return company dashboard summary
     */
    public function index(): JsonResponse
    {
        $companyId = auth()->user()->company?->id;

        if (!$companyId) {
            return response()->json([
                'status' => false,
                'message' => 'Company not found for this user'
            ], 404);
        }

        $jobPosts = Job::where('company_id', $companyId)
            ->where('status', 'pending')
            ->count();

        $totalJobs = Job::where('company_id', $companyId)->count();

        $totalOrders = Order::where('company_id', $companyId)->count();

        $userPlan = UserPlan::where('company_id', $companyId)->first();

        return response()->json([
            'status' => true,
            'data' => [
                'pending_jobs' => $jobPosts,
                'total_jobs' => $totalJobs,
                'total_orders' => $totalOrders,
                'user_plan' => $userPlan
            ],
            'message' => 'Company dashboard retrieved successfully'
        ]);
    }
}
