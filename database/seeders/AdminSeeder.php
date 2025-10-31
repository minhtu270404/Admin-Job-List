<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
       

        // Tạo admin mặc định
        $admin = Admin::firstOrCreate(
            ['name' => 'admin'],
            [
                'email' => 'admin@example.com',
                'password' => Hash::make('12345678'),
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'language' => 'vi',
                'avatar_url' => '/default-uploads/avatar.png',
            ]
        );

            $admin->assignRole('Super Admin');

        $this->command->info('Seeder: Admin mặc định đã được tạo thành công.');
    }
}
