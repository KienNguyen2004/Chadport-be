<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Password_reset_tokensSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $emails = DB::table('users')->pluck('email')->toArray();

        // Loop để chèn nhiều bản ghi vào bảng password_reset_tokens
        for ($i = 0; $i < 10; $i++) {
            DB::table('password_reset_tokens')->insert([
                'email' => fake()->randomElement($emails), // Chọn ngẫu nhiên một email từ bảng users
                'token' => Str::random(60),                // Tạo một token ngẫu nhiên có độ dài 60 ký tự
                'created_at' => now(),                     // Thời gian tạo hiện tại
            ]);
        }
    }
}
