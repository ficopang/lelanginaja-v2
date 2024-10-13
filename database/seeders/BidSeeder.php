<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = DB::table('users')->pluck('id')->toArray();
        $products = DB::table('products')->pluck('id')->toArray();

        foreach ($products as $productId) {
            $bidCount = fake()->numberBetween(0, 5);

            for ($i = 0; $i < $bidCount; $i++) {
                $userId = fake()->randomElement($users);
                $bid_amount = fake()->numberBetween(1000, 100000);

                DB::table('bids')->insert([
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'bid_amount' => $bid_amount,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}