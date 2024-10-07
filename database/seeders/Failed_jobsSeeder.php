<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Failed_jobsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table('failed_jobs')->insert([
                'uuid' => str::uuid(),                              // UUID ngẫu nhiên
                'connection' => fake()->sentence(3),               // Kết nối ngẫu nhiên (câu ngắn)
                'queue' => fake()->word(),                          // Hàng đợi ngẫu nhiên
                'payload' => json_encode(['data' => fake()->text()]), // Payload ngẫu nhiên (mã hóa thành JSON)
                'exception' => fake()->text(200),                  // Thông báo lỗi ngẫu nhiên
                'failed_at' => now(),                              // Thời gian thất bại hiện tại
            ]);
        }
    }
}
