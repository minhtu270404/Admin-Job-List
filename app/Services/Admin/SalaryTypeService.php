<?php

namespace App\Services\Admin;

use App\Models\Job;
use App\Models\SalaryType;
use Illuminate\Support\Facades\Log;
use Throwable;

class SalaryTypeService
{
    /**
     * Tạo mới loại lương
     */
    public function create(array $data): SalaryType
    {
        return SalaryType::create([
            'name' => $data['name'],
        ]);
    }

    /**
     * Cập nhật loại lương
     */
    public function update(string $id, array $data): SalaryType
    {
        $type = SalaryType::findOrFail($id);
        $type->update([
            'name' => $data['name'],
        ]);

        return $type;
    }

    /**
     * Xóa loại lương (kiểm tra ràng buộc với Job)
     */
    public function delete(string $id): bool
    {
        if (Job::where('salary_type_id', $id)->exists()) {
            abort(400, 'Loại lương này đang được sử dụng trong công việc, không thể xóa!');
        }

        try {
            $type = SalaryType::findOrFail($id);
            $type->delete();
            return true;
        } catch (Throwable $e) {
            Log::error('Xóa loại lương thất bại: ' . $e->getMessage());
            abort(500, 'Đã xảy ra lỗi, vui lòng thử lại sau.');
        }
    }
}
