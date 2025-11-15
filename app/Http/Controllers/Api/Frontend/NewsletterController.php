<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Subscribers;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class NewsletterController extends Controller
{
    /**
     * POST /api/newsletter/subscribe
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'unique:subscribers,email']
        ]);

        $subscriber = Subscribers::create([
            'email' => $request->email
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Subscribed successfully.',
            'data' => $subscriber
        ], 201);
    }
}
