<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Company;
use App\Models\Counter;
use App\Models\Country;
use App\Models\CustomPageBuilder;
use App\Models\Hero;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\JobLocation;
use App\Models\LearnMore;
use App\Models\Plan;
use App\Models\Review;
use App\Models\WhyChooseUs;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    /**
     * GET /api/home
     * Return homepage data
     */
    public function index(): JsonResponse
    {
        $today = date('Y-m-d');

        $hero = Hero::first();
        $countries = Country::all();
        $jobCategories = JobCategory::all();

        $popularJobCategories = JobCategory::withCount([
            'jobs' => function ($query) use ($today) {
                $query->where('status', 'active')
                    ->where('deadline', '>=', $today);
            }
        ])->where('show_at_popular', 1)->get();

        $featuredCategories = JobCategory::where('show_at_featured', 1)
            ->take(10)
            ->get();

        $jobCount = Job::count();

        $whyChooseUs = WhyChooseUs::first();
        $learnMore = LearnMore::first();
        $counter = Counter::first();

        $companies = Company::with(['country:id,name', 'jobs:id,company_id,status,deadline'])
            ->withCount([
                'jobs' => function ($query) use ($today) {
                    $query->where('status', 'active')
                        ->where('deadline', '>=', $today);
                }
            ])
            ->select('id', 'logo', 'name', 'slug', 'country', 'profile_completion', 'visibility')
            ->where('profile_completion', 1)
            ->where('visibility', 1)
            ->latest()
            ->take(45)
            ->get();

        $locations = JobLocation::latest()->take(8)->get();
        $reviews = Review::latest()->take(10)->get();

        $plans = Plan::where('frontend_show', 1)
            ->where('show_at_home', 1)
            ->get();

        $blogs = Blog::latest()->take(6)->get();

        return response()->json([
            'status' => true,
            'data' => [
                'hero' => $hero,
                'countries' => $countries,
                'job_categories' => $jobCategories,
                'popular_categories' => $popularJobCategories,
                'featured_categories' => $featuredCategories,
                'job_count' => $jobCount,
                'why_choose_us' => $whyChooseUs,
                'learn_more' => $learnMore,
                'counter' => $counter,
                'companies' => $companies,
                'locations' => $locations,
                'reviews' => $reviews,
                'plans' => $plans,
                'blogs' => $blogs,
            ]
        ]);
    }

    /**
     * GET /api/page/{slug}
     * Return custom page data
     */
    public function customPage(string $slug): JsonResponse
    {
        $page = CustomPageBuilder::where('slug', $slug)->firstOrFail();

        return response()->json([
            'status' => true,
            'data' => $page
        ]);
    }
}
