<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class ProfileService
{
    /**
     * Cập nhật thông tin cá nhân (Profile)
     */
    public function updateProfile(
        User $user,
        array $data,
        ?UploadedFile $photo = null,
        bool $removeCurrentPhoto = false
    ): User {
        DB::beginTransaction();

        try {
            $user->username = $data['username'] ?? $user->username;
            $user->first_name = $data['first_name'] ?? $user->first_name;
            $user->last_name = $data['last_name'] ?? $user->last_name;
            $user->phone = $data['phone'] ?? $user->phone;
            $user->link_social = $data['link_social'] ?? $user->link_social;
            $user->gender = $data['gender'] ?? $user->gender;
            $user->dob = $data['dob'] ?? $user->dob;
            $user->full_name = $data['full_name'] ?? $user->full_name;

            // Xóa ảnh cũ nếu người dùng chọn "remove"
            if ($removeCurrentPhoto) {
                $this->deletePhoto($user);
                $user->avatar_url = null;
            }

            // Upload ảnh mới
            if ($photo && $photo->isValid()) {
                $this->deletePhoto($user);
                $user->avatar_url = $this->uploadPhoto($photo);
            }

            $user->save();
            DB::commit();

            return $user;

        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Cập nhật hồ sơ admin thất bại', [
                'user_id' => $user->id ?? null,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Đổi mật khẩu admin
     */
    public function changePassword(User $user, string $oldPassword, string $newPassword): void
    {
        // Kiểm tra mật khẩu cũ
        if (!Hash::check($oldPassword, $user->password)) {
            throw ValidationException::withMessages([
                'old_password' => 'Mật khẩu cũ không đúng.',
            ]);
        }

        DB::beginTransaction();

        try {
            $user->password = Hash::make($newPassword);
            $user->save();

            DB::commit();

            Log::info('Admin đổi mật khẩu thành công', [
                'user_id' => $user->id,
                'username' => $user->username,
            ]);
        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Đổi mật khẩu thất bại', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Upload ảnh avatar
     */
    private function uploadPhoto(UploadedFile $file): string
    {
        $filename = now()->format('YmdHis') . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/images'), $filename);
        return $filename;
    }

    /**
     * Xóa ảnh cũ (nếu có)
     */
    private function deletePhoto(User $user): void
    {
        $photo = $user->avatar_url ?? $user->photo ?? null;
        if ($photo) {
            $path = public_path('uploads/images/' . $photo);
            if (file_exists($path)) {
                @unlink($path);
            }
        }
    }
}
