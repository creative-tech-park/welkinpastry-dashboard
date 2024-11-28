<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('testimonials')->insert([
            [
                'name' => 'Samuel Schick',
                'message' => "This restaurant has the best service I've ever experienced!",
                'image' => 'uploads/testimonials/IBnNAl9zkaZZRhsjqod5QCu5tawUv9MhbtcNbkde.jpg',
            ],
            [
                'name' => 'Jane Doe',
                'message' => "Amazing food and a great ambiance! I'll definitely come back!",
                'image' => 'uploads/testimonials/jf1TaX4CyXdJqxBRUiRVeOzbzBptFcUgrOFqFiSp.jpg',
            ],
            [
                'name' => 'John Smith',
                'message' => "Customer service here is unmatched. Highly recommend this place.",
                'image' => 'uploads/testimonials/yMwlb4GlcYnQqJD8gSyU4MBvbeuHIJKeLzbqnmi5.jpg',
            ],
        ]);
    }
}
