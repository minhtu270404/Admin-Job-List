<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;

class CheckoutPageController extends Controller
{
    /**
     * GET /api/checkout/{id}
     * Return plan data for checkout
     */
    public function __invoke(Request $request, string $id): JsonResponse
    {
        $plan = Plan::findOrFail($id);

        // Optionally store in session for later use
        Session::put('selected_plan', $plan->toArray());

        return response()->json([
            'status' => true,
            'data' => $plan,
            'message' => 'Plan retrieved successfully'
        ]);
    }
}
