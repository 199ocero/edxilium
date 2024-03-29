<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'status' => 'activated',
            'role' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('shutdown199'),
        ]);
    }
}
