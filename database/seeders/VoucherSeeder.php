<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table('vocher')->insert([
                'voc_name' => fake()->word(),                             // Tên voucher ngẫu nhiên
                'voc_price' => fake()->randomFloat(2, 1, 100),          // Giá voucher ngẫu nhiên từ 1 đến 100
                'status' => fake()->numberBetween(0, 1),                 // Trạng thái ngẫu nhiên (0 hoặc 1)
                'created_at' => now(),                                   // Thời gian tạo hiện tại
                'expiration_date' => fake()->dateTimeBetween('now', '+1 year'), // Ngày hết hạn ngẫu nhiên trong khoảng từ hiện tại đến 1 năm sau
            ]);
        }
    }
}
