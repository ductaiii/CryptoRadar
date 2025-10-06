<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            // 1 user admin
        User::create(attributes: [
            'name' => 'Tôn Quyền',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);
        // 1 user superadmin
        User::create([
            'name' => 'Triệu Vân',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'superadmin',
        ]);
        // 1 user role user tạo bằng cách thủ công
        User::create([
            'name' => 'Quan Vũ',
            'email' => 'user@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'user',
        ]);
        // 3 user role được tao bằng factory
        User::factory()->count(3)->create();
    }
}
