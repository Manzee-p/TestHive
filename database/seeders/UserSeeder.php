<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();

        \App\Models\User::create([
            'nama_lengkap' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('rahasia'),
            'role' => 'admin',
        ]);

        \App\Models\User::create([
            'nama_lengkap' => 'User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('rahasia'),
            'role' => 'user',
        ]);
    }
}
