<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {

        User::create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'password' => Hash::make('superadmin123'),
            'role' => 'superadmin',
        ]);

        // Buat Admin - TANPA factory()
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);
    }
}