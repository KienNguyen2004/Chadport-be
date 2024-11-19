<?php

namespace Database\Seeders;

use Faker\Factory;
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
        $faker = Factory::create();
        $limit = 10;
        for ($i = 1; $i <= $limit; $i++) {
            DB::table('colors')->insert([
                'name' => $faker->safeColorName, 
                'image' => $faker->imageUrl, 
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
