<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Blog;
use App\Models\Review;
use Illuminate\Http\JsonResponse;

class AboutUsPageController extends Controller
{
    /**
     * GET /api/about-us
     * Return About Us page data
     */
    public function index(): JsonResponse
    {
        $about = About::first();
        $reviews = Review::latest()->take(10)->get();
        $blogs = Blog::latest()->take(6)->get();

        return response()->json([
            'status' => true,
            'data' => [
                'about'   => $about,
                'reviews' => $reviews,
                'blogs'   => $blogs,
            ]
        ]);
    }
}
