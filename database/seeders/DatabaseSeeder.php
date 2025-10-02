<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();


        // Tạo user admin
        // User::factory()->create([
        //     'name' => 'Admin',
        //     'email' => 'taicutm@gmail.com',
        //     'password' => Hash::make('12345678'),
        //      'role' => 'admin',   // ghi đè role
        // ]);

        // lệnh này để update nếu có rồi thì không tạo nữa
        User::updateOrCreate(
            ['email' => 'taicutm@gmail.com'], // điều kiện để tìm user
            [
                'name' => 'Admin',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
            ]
        );

        // // từ factory tạo 10 user
        // User::factory(10)->create();
    }
}
