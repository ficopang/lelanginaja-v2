<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table('users')->insert([
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'email' => fake()->unique()->safeEmail,
                'email_verified_at' => now(),
                'balance' => 1000000,
                'password' => Hash::make('password'),
                'phone_number' => fake()->phoneNumber,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // dummy
        DB::table('users')->insert([
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => "user@gmail.com",
            'email_verified_at' => now(),
            'balance' => 1000000,
            'password' => Hash::make('asdasd'),
            'phone_number' => fake()->phoneNumber,
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => "admin@gmail.com",
            'email_verified_at' => now(),
            'balance' => 1000000,
            'isAdmin' => 1,
            'password' => Hash::make('asdasd'),
            'phone_number' => fake()->phoneNumber,
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
