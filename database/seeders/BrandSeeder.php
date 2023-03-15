<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->insert([
            [
                'name' => 'Audi',
                'description' => fake()->text(100),
                'created_at' => now()],
            [
                'name' => 'BMW',
                'description' => fake()->text(100),
                'created_at' => now()
            ],
            [
                'name' => 'Mercedes',
                'description' => fake()->text(100),
                'created_at' => now()],
        ]);
    }
}
