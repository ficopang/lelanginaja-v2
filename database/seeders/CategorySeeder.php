<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Television'],
            ['name' => 'Mobile Phone'],
            ['name' => 'Laptop'],
            ['name' => 'Camera'],
            // ['name' => 'mens_clothing'],
            // ['name' => 'womens_clothing'],
            // ['name' => 'jewelry'],
            // ['name' => 'watches'],
        ];

        DB::table('categories')->insert($categories);
    }
}
