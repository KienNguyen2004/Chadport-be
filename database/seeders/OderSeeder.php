<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vocIds = DB::table('vocher')->pluck('voc_id');
        $productIds = DB::table('products')->pluck('pro_id');
        $userIds = DB::table('users')->pluck('user_id');

        // Loop để chèn nhiều đơn hàng
        for ($i = 1; $i <= 50; $i++) {
            DB::table('oders')->insert([
                'voc_id' => fake()->randomElement($vocIds),                // Chọn ngẫu nhiên một voc_id
                'pro_id' => fake()->randomElement($productIds),           // Chọn ngẫu nhiên một pro_id
                'user_id' => fake()->randomElement($userIds),             // Chọn ngẫu nhiên một user_id
                'oder_shiping' => fake()->numberBetween(1, 100),          // Số tiền shipping ngẫu nhiên
                'oder_payment_type' => fake()->numberBetween(1, 3),       // Loại hình thanh toán ngẫu nhiên
                'total_money' => fake()->randomFloat(2, 10, 1000),        // Tổng tiền ngẫu nhiên
                'oder_total' => fake()->numberBetween(1, 10),             // Tổng số lượng đơn hàng ngẫu nhiên
                'address' => fake()->address(),                            // Địa chỉ ngẫu nhiên
                'ward' => fake()->word(),                                  // Phường ngẫu nhiên
                'status' => fake()->numberBetween(0, 1),                  // Trạng thái ngẫu nhiên (0 hoặc 1)
                'created_at' => now(),                                    // Thời gian tạo hiện tại
                'updated_at' => now(),                                    // Thời gian cập nhật hiện tại
            ]);
        }
    }
}
