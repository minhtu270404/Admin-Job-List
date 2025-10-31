<?php

namespace App\Services\Admin;
use App\Models\Hero;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Log;
use Exception;

class HeroService
{
    use FileUploadTrait;

    /**
     * Lấy dữ liệu hero (chỉ có 1 record)
     */
    public function getHero(): ?Hero
    {
        return Hero::first();
    }

    /**
     * Cập nhật hoặc tạo Hero Section
     */
    public function update(array $data)
    {
        try {
            $request = request();

            // upload ảnh nếu có
            if ($imagePath = $this->uploadFile($request, 'image')) {
                $data['image'] = $imagePath;
            }

            if ($bgPath = $this->uploadFile($request, 'background_image')) {
                $data['background_image'] = $bgPath;
            }

            return Hero::updateOrCreate(['id' => 1], $data);
        } catch (Exception $e) {
            Log::error('Hero update failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
