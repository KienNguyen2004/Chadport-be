<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 50; $i++) {
            DB::table('categories')->insert([
                'cat_name' => fake()->word(), // Generates a random word for category name
                'parent_id' => null, // Set to null or link it to another category if needed
                'status' => fake()->numberBetween(0, 1), // Randomly generates 0 or 1
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
