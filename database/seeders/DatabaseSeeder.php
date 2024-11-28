<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            TestimonialSeeder::class,
            CompanyServiceSeeder::class,
            CustomCakeSeeder::class,
            CustomCakeFlavorSeeder::class,
            //            AdminSeeder::class,
//            ManagerSeeder::class,
//            BrandSeeder::class,
//            CategorySeeder::class,
            // ProductSeeder::class,
        ]);
    }
}
