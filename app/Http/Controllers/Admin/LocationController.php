<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:job locations']);
    }

    /** AJAX: Lấy danh sách tỉnh theo quốc gia */
    public function getStatesOfCountry($country_id)
    {
        $states = \App\Models\State::where('country_id', $country_id)->get(['id', 'name']);
        return response()->json($states);
    }
    /**
     * Lấy danh sách city theo state_id
     */
    public function getCitiesOfState($state_id)
    {
        try {
            $cities = \App\Models\City::where('state_id', $state_id)->get(['id', 'name']);
            return response()->json($cities);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
