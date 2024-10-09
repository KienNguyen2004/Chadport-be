<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) { // Tạo 10 bản ghi
            DB::table('brands')->insert([
                'brand_name' => fake()->company, // Tên thương hiệu ngẫu nhiên
                'status' => fake()->numberBetween(0, 1), // Trạng thái thương hiệu (0: Inactive, 1: Active)
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
