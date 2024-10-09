<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        for ($i = 1; $i <= 50; $i++) {
            DB::table('colors')->insert([
                'col_name' => fake()->safeColorName(), // Generates a random color name
                'status' => fake()->numberBetween(0, 1), // Randomly generates 0 or 1
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
