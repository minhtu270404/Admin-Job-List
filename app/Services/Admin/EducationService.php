<?php

namespace App\Services\Admin;

use App\Models\Education;
use App\Models\Job;
use Illuminate\Support\Facades\Log;
use Exception;

class EducationService
{
    public function getAll($search = null)
    {
        $query = Education::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('id', 'DESC')->paginate(20);
    }

    public function create(array $data): Education
    {
        return Education::create([
            'name' => $data['name'],
        ]);
    }

    public function update(Education $education, array $data): Education
    {
        $education->update([
            'name' => $data['name'],
        ]);
        return $education;
    }

    public function delete(int $id): bool
    {
        $education = Education::findOrFail($id);

        // Kiểm tra xem education có đang được dùng trong Job không
        if (Job::where('education_id', $id)->exists()) {
            throw new Exception("Trình độ học vấn này đang được sử dụng, không thể xóa!");
        }

        $education->delete();
        return true;
    }
}
