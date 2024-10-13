<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WithdrawSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = DB::table('users')->pluck('id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            $userId = fake()->randomElement($users);

            DB::table('withdraws')->insert([
                'user_id' => $userId,
                'amount' => fake()->numberBetween(1000, 10000),
                'status' => fake()->randomElement(['success', 'processed', 'queue']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}