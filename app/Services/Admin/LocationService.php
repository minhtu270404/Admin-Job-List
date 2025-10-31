<?php

namespace App\Services\Admin;

use App\Models\State;
use Illuminate\Support\Collection;

class LocationService
{
    /**
     * Lấy danh sách state theo country_id
     */
    public function getStatesByCountry(string $countryId): Collection
    {
        return State::select(['id', 'name', 'country_id'])
            ->where('country_id', $countryId)
            ->orderBy('name')
            ->get();
    }
}
