<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WareHouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy danh sách các ID từ các bảng liên quan
        $productIds = DB::table('products')->pluck('pro_id')->toArray();
        $categoryIds = DB::table('categories')->pluck('cat_id')->toArray();
        $sizeIds = DB::table('sizes')->pluck('size_id')->toArray();
        $colorIds = DB::table('colors')->pluck('col_id')->toArray();
        $brandIds = DB::table('brands')->pluck('brand_id')->toArray();

        // Loop để chèn nhiều bản ghi vào bảng warehouse
        for ($i = 0; $i < 10; $i++) {
            DB::table('warehouse')->insert([
                'pro_id' => fake()->randomElement($productIds),   // Chọn ngẫu nhiên một pro_id
                'cat_id' => fake()->randomElement($categoryIds),  // Chọn ngẫu nhiên một cat_id
                'size_id' => fake()->randomElement($sizeIds),      // Chọn ngẫu nhiên một size_id
                'col_id' => fake()->randomElement($colorIds),      // Chọn ngẫu nhiên một col_id
                'brand_id' => fake()->randomElement($brandIds),    // Chọn ngẫu nhiên một brand_id
                'quantity' => fake()->numberBetween(1, 100),       // Số lượng ngẫu nhiên từ 1 đến 100
                'created_at' => now(),                             // Thời gian tạo hiện tại
                'updated_at' => now(),                             // Thời gian cập nhật hiện tại
            ]);
        }
    }
}
