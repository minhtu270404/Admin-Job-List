<?php

namespace App\Services\Admin;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Services\Notify;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CityService
{
    use Searchable;

    /**
     * Lấy danh sách thành phố có tìm kiếm và phân trang
     */
    public function getAllCities(Request $request)
    {
        $query = City::with(['country', 'state']);
        $this->search($query, ['name']);

        return $query->orderByDesc('id')->paginate(20);
    }

    /**
     * Lấy tất cả quốc gia
     */
    public function getAllCountries()
    {
        return Country::all();
    }

    /**
     * Lấy dữ liệu khi edit thành phố
     */
    public function getCityEditData(string $id): array
    {
        $city = City::findOrFail($id);
        $countries = Country::all();
        $states = State::where('country_id', $city->country_id)->get();

        return [$city, $countries, $states];
    }

    /**
     * Tạo mới thành phố
     */
    public function createCity(Request $request): void
    {
        City::create([
            'name' => $request->city,
            'state_id' => $request->state,
            'country_id' => $request->country,
        ]);

        Notify::createdNotification('Thêm Mới Thành Công');
    }

    /**
     * Cập nhật thành phố
     */
    public function updateCity(Request $request, string $id): void
    {
        $city = City::findOrFail($id);

        $city->update([
            'name' => $request->city,
            'state_id' => $request->state,
            'country_id' => $request->country,
        ]);

        Notify::updatedNotification('Cập Nhật Thành Công');
    }

    /**
     * Xóa thành phố
     */
    public function deleteCity(string $id): Response
    {
        try {
            City::findOrFail($id)->delete();
 Notify::deletedNotification('Xóa Thành Công');
            return response(['message' => 'success'], 200);
        } catch (\Exception $e) {
            Log::error('City delete failed: ' . $e->getMessage());
            return response(['message' => 'Đã xảy ra lỗi, vui lòng thử lại!'], 500);
        }
    }
}
