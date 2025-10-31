<?php

namespace App\Services\Admin;
use App\Models\Footer;
use App\Traits\FileUploadTrait;
use Exception;
use Illuminate\Support\Facades\Log;

class FooterService
{
    use FileUploadTrait;

    /**
     * Lấy dữ liệu footer (chỉ có 1 record)
     */
    public function getFooter(): ?Footer
    {
        return Footer::first();
    }

    /**
     * Cập nhật hoặc tạo footer
     */
    public function update(array $data)
    {
        try {
            $imagePath = $this->uploadFile(request(), 'logo');
            if ($imagePath) {
                $data['logo'] = $imagePath;
            }

            return Footer::updateOrCreate(['id' => 1], $data);
        } catch (Exception $e) {
            Log::error('Footer update failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
