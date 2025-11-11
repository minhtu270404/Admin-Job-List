<?php

namespace App\Services\Admin;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Services\Notify;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CityService
{
    public function getAllCities(Request $request)
    {
        $query = City::with(['country', 'state']);

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        return $query->orderByDesc('id')->paginate(20);
    }

    public function getAllCountries()
    {
        return Country::all();
    }

    public function getCityEditData(string $id): array
    {
        $city = City::findOrFail($id);
        $countries = Country::all();
        $states = State::where('country_id', $city->country_id)->get();

        return [$city, $countries, $states];
    }

    public function createCity(array $data): void
    {
        City::create([
            'name' => $data['name'],
            'state_id' => $data['state_id'],
            'country_id' => $data['country_id'],
        ]);

        Notify::createdNotification('Thêm mới thành công');
    }

    public function updateCity(array $data, string $id): void
    {
        $city = City::findOrFail($id);
        $city->update([
            'name' => $data['name'],
            'state_id' => $data['state_id'],
            'country_id' => $data['country_id'],
        ]);

        Notify::updatedNotification('Cập nhật thành công');
    }

    public function deleteCity(string $id): JsonResponse
    {
        try {
            City::findOrFail($id)->delete();
            Notify::deletedNotification('Xóa thành công');

            return response()->json(['message' => 'Xóa thành công!'], 200);
        } catch (\Exception $e) {
            Log::error('City delete failed: ' . $e->getMessage());

            return response()->json(['message' => 'Đã xảy ra lỗi, vui lòng thử lại!'], 500);
        }
    }
}
