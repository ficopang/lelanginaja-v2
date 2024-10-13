<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use App\Models\Watchlist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WatchlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $products = Product::all();

        foreach ($users as $user) {
            $watchlistItems = $products->random(3); // Add 3 random products to the user's watchlist
            foreach ($watchlistItems as $product) {
                Watchlist::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                ]);
            }
        }
    }
}
