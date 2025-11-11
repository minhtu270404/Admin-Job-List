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
    public function getStatesOfCountry($country_id)
{
    try {
        $states = \App\Models\State::where('country_id', $country_id)->get();
        return response()->json($states);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}
