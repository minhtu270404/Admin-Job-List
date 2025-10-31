<?php

namespace App\Services\Admin;

use App\Models\Tag;
use Illuminate\Support\Facades\Log;
use Exception;

class TagService
{
    public function getAll($search = null, $perPage = 20)
    {
        $query = Tag::query();

        if ($search) {
            $query->where('name', 'like', "%$search%")
                  ->orWhere('slug', 'like', "%$search%");
        }

        return $query->paginate($perPage);
    }

    public function create(array $data): Tag
    {
        return Tag::create([
            'name' => $data['name'],
        ]);
    }

    public function update(Tag $tag, array $data): Tag
    {
        $tag->update([
            'name' => $data['name'],
        ]);

        return $tag;
    }

    public function delete(Tag $tag): bool
    {
        try {
            return $tag->delete();
        } catch (Exception $e) {
            Log::error('Xóa tag thất bại', ['error' => $e->getMessage()]);
            throw new Exception('Không thể xóa tag. Vui lòng thử lại sau.');
        }
    }
}
