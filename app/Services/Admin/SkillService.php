<?php

namespace App\Services\Admin;

use App\Models\Skill;
use App\Models\JobSkills;
use App\Models\CandidateSkill;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use Exception;

class SkillService
{
    use Searchable;

    public function getAll(Request $request)
    {
        $query = Skill::query();
        $this->search($query, ['name']);
        return $query->paginate(20);
    }

    public function find(string $id): Skill
    {
        return Skill::findOrFail($id);
    }

    public function store(array $data): Skill
    {
        return Skill::create($data);
    }

    public function update(string $id, array $data): Skill
    {
        $skill = Skill::findOrFail($id);
        $skill->update($data);
        return $skill;
    }

    public function delete(string $id): Response
    {
        $skillExist = JobSkills::where('skill_id', $id)->exists();
        $candidateSkillExist = CandidateSkill::where('skill_id', $id)->exists();

        if ($skillExist || $candidateSkillExist) {
            return response([
                'message' => 'Không thể xóa kỹ năng này vì đang được sử dụng trong hệ thống!'
            ], 500);
        }

        try {
            Skill::findOrFail($id)->delete();
 Notify::deletedNotification('Xóa Thành Công');            return response(['message' => 'Xóa thành công!'], 200);
        } catch (Exception $e) {
            Log::error($e);
            return response(['message' => 'Đã xảy ra lỗi, vui lòng thử lại sau!'], 500);
        }
    }
}
