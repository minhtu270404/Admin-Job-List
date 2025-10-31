<?php

namespace App\Services\Admin;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Throwable;

class SiteSettingService
{
    /**
     * Cập nhật các thiết lập chung của website
     */
    public function updateGeneral(array $settings): void
    {
        foreach ($settings as $key => $value) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        $this->clearCachedSettings();
    }

    /**
     * Cập nhật logo và favicon
     */
    public function updateLogo(?string $logoPath, ?string $faviconPath): void
    {
        if ($logoPath) {
            SiteSetting::updateOrCreate(['key' => 'site_logo'], ['value' => $logoPath]);
        }

        if ($faviconPath) {
            SiteSetting::updateOrCreate(['key' => 'site_favicon'], ['value' => $faviconPath]);
        }

        $this->clearCachedSettings();
    }

    /**
     * Xóa cache settings để cập nhật lại dữ liệu mới
     */
    public function clearCachedSettings(): void
    {
        Cache::forget('site_settings');
    }

    /**
     * Lấy tất cả setting từ cache (tối ưu performance)
     */
    public function getSettings(): array
    {
        return Cache::rememberForever('site_settings', function () {
            return SiteSetting::pluck('value', 'key')->toArray();
        });
    }
}
