<?php

namespace App\Services\Admin;

use App\Models\JobLocation;
use Illuminate\Support\Facades\Log;
use App\Traits\FileUploadTrait;
use Exception;

class JobLocationService
{
    use FileUploadTrait;

    /**
     * Lấy danh sách JobLocation (có phân trang)
     */
    public function getAllPaginated(int $perPage = 20)
    {
        return JobLocation::with('country')->paginate($perPage);
    }

    /**
     * Tạo mới JobLocation
     */
    public function create(array $data)
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
            throw $e;
        }
    }

    /**
     * Cập nhật JobLocation
     */
    public function update(int $id, array $data)
    {
        try {
            $location = JobLocation::findOrFail($id);
            $imagePath = $this->uploadFile(request(), 'image');

            if ($imagePath) {
                $location->image = $imagePath;
            }

            $location->country_id = $data['country'];
            $location->status = $data['status'];
            $location->save();

            return $location;
        } catch (Exception $e) {
            Log::error('JobLocationService@update: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Xoá JobLocation
     */
    public function delete(int $id)
    {
        try {
            $location = JobLocation::findOrFail($id);
            $location->delete();
            return true;
        } catch (Exception $e) {
            Log::error('JobLocationService@delete: ' . $e->getMessage());
            throw $e;
        }
    }
}
