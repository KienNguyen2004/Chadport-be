<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryIds = DB::table('categories')->pluck('cat_id');
        $sizeIds = DB::table('sizes')->pluck('size_id');
        $colorIds = DB::table('colors')->pluck('col_id');
        $brandIds = DB::table('brands')->pluck('brand_id');

        // Loop to insert multiple products
        for ($i = 1; $i <= 50; $i++) {
            DB::table('products')->insert([
                'pro_name' => fake()->word(),                       // Random product name
                'cat_id' => fake()->randomElement($categoryIds),    // Random category ID
                'size_id' => fake()->randomElement($sizeIds),       // Random size ID
                'col_id' => fake()->randomElement($colorIds),       // Random color ID
                'brand_id' => fake()->randomElement($brandIds),     // Random brand ID
                'image_product' => fake()->imageUrl(),              // Random image URL
                'quantity' => fake()->numberBetween(1, 100),        // Random quantity
                'price' => fake()->randomFloat(2, 10, 1000),        // Random price between 10 and 1000
                'price_sale' => fake()->optional()->randomFloat(2, 5, 800), // Optional sale price
                'type' => fake()->optional()->numberBetween(1, 3),  // Optional type
                'status' => fake()->numberBetween(0, 1),            // Random status (0 or 1)
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
