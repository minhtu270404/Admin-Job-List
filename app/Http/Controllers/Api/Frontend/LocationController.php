<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LocationController extends Controller
{
    /**
     * GET /api/locations/countries/{countryId}/states
     * Lấy danh sách state theo country
     */
    public function getStates(string $countryId): JsonResponse
    {
        $states = State::select(['id', 'name', 'country_id'])
            ->where('country_id', $countryId)
            ->get();

        return response()->json([
            'status' => true,
            'data' => $states
        ]);
    }

    /**
     * GET /api/locations/states/{stateId}/cities
     * Lấy danh sách city theo state
     */
    public function getCities(string $stateId): JsonResponse
    {
        $cities = City::select(['id', 'name', 'state_id', 'country_id'])
            ->where('state_id', $stateId)
            ->get();

        return response()->json([
            'status' => true,
            'data' => $cities
        ]);
    }
}
