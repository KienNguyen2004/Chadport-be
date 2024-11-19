<?php

namespace Database\Seeders;

use Faker\Factory;
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
        $faker = Factory::create();
        $limit = 10;
        for ($i = 1; $i <= $limit; $i++) {
            DB::table('sizes')->insert([
                'name' => $faker->randomElement(['XS', 'S', 'M', 'L', 'XL', 'XXL']), // Random size names
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
