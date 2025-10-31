<?php

namespace App\Services\Admin;

use App\Models\CustomPageBuilder;
use App\Services\Notify;
use App\Traits\Searchable;
use Illuminate\Http\Request;

class CustomPageBuilderService
{
    use Searchable;

    public function getAllWithSearch(Request $request, array $columns)
    {
        $query = CustomPageBuilder::query();
        $this->search($query, $columns);

        return $query->orderByDesc('id')->paginate(20);
    }

    public function create(array $data): CustomPageBuilder
    {
        $page = CustomPageBuilder::create($data);
        Notify::createdNotification('Thêm Mới Thành Công');

        return $page;
    }

    public function find(string $id): CustomPageBuilder
    {
        return CustomPageBuilder::findOrFail($id);
    }

    public function update(string $id, array $data): CustomPageBuilder
    {
        $page = $this->find($id);
        $page->update($data);

        Notify::updatedNotification('Cập Nhật Thành Công');

        return $page;
    }

    public function delete(string $id): bool
    {
        $page = $this->find($id);
        $deleted = $page->delete();

        if ($deleted) {
 Notify::deletedNotification('Xóa Thành Công');        }

        return $deleted;
    }
}
