<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
// use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) { // Chèn 50 bản ghi giả
            DB::table('users')->insert([
                'role_id' => fake()->numberBetween(1, 5), // Giả định có từ 5 role khác nhau
                'firt_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'gender' => fake()->randomElement([0, 1]), // 0 hoặc 1
                'birthday' => fake()->date('Y-m-d', '2003-01-01'), // Ngày sinh từ năm 2003 trở về trước
                'address' => fake()->address,
                'image_user' => fake()->imageUrl(640, 480, 'people'), // URL ảnh người
                'email' => fake()->unique()->safeEmail,
                'phone_number' => fake()->optional()->phoneNumber, // Optional phone number
                'password' => bcrypt('password'), // Mã hóa password
                'status' => fake()->randomElement([0, 1]), // 0 hoặc 1 cho status
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        

    }
}
