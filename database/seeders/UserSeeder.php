<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::create([
        //     'name' => 'Admin',
        //     'email' => 'admin@example.com',
        //     'password' => Hash::make('password'),
        //     'role' => 'admin',
        // ]);
        // User::create([
        //     'name' => 'User',
        //     'email' => 'user@example.com',
        //     'password' => Hash::make('password'),
        //     'role' => 'user',
        // ]);

        DB::table('users')->insert([
            'name' => 'Admin',
            'username' => 'admin',
            'no_telp' => '081234567890',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
        ]);
        User::create([
            'name' => 'User',
            'username' => 'user',
            'no_telp' => '081234567891',
            'email' => 'user@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'user',
        ]);
    }
}
