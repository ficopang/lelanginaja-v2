<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = DB::table('users')->pluck('id')->toArray();
        $products = DB::table('products')->pluck('id')->toArray();

        return [
            'buyer_id' => fake()->randomElement($users),
            'seller_id' => fake()->randomElement($users),
            'product_id' => fake()->randomElement($products),
            'final_price' => fake()->numberBetween(10000, 1000000),
            'status' => fake()->randomElement(['Completed', 'Pending', 'Cancelled']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
