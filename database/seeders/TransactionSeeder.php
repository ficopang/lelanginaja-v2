<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = DB::table('users')->pluck('id')->toArray();
        $products = DB::table('products')->pluck('id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            $buyerId = fake()->randomElement($users);
            $sellerId = fake()->randomElement($users);
            $productId = fake()->randomElement($products);
            $finalPrice = fake()->numberBetween(10000, 1000000);
            $status = fake()->randomElement(['Completed', 'Pending', 'Cancelled']);

            DB::table('transactions')->insert([
                'buyer_id' => $buyerId,
                'seller_id' => $sellerId,
                'product_id' => $productId,
                'final_price' => $finalPrice,
                'status' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}