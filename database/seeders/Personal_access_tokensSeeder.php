<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Personal_access_tokensSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = DB::table('users')->pluck('user_id')->toArray();

        // Loop để chèn nhiều bản ghi vào bảng personal_access_tokens
        for ($i = 0; $i < 10; $i++) {
            DB::table('personal_access_tokens')->insert([
                'tokenable_type' => 'App\Models\User',            // Loại đối tượng mà token thuộc về
                'tokenable_id' => fake()->randomElement($userIds), // ID của đối tượng (user)
                'name' => fake()->word(),                          // Tên ngẫu nhiên cho token
                'token' => Str::random(64),                        // Token ngẫu nhiên 64 ký tự
                'abilities' => json_encode(['read', 'write']),    // Các khả năng ngẫu nhiên (mã hóa thành JSON)
                'last_used_at' => fake()->optional()->dateTime(), // Thời gian sử dụng gần nhất
                'expires_at' => fake()->optional()->dateTimeBetween('now', '+1 year'), // Ngày hết hạn ngẫu nhiên trong 1 năm tới
                'created_at' => now(),                            // Thời gian tạo hiện tại
                'updated_at' => now(),                            // Thời gian cập nhật hiện tại
            ]);
        }

        // $userIds = DB::table('users')->pluck('id')->toArray(); 

        // // Loop để chèn nhiều token cá nhân
        // for ($i = 0; $i < 10; $i++) {
        //     DB::table('personal_access_tokens')->insert([
        //         'tokenable_id' => fake()->randomElement($userIds),       // Chọn ngẫu nhiên một user_id
        //         'tokenable_type' => 'App\Models\User',                   // Kiểu mô hình (User)
        //         'name' => fake()->word(),                                 // Tên ngẫu nhiên cho token
        //         'token' => Str::random(64),                              // Tạo một token ngẫu nhiên với chiều dài 64 ký tự
        //         'abilities' => fake()->optional()->text(),               // Khả năng (có thể rỗng)
        //         'last_used_at' => fake()->optional()->dateTime(),       // Thời gian sử dụng gần nhất (có thể rỗng)
        //         'expires_at' => fake()->optional()->dateTime(),         // Thời gian hết hạn (có thể rỗng)
        //         'created_at' => now(),                                   // Thời gian tạo hiện tại
        //         'updated_at' => now(),                                   // Thời gian cập nhật hiện tại
        //     ]);
        // }
    }
}
