<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Oder_detailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productIds = DB::table('products')->pluck('pro_id');
        $oderIds = DB::table('oders')->pluck('oder_id');
        for ($i = 0; $i < 10; $i++) {
            DB::table('oder_detail')->insert([
                'oder_id' =>fake()->randomElement($productIds), // Chọn ngẫu nhiên một order từ bảng orders
                'pro_id' =>fake()->randomElement($oderIds), // Chọn ngẫu nhiên một product từ bảng products
                'odt_quantity' => rand(1, 100), // Số lượng ngẫu nhiên
                'odt_price' => rand(10, 1000) + rand(0, 99) / 100, // Giá tiền ngẫu nhiên
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
