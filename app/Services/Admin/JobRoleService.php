<?php

namespace App\Services\Admin;

use App\Models\Job;
use App\Models\JobRole;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class JobRoleService
{
    /**
     * Base query để controller có thể áp dụng search/filter
     */
    public function baseQuery(): Builder
    {
        return JobRole::query();
    }

    /**
     * Lấy tất cả role (nếu cần)
     */
    public function getAll(): Collection
    {
        return JobRole::all();
    }

    /**
     * Tạo mới
     */
    public function create(array $data): JobRole
    {
        return JobRole::create([
            'name' => $data['name'],
        ]);
    }

    /**
     * Cập nhật
     */
    public function update(string $id, array $data): JobRole
    {
        $role = JobRole::findOrFail($id);
        $role->update([
            'name' => $data['name'],
        ]);

        return $role;
    }

    /**
     * Tìm 1 role
     */
    public function findOrFail(string $id): JobRole
    {
        return JobRole::findOrFail($id);
    }

    /**
     * Xóa role (có kiểm tra quan hệ với Job)
     */
    public function delete(string $id): bool
    {
        $jobExist = Job::where('job_role_id', $id)->exists();

        if ($jobExist) {
            throw new \RuntimeException("This item is already being used and can't be deleted!");
        }

        $role = JobRole::findOrFail($id);
        return $role->delete();
    }
}
