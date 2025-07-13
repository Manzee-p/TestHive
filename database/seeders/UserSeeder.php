<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();

        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'kelas_id' => 1,
            'password' => bcrypt('admin123'),
            'isAdmin' => '2',
        ]);

         \App\Models\User::create([
            'name' => 'Pa Ute',
            'email' => 'paute@gmail.com',
            'kelas_id' => 2,
            'password' => bcrypt('12345678'),
            'isAdmin' => '1',
        ]);

        \App\Models\User::create([
            'name' => 'Asep Rohman',
            'email' => 'asep@gmail.com',
            'kelas_id' => 1,
            'password' => bcrypt('12345678'),
            'isAdmin' => '0',
        ]);
    }
}