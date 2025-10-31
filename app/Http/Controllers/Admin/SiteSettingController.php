<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GeneralSettingUpdateRequest;
use App\Services\Notify;
use App\Services\Admin\SiteSettingService;
use App\Traits\FileUploadTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class SiteSettingController extends Controller
{
    use FileUploadTrait;

    protected SiteSettingService $siteSettingService;

    public function __construct(SiteSettingService $siteSettingService)
    {
        $this->middleware(['permission:site settings']);
        $this->siteSettingService = $siteSettingService;
    }

    /**
     * Hiển thị trang cài đặt
     */
    public function index(): View
    {
        $settings = $this->siteSettingService->getSettings();
        return view('admin.site-setting.index', compact('settings'));
    }

    /**
     * Cập nhật thông tin chung
     */
    public function updateGeneralSetting(GeneralSettingUpdateRequest $request): RedirectResponse
    {
        try {
            $this->siteSettingService->updateGeneral($request->validated());
            Notify::updatedNotification('Cập nhật thông tin chung thành công.');
        } catch (Throwable $e) {
            logger($e);
            Notify::errorNotification('Đã xảy ra lỗi khi cập nhật. Vui lòng thử lại.');
        }

        return back();
    }

    /**
     * Cập nhật logo và favicon
     */
    public function updateLogoSetting(): RedirectResponse
    {
        request()->validate([
            'logo' => ['nullable', 'image', 'max:2000'],
            'favicon' => ['nullable', 'image', 'max:2000'],
        ], [
            'logo.image' => 'Tệp logo phải là hình ảnh hợp lệ.',
            'logo.max' => 'Dung lượng logo không được vượt quá 2MB.',
            'favicon.image' => 'Tệp favicon phải là hình ảnh hợp lệ.',
            'favicon.max' => 'Dung lượng favicon không được vượt quá 2MB.',
        ]);

        try {
            $logoPath = $this->uploadFile(request(), 'logo');
            $faviconPath = $this->uploadFile(request(), 'favicon');

            $this->siteSettingService->updateLogo($logoPath, $faviconPath);
            Notify::updatedNotification('Cập nhật logo và favicon thành công');
        } catch (Throwable $e) {
            logger($e);
            Notify::errorNotification('Đã xảy ra lỗi khi cập nhật hình ảnh. Vui lòng thử lại.');
        }

        return back();
    }
}
