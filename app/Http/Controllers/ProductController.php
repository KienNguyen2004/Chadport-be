<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductController extends Controller
{
    public function create()
    {
        $faker = Faker::create();
        
        // Insert fake data
         $db=DB::table('colors')->insert([
           'col_name' => $faker->colorName,  // Generates a random color name
            'status' => $faker->boolean(80),  // 1 for active (80% chance), 0 for inactive
            'created_at' => now(),  // Current timestamp
            'updated_at' => now()  // Current timestamp
        ]);
        return response()->json([
            'data' =>  $db 
        ], 200);
    }
}
