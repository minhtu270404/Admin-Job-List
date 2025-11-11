<?php

namespace App\Services\Admin;

use App\Models\LearnMore;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;

class LearnMoreService
{
    /**
     * Lấy thông tin Learn More
     */
    public function getLearnMore(): ?LearnMore
    {
        return LearnMore::first();
    }

    /**
     * Cập nhật hoặc tạo Learn More
     */
    public function updateOrCreate(array $data): LearnMore
    {
        try {
            $formData = [
                'title' => $data['title'] ?? null,
                'main_title' => $data['main_title'] ?? null,
                'sub_title' => $data['sub_title'] ?? null,
                'url' => $data['url'] ?? null,
            ];

            if (!empty($data['image'])) {
                $formData['image'] = $this->uploadFile($data['image'], 'uploads/learnmore');
            }

            return LearnMore::updateOrCreate(['id' => 1], $formData);
        } catch (Exception $e) {
            Log::error('LearnMore update failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Upload file lên storage/public và trả về path
     */
    private function uploadFile($file, string $folder): string
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs($folder, $filename, 'public'); // storage/app/public/{folder}
        return $path;
    }
}
