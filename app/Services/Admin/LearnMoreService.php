<?php

namespace App\Services\Admin;

use App\Models\LearnMore;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Log;
use Exception;

class LearnMoreService
{
    use FileUploadTrait;

    /**
     * Lấy thông tin Learn More section
     */
    public function getLearnMore(): ?LearnMore
    {
        return LearnMore::first();
    }

    /**
     * Cập nhật thông tin Learn More section
     */
    public function updateOrCreate(array $data): LearnMore
    {
        try {
            $formData = [
                'title' => $data['title'],
                'main_title' => $data['main_title'],
                'sub_title' => $data['sub_title'],
                'url' => $data['url'] ?? null,
            ];

            if (isset($data['image'])) {
                $formData['image'] = $this->uploadFileFromRequest($data['image'], 'uploads/learnmore');
            }

            return LearnMore::updateOrCreate(['id' => 1], $formData);
        } catch (Exception $e) {
            Log::error('LearnMore update failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Upload file (nếu bạn dùng trait FileUploadTrait)
     */
    private function uploadFileFromRequest($file, $path)
    {
        return $this->uploadFileDirect($file, $path);
    }
}
