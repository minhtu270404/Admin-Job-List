<?php

namespace App\Services\Admin;

use App\Models\Company;
use App\Models\OrganizationType;
use App\Services\Notify;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Exception;

class OrganizationTypeService
{
    /**
     * Lấy danh sách có phân trang và tìm kiếm
     */
    public function getPaginatedList(Request $request)
    {
        $query = OrganizationType::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        return $query->orderByDesc('id')->paginate(20);
    }

    /**
     * Tạo mới loại hình tổ chức
     */
    public function create(array $data): OrganizationType
    {
        $type = OrganizationType::create($data);
        Notify::createdNotification('Thành công');
        return $type;
    }

    /**
     * Lấy thông tin chi tiết
     */
    public function findById(string $id): OrganizationType
    {
        return OrganizationType::findOrFail($id);
    }

    /**
     * Cập nhật loại hình tổ chức
     */
    public function update(string $id, array $data): bool
    {
        $type = OrganizationType::findOrFail($id);
        $type->update($data);
        Notify::updatedNotification('Cập Nhật Thành Công');
        return true;
    }

    /**
     * Xóa loại hình tổ chức
     */
    public function delete(string $id): Response
    {
        if (Company::where('organization_type_id', $id)->exists()) {
            return response(['message' => "This item is already used and can't be deleted!"], 500);
        }

        try {
            OrganizationType::findOrFail($id)->delete();
 Notify::deletedNotification('Xóa Thành Công');            return response(['message' => 'success'], 200);
        } catch (Exception $e) {
            Log::error('Delete organization type failed', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);
            return response(['message' => 'Something went wrong. Please try again!'], 500);
        }
    }
}
