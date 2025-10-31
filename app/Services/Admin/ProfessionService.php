<?php

namespace App\Services\Admin;

use App\Models\Candidate;
use App\Models\Profession;
use App\Traits\Searchable;
use App\Services\Notify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProfessionService
{
    use Searchable;

    public function queryWithSearch(Request $request, array $columns)
    {
        $query = Profession::query();
        $this->search($query, $columns);
        return $query;
    }

    public function find(string $id): Profession
    {
        return Profession::findOrFail($id);
    }

    public function create(array $data): Profession
    {
        $profession = Profession::create($data);
        Notify::createdNotification('Thêm Mới Thành Công');
        return $profession;
    }

    public function update(string $id, array $data): Profession
    {
        $profession = $this->find($id);
        $profession->update($data);
        Notify::updatedNotification('Cập Nhật Thành Công');
        return $profession;
    }

    public function delete(string $id)
    {
        if (Candidate::where('profession_id', $id)->exists()) {
            return response(['message' => 'This item is already been used, can\'t delete!'], 500);
        }

        try {
            $this->find($id)->delete();
 Notify::deletedNotification('Xóa Thành Công');            return response(['message' => 'success'], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['profession_id' => $id]);
            return response(['message' => 'Something went wrong, please try again!'], 500);
        }
    }
}
