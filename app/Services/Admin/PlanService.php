<?php

namespace App\Services\Admin;

use App\Models\Plan;
use App\Services\Notify;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Exception;

class PlanService
{
    /**
     * Lấy toàn bộ danh sách plan
     */
    public function getAll()
    {
        return Plan::orderBy('id', 'DESC')->get();
    }

    /**
     * Tạo mới plan
     */
    public function create(array $data): Plan
    {
        $plan = Plan::create($data);
        Notify::createdNotification('Thêm Mới Thành Công');
        return $plan;
    }

    /**
     * Tìm theo ID
     */
    public function findById(string $id): Plan
    {
        return Plan::findOrFail($id);
    }

    /**
     * Cập nhật plan
     */
    public function update(string $id, array $data): bool
    {
        $plan = Plan::findOrFail($id);
        $plan->update($data);
        Notify::updatedNotification('Cập Nhật Thành Công');
        return true;
    }

    /**
     * Xóa plan
     */
    public function delete(string $id): Response
    {
        try {
            Plan::findOrFail($id)->delete();
 Notify::deletedNotification('Xóa Thành Công');            return response(['message' => 'success'], 200);
        } catch (Exception $e) {
            Log::error('Plan delete failed', [
                'plan_id' => $id,
                'error' => $e->getMessage()
            ]);
            return response(['message' => 'Something Went Wrong. Please Try Again!'], 500);
        }
    }
}
