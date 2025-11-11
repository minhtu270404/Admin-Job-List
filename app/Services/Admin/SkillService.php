<?php

namespace App\Services\Admin;

use App\Models\Skill;
use App\Models\JobSkills;
use App\Models\CandidateSkill;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class SkillService
{
    use Searchable;

    /**
     * Lấy danh sách kỹ năng với tìm kiếm
     */
    public function getAll(Request $request)
    {
        $query = Skill::query();
        $this->search($query, ['name']);
        return $query->paginate(20);
    }

    /**
     * Tìm kỹ năng theo ID
     */
    public function find(string $id): Skill
    {
        return Skill::findOrFail($id);
    }

    /**
     * Thêm mới kỹ năng
     */
    public function store(array $data): Skill
    {
        return Skill::create($data);
    }

    /**
     * Cập nhật kỹ năng
     */
    public function update(string $id, array $data): Skill
    {
        $skill = Skill::findOrFail($id);
        $skill->update($data);
        return $skill;
    }

    /**
     * Xóa kỹ năng
     * Ném exception nếu không xóa được
     */
    public function delete(string $id): void
    {
        $skillExist = JobSkills::where('skill_id', $id)->exists();
        $candidateSkillExist = CandidateSkill::where('skill_id', $id)->exists();

        if ($skillExist || $candidateSkillExist) {
            throw new Exception('Không thể xóa kỹ năng này vì đang được sử dụng trong hệ thống!');
        }

        try {
            Skill::findOrFail($id)->delete();
        } catch (Exception $e) {
            Log::error($e);
            throw new Exception('Đã xảy ra lỗi, vui lòng thử lại sau!');
        }
    }
}
