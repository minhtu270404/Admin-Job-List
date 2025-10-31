<?php

namespace App\Services\Admin;

use App\Models\Language;
use App\Models\CandidateLanguage;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class LanguageService
{
    public function getAllPaginated($perPage = 20, $search = null)
    {
        $query = Language::query();

        if (!empty($search)) {
            $query->where('name', 'like', "%$search%");
        }

        return $query->paginate($perPage);
    }

    public function create(array $data): Language
    {
        return Language::create([
            'name' => $data['name'],
        ]);
    }

    public function update(int $id, array $data): Language
    {
        $language = Language::findOrFail($id);
        $language->update([
            'name' => $data['name'],
        ]);
        return $language;
    }

    public function delete(int $id): bool
    {
        if (CandidateLanguage::where('language_id', $id)->exists()) {
            throw new Exception("This item is already been used can't delete!");
        }

        $language = Language::findOrFail($id);
        return $language->delete();
    }
}
