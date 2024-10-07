<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WishlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy danh sách các ID từ bảng products và users
        $productIds = DB::table('products')->pluck('pro_id')->toArray();
        $userIds = DB::table('users')->pluck('user_id')->toArray();

        // Loop để chèn nhiều bản ghi vào bảng wishlist
        for ($i = 0; $i < 10; $i++) {
            DB::table('wishlist')->insert([
                'pro_id' => fake()->randomElement($productIds),   // Chọn ngẫu nhiên một pro_id
                'user_id' => fake()->randomElement($userIds),     // Chọn ngẫu nhiên một user_id
                'created_at' => now(),                            // Thời gian tạo hiện tại
                'updated_at' => now(),                            // Thời gian cập nhật hiện tại
            ]);
        }
    }
}
