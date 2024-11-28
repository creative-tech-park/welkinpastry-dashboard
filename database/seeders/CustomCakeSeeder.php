<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomCakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('custom_cakes')->insert([
            [
                'name' => 'Round Photo Cake',
                'price' => 300,
                'image' => 'uploads/custom_cakes/1.jpg',

            ],
            [
                'name' => 'Square Photo Cake',
                'price' => 1000,
                'image' => 'uploads/custom_cakes/2.jpg',
            ],
        ]);
    }
}
