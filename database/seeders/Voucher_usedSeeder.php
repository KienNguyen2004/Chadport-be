<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Voucher_usedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy danh sách voc_id và user_id từ các bảng tương ứng
        $vocIds = DB::table('vocher')->pluck('voc_id')->toArray();
        $userIds = DB::table('users')->pluck('user_id')->toArray();

        // Loop để chèn nhiều voucher đã sử dụng
        for ($i = 0; $i < 10; $i++) {
            DB::table('vocher_used')->insert([
                'voc_id' => fake()->randomElement($vocIds),                  // Chọn ngẫu nhiên một voc_id
                'user_id' => fake()->randomElement($userIds),                // Chọn ngẫu nhiên một user_id
                'created_at' => now(),                                       // Thời gian tạo hiện tại
                'expiration_date' => fake()->dateTimeBetween('now', '+1 year'), // Ngày hết hạn trong khoảng từ hiện tại đến 1 năm sau
            ]);
        }
    }
}
