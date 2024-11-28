<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CompanyServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('company_services')->insert([
            [
                'name' => 'Cake Design',
                'details' => "Explore Welkin Pastry’s exquisite cake designs where art meets flavor for unforgettable celebrations.",
                'image' => 'uploads/services/service.jpg',
            ],
            [
                'name' => 'Menu Planner',
                'details' => "Welkin Pastry offers a comprehensive menu planning service tailored to your event’s needs.",
                'image' => 'uploads/services/service-2.jpg',
            ],
            [
                'name' => 'Best Taste',
                'details' => "Savor the best at Welkin Pastry where every bite of our cakes is crafted for unparalleled taste.",
                'image' => 'uploads/services/service-3.jpg',
            ],
        ]);
    }
}
