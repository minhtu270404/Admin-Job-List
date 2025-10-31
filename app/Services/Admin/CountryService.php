<?php

namespace App\Services\Admin;

use App\Models\Country;
use App\Models\State;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Throwable;

class CountryService
{
    /**
     * Lấy danh sách quốc gia (phân trang + tìm kiếm).
     */
    public function getPaginatedCountries(): LengthAwarePaginator
    {
        return Country::query()
            ->orderByDesc('id')
            ->paginate(20);
    }

    /**
     * Tạo mới quốc gia.
     */
    public function createCountry(array $data): Country
    {
        return Country::create([
            'name' => $data['name'],
        ]);
    }

    /**
     * Tìm quốc gia theo ID.
     */
    public function findCountryById(string $id): Country
    {
        return Country::findOrFail($id);
    }

    /**
     * Cập nhật quốc gia.
     */
    public function updateCountry(string $id, array $data): void
    {
        DB::transaction(function () use ($id, $data) {
            $country = Country::findOrFail($id);
            $country->update(['name' => $data['name']]);
        });
    }

    /**
     * Xoá quốc gia (nếu chưa có state liên kết).
     * Trả về false nếu không thể xoá.
     */
    public function deleteCountry(string $id): bool
    {
        if (State::where('country_id', $id)->exists()) {
            return false;
        }

        return (bool) Country::findOrFail($id)->delete();
    }
}
