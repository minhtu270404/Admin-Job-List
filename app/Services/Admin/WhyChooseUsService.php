<?php

namespace App\Services;

use App\Models\WhyChooseUs;
use Illuminate\Support\Facades\Log;
use Exception;

class WhyChooseUsService
{
    public function getFirst()
    {
        return WhyChooseUs::first();
    }

    public function updateOrCreate(array $data): WhyChooseUs
    {
        try {
            return WhyChooseUs::updateOrCreate(['id' => 1], $data);
        } catch (Exception $e) {
            Log::error('Cập nhật WhyChooseUs thất bại', ['error' => $e->getMessage()]);
            throw new Exception('Không thể cập nhật dữ liệu, vui lòng thử lại sau.');
        }
    }
}
