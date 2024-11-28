<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        User::factory(500)->create();

        DB::table('users')->insert([
            [
                'name' => 'Tushar - Customer',
                'email' => 'customer@customer.com',
                'phone' => '888 999 888',
                'password' => Hash::make('customer'),
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'name' => 'Admin',
                'email' => 'email@mail.com',
                'phone' => '888 999 333',
                'password' => Hash::make(12345678),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        DB::table('admins')->insert([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'phone' => '888 999 333',
            'password' => Hash::make(12345678),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('locations')->insert([
            [
                'name' => 'Gulshan-1, Dhaka',
                'full_address' => 'Gulshan-1, Dhaka'
            ],
            [
                'name' => 'Gulshan-2, Dhaka',
                'full_address' => 'Gulshan-2, Dhaka'
            ],
            [
                'name' => 'Badda, Dhaka',
                'full_address' => 'Badda, Dhaka'
            ],
            [
                'name' => 'Gazipur, Dhaka',
                'full_address' => 'Badda, Dhaka'
            ]
        ]);
    }
}
