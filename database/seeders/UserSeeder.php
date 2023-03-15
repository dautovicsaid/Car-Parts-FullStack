<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'role_id' => 1,
            'password' => bcrypt('password'),
        ]);

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role_id' => 2,
            'password' => bcrypt('password'),
        ]);

        DB::table('users')->insert([
            'name' => 'User',
            'email' => 'saiddautovic003@gmail.com',
            'role_id' => 3,
            'password' => bcrypt('password'),
        ]);
    }
}
