<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomCakeFlavorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('custom_cake_flavors')->insert([
            ['name' => 'Vanilla'],
            ['name' => 'Chocolate'],
            ['name' => 'Red Velvet'],
            ['name' => 'Lemon'],
            ['name' => 'Strawberry'],
            ['name' => 'Black Forest'],
            ['name' => 'Carrot'],
        ]);
    }
}
