<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = DB::table('users')->pluck('id')->toArray();
        $products = DB::table('products')->pluck('id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            DB::table('product_reports')->insert([
                'user_id' => fake()->randomElement($users),
                'product_id' => fake()->randomElement($products),
                'reason' => fake()->sentence,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}