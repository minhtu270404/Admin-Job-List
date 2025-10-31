<?php

namespace App\Services\Admin;

use App\Models\Job;
use App\Models\JobType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class JobTypeService
{
    /**
     * Base query để controller có thể áp dụng search/filter
     */
    public function baseQuery(): Builder
    {
        return JobType::query();
    }

    /**
     * Lấy tất cả job type
     */
    public function getAll(): Collection
    {
        return JobType::all();
    }

    /**
     * Tạo mới job type
     */
    public function create(array $data): JobType
    {
        return JobType::create([
            'name' => $data['name'],
        ]);
    }

    /**
     * Cập nhật job type
     */
    public function update(string $id, array $data): JobType
    {
        $type = JobType::findOrFail($id);
        $type->update([
            'name' => $data['name'],
        ]);

        return $type;
    }

    /**
     * Tìm 1 job type
     */
    public function findOrFail(string $id): JobType
    {
        return JobType::findOrFail($id);
    }

    /**
     * Xóa job type (có kiểm tra quan hệ với Job)
     */
    public function delete(string $id): bool
    {
        $jobExist = Job::where('job_type_id', $id)->exists();

        if ($jobExist) {
            throw new \RuntimeException("Loại công việc này đã được sử dụng, không thể xóa!");
        }

        $type = JobType::findOrFail($id);
        return $type->delete();
    }
}
