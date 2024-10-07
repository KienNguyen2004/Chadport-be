<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        // fake dữ liệu 
        $this->call(UserSeeder::class);
        $this->call(BannerSeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(CategorieSeeder::class);
        $this->call(ColorSeeder::class);
        $this->call(SizeSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(VoucherSeeder::class);
        $this->call(OderSeeder::class);
        $this->call(Oder_detailSeeder::class);
        $this->call(Failed_jobsSeeder::class);
        $this->call(Personal_access_tokensSeeder::class);
        $this->call(Password_reset_tokensSeeder::class);
        $this->call(Voucher_usedSeeder::class);
        $this->call(WareHouseSeeder::class);
        $this->call(WishlistSeeder::class);

        // end fake dữ liệu 
        

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
