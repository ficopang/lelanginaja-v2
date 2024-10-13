<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransactionReport>
 */
class TransactionReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = DB::table('users')->pluck('id')->toArray();
        $transactions = DB::table('transactions')->pluck('id')->toArray();

        return [
            'user_id' => fake()->randomElement($users),
            'transaction_id' => fake()->randomElement($transactions),
            'reason' => fake()->sentence,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
