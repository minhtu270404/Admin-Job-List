<?php

namespace App\Services\Admin;

use App\Models\State;
use App\Models\City;
use App\Models\Country;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Http\Response;

class StateService
{
    public function getAll()
    {
        return State::with('country')->orderByDesc('id')->paginate(20);
    }

    public function getCountries()
    {
        return Country::all();
    }

    public function store(array $data): State
    {
        return State::create([
            'name' => $data['name'],
            'country_id' => $data['country_id'],
        ]);
    }

    public function edit(string $id): array
    {
        $state = State::findOrFail($id);
        $countries = $this->getCountries();
        return ['state' => $state, 'countries' => $countries];
    }

    public function update(string $id, array $data): State
    {
        $state = State::findOrFail($id);
        $state->update([
            'name' => $data['name'],
            'country_id' => $data['country_id'],
        ]);
        return $state;
    }

    public function delete(string $id): Response
    {
        if (City::where('state_id', $id)->exists()) {
            return response(['message' => 'Tỉnh / bang này đã được sử dụng, không thể xóa!'], 422);
        }

        try {
            State::findOrFail($id)->delete();
            return response(['message' => 'Xóa thành công!'], 200);
        } catch (Exception $e) {
            Log::error($e);
            return response(['message' => 'Đã xảy ra lỗi, vui lòng thử lại sau!'], 500);
        }
    }
}
