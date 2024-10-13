<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create dummy chats
        $users = DB::table('users')->pluck('id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            $senderId = fake()->randomElement($users);
            $receiverId = fake()->randomElement($users);

            // Make sure sender and receiver are different users
            while ($senderId === $receiverId) {
                $receiverId = fake()->randomElement($users);
            }

            DB::table('chats')->insert([
                'sender_id' => $senderId,
                'receiver_id' => $receiverId,
                'message' => fake()->sentence,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}