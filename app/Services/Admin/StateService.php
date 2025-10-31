<?php

namespace App\Services\Admin;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Exception;

class StateService
{
    public function getAll()
    {
        return State::with('country')
            ->orderByDesc('id')
            ->paginate(20);
    }

    public function getCountries()
    {
        return Country::all();
    }

    public function store(array $data): State
    {
        return State::create([
            'name' => $data['name'],
            'country_id' => $data['country'],
        ]);
    }

    public function edit(string $id): array
    {
        $countries = Country::all();
        $state = State::findOrFail($id);
        return [$countries, $state];
    }

    public function update(string $id, array $data): State
    {
        $state = State::findOrFail($id);
        $state->update([
            'name' => $data['name'],
            'country_id' => $data['country'],
        ]);

        return $state;
    }

    public function delete(string $id): Response
    {
        if (City::where('state_id', $id)->exists()) {
            return response(['message' => 'Tỉnh/thành này đã được sử dụng, không thể xóa!'], 500);
        }

        try {
            State::findOrFail($id)->delete();
 Notify::deletedNotification('Xóa Thành Công');            return response(['message' => 'Xóa thành công!'], 200);
        } catch (Exception $e) {
            Log::error($e);
            return response(['message' => 'Đã xảy ra lỗi, vui lòng thử lại sau!'], 500);
        }
    }
}
