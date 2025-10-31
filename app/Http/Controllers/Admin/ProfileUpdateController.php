<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminPasswordRequest;
use App\Http\Requests\Admin\AdminProfileRequest;
use App\Services\Admin\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProfileUpdateController extends Controller
{
    public function __construct(
        protected ProfileService $profileService
    ) {

    }

    /**
     * Đăng xuất tài khoản admin.
     */
    public function logout(Request $request)
    {
        $guard = Auth::getDefaultDriver();

        Auth::guard($guard)->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', __('Bạn đã đăng xuất thành công.'));
    }

    /**
     * Hiển thị trang thông tin cá nhân.
     */
    public function showProfile()
    {
        $data = Auth::user();

        return view('admin.profile.admin_profile', compact('data'));
    }

    /**
     * Cập nhật thông tin cá nhân.
     */
    public function updateProfile(AdminProfileRequest $request)
    {
        try {
            $admin = $this->profileService->updateProfile(
                Auth::user(),
                $request->only([
                    'name',
                    'first_name',
                    'last_name',
                    'phone',
                    'link_social',
                    'gender',
                    'dob',
                    'full_name'
                ]),
                $request->file('avatar_url'),
                $request->boolean('remove_current_photo')
            );

            return response()->json([
                'status' => 'success',
                'message' => __('Cập nhật thông tin cá nhân thành công.'),
                'data' => [
                    'username' => $admin->username,
                    'phone' => $admin->phone,
                    'link_social' => $admin->link_social,
                    'avatar_url' => $admin->avatar_url
                        ? asset("uploads/images/{$admin->avatar_url}")
                        : asset('uploads/no_image.jpg'),
                ]
            ]);
        } catch (Throwable $e) {
            Log::error('Admin profile update failed', [
                'user_id' => Auth::id(),
                'exception' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => __('Cập nhật thông tin thất bại. Vui lòng thử lại.'),
            ], 500);
        }
    }

    /**
     * Xoá ảnh đại diện.
     */
    public function removePhoto(Request $request)
    {
        $admin = Auth::user();

        if (!$admin || !$admin->avatar_url) {
            return response()->json([
                'status' => 'error',
                'message' => __('Không có ảnh để xoá.'),
            ], 400);
        }

        try {
            $this->profileService->updateProfile($admin, [], null, true);

            return response()->json([
                'status' => 'success',
                'message' => __('Ảnh đại diện đã được xoá.'),
                'photo' => asset('uploads/no_image.jpg'),
            ]);
        } catch (Throwable $e) {
            Log::error('Admin avatar removal failed', [
                'user_id' => $admin->id,
                'exception' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => __('Xoá avatar thất bại.'),
            ], 500);
        }
    }

    /**
     * Hiển thị form đổi mật khẩu.
     */
    public function showChangePassword()
    {
        $admin = Auth::user();

        return view('admin.profile.change_pass', compact('admin'));
    }

    /**
     * Cập nhật mật khẩu.
     */
    public function updatePassword(AdminPasswordRequest $request)
    {
        try {
            $this->profileService->changePassword(
                Auth::user(),
                $request->old_password,
                $request->new_password
            );

            // Đăng xuất sau khi đổi mật khẩu thành công
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json([
                'status' => 'success',
                'message' => 'Đổi mật khẩu thành công. Vui lòng đăng nhập lại!',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Lỗi xác thực (ví dụ mật khẩu cũ sai)
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 422);

        } catch (Throwable $e) {
            Log::error('Lỗi khi đổi mật khẩu', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra trong quá trình đổi mật khẩu. Vui lòng thử lại.',
            ], 500);
        }
    }

}
