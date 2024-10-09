<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Str;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) { // Tạo 10 bản ghi
            DB::table('banner')->insert([
                'banner_name' => fake()->word(), // Tên banner ngẫu nhiên
                'banner_titler' => fake()->sentence(6), // Tiêu đề banner giả lập
                'banner_type' => fake()->numberBetween(1, 3), // Loại banner ngẫu nhiên từ 1 đến 3
                'status' => fake()->numberBetween(0, 1), // Trạng thái banner (0: Inactive, 1: Active)
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
    }
}
