<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GetStatesRequest;
use App\Services\Admin\LocationService;
use Illuminate\Http\JsonResponse;

class LocationController extends Controller
{
    protected LocationService $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->middleware(['permission:sections']);
        $this->locationService = $locationService;
    }

    /**
     * Lấy danh sách state theo country_id
     */
    public function getStatesOfCountry(GetStatesRequest $request): JsonResponse
    {
        $states = $this->locationService->getStatesByCountry($request->country_id);

        return response()->json([
            'success' => true,
            'message' => 'Lấy danh sách tiểu bang thành công.',
            'data' => $states,
        ]);
    }
}
