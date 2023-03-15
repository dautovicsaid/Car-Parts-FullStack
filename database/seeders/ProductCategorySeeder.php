<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_categories')->insert([
            ['name' => 'Engine', 'created_at' => now()],
            ['name' => 'Breaks', 'created_at' => now()],
            ['name' => 'Steering wheel', 'created_at' => now()],
        ]);
    }
}
