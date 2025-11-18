<?php

use Illuminate\Support\Facades\Route;

// ------------------------ FRONTEND CONTROLLERS ------------------------
use App\Http\Controllers\Api\Frontend\HomeController;
use App\Http\Controllers\Api\Frontend\AboutUsPageController;
use App\Http\Controllers\Api\Frontend\CandidateDashboardController;
use App\Http\Controllers\Api\Frontend\CandidateMyJobController;
use App\Http\Controllers\Api\Frontend\CandidateEducationController;
use App\Http\Controllers\Api\Frontend\CandidateExperienceController;
use App\Http\Controllers\Api\Frontend\CompanyProfileController;
use App\Http\Controllers\Api\Frontend\FrontendBlogPageController;
use App\Http\Controllers\Api\Frontend\FrontendCandidatePageController;
use App\Http\Controllers\Api\Frontend\FrontendCompanyPageController;
use App\Http\Controllers\Api\Frontend\FrontendJobPageController;
use App\Http\Controllers\Api\Frontend\LocationController;
use App\Http\Controllers\Api\Frontend\NewsletterController;
use App\Http\Controllers\Api\Frontend\PricingPageController;
use App\Http\Controllers\Api\Frontend\ContactController;
use App\Http\Controllers\Api\Frontend\jobController;

/*
|--------------------------------------------------------------------------
| API ROUTES
|--------------------------------------------------------------------------
|
| Tất cả route frontend API
|
*/

// ------------------------ HOME / STATIC PAGES ------------------------
Route::controller(HomeController::class)->group(function () {
    Route::get('/home', 'index');
    Route::get('/page/{slug}', 'customPage');
});

Route::get('/about-us', [AboutUsPageController::class, 'index']);

// ------------------------ BLOG ------------------------
Route::get('/blogs', [FrontendBlogPageController::class, 'index']);
Route::get('/blogs/{slug}', [FrontendBlogPageController::class, 'show']);

// ------------------------ CANDIDATE ------------------------
Route::get('/candidates', [FrontendCandidatePageController::class, 'index']);
Route::get('/candidates/{slug}', [FrontendCandidatePageController::class, 'show']);

Route::middleware('auth:sanctum')->prefix('candidate')->group(function () {
    Route::get('/dashboard', [CandidateDashboardController::class, 'index']);
    Route::get('/my-jobs', [CandidateMyJobController::class, 'index']);

    // Education CRUD
    Route::apiResource('educations', CandidateEducationController::class);

    // Experience CRUD
    Route::apiResource('experiences', CandidateExperienceController::class);
});

// ------------------------ COMPANY PROFILE ------------------------
Route::middleware('auth:sanctum')->prefix('company')->group(function () {
    Route::get('/profile', [CompanyProfileController::class, 'index']);
    Route::post('/profile/update-info', [CompanyProfileController::class, 'updateCompanyInfo']);
    Route::post('/profile/update-founding', [CompanyProfileController::class, 'updateFoundingInfo']);
    Route::post('/profile/update-account', [CompanyProfileController::class, 'updateAccountInfo']);
    Route::post('/profile/update-password', [CompanyProfileController::class, 'updatePassword']);

    // Company jobs management
    Route::get('/jobs', [jobController::class, 'index']);
    Route::post('/jobs', [jobController::class, 'store']);
    Route::put('/jobs/{id}', [jobController::class, 'update']);
    Route::delete('/jobs/{id}', [jobController::class, 'destroy']);
    Route::get('/jobs/{id}/applications', [jobController::class, 'applications']);
});

// ------------------------ COMPANY / FRONTEND PAGES ------------------------
Route::get('/companies', [FrontendCompanyPageController::class, 'index']);
Route::get('/companies/{slug}', [FrontendCompanyPageController::class, 'show']);

// ------------------------ JOBS ------------------------
Route::get('/jobs', [FrontendJobPageController::class, 'index']);
Route::get('/jobs/{slug}', [FrontendJobPageController::class, 'show']);
Route::middleware('auth:sanctum')->post('/jobs/{id}/apply', [FrontendJobPageController::class, 'apply']);

// ------------------------ LOCATIONS ------------------------
Route::get('/locations/countries/{countryId}/states', [LocationController::class, 'getStates']);
Route::get('/locations/states/{stateId}/cities', [LocationController::class, 'getCities']);

// ------------------------ NEWSLETTER ------------------------
Route::post('/newsletter/subscribe', [NewsletterController::class, 'store']);

// ------------------------ PRICING / PLANS ------------------------
Route::get('/plans', [PricingPageController::class, 'index']);

// ------------------------ CONTACT ------------------------
Route::get('/contact', [ContactController::class, 'index']);
Route::post('/contact/send', [ContactController::class, 'sendMail']);
