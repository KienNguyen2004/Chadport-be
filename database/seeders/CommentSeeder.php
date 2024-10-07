<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $productIds = DB::table('products')->pluck('pro_id');
        $userIds = DB::table('users')->pluck('user_id');

        // Loop to insert multiple comments
        for ($i = 1; $i <= 50; $i++) {
            DB::table('comment')->insert([
                'pro_id' => fake()->randomElement($productIds), // Pick a random product ID
                'user_id' => fake()->randomElement($userIds),   // Pick a random user ID
                'comment_customer' => fake()->sentence(10),     // Generates a random customer comment
                'comment_admin' => fake()->sentence(10),        // Generates a random admin comment
                'status' => fake()->numberBetween(0, 1),        // Randomly generates 0 or 1 for status
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
