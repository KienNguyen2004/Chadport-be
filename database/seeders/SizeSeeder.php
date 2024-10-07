<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 50; $i++) {
            DB::table('sizes')->insert([
                'size_name' => strtoupper(fake()->randomElement(['XS', 'S', 'M', 'L', 'XL', 'XXL'])), // Random size names
                'status' => fake()->numberBetween(0, 1),  // Random status (0 or 1)
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
