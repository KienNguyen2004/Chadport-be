<?php

namespace Database\Seeders;

use Faker\Factory;
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

        $faker = Factory::create();
        $limit = 10;
        for ($i = 0; $i < $limit; $i++) { // Tạo 10 bản ghi
            DB::table('categories')->insert([
                'name' =>$faker->name, 
                'status'=> 'active'
            ]);
        }
        
    }
}
