<?php

namespace App\Services\Admin;

use App\Models\JobLocation;
use App\Traits\FileUploadTrait;
use Exception;
use Illuminate\Support\Facades\Log;

class JobLocationService
{
    use FileUploadTrait;

    /**
     * Lấy danh sách JobLocation có phân trang
     */
    public function getAllPaginated(int $perPage = 20)
    {
        return JobLocation::with(['country:id,name'])
            ->orderByDesc('id')
            ->paginate($perPage);
    }

    /**
     * Tìm JobLocation theo ID
     */
    public function findOrFail(int $id): JobLocation
    {
        return JobLocation::with('country:id,name')->findOrFail($id);
    }

    /**
     * Tạo mới JobLocation
     */
    public function create(array $data): JobLocation
    {
        try {
            $imagePath = $this->uploadFile(request(), 'image');

            return JobLocation::create([
                'country_id' => $data['country'],
                'status'     => $data['status'],
                'image'      => $imagePath,
            ]);
        } catch (Exception $e) {
            Log::error('JobLocationService@create: ' . $e->getMessage());
            throw new Exception('Không thể tạo mới địa điểm làm việc');
        }
    }

    /**
     * Cập nhật JobLocation
     */
    public function update(int $id, array $data): JobLocation
    {
        try {
            $location = JobLocation::findOrFail($id);

            if ($newImage = $this->uploadFile(request(), 'image')) {
                $location->image = $newImage;
            }

            $location->country_id = $data['country'];
            $location->status     = $data['status'];
            $location->save();

            return $location;
        } catch (Exception $e) {
            Log::error('JobLocationService@update: ' . $e->getMessage());
            throw new Exception('Không thể cập nhật địa điểm làm việc');
        }
    }

    /**
     * Xóa JobLocation
     */
    public function delete(int $id): bool
    {
        try {
            $location = JobLocation::findOrFail($id);
            $location->delete();
            return true;
        } catch (Exception $e) {
            Log::error('JobLocationService@delete: ' . $e->getMessage());
            throw new Exception('Không thể xóa địa điểm làm việc');
        }
    }
}
