<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ProductImageSeeder::class);
        $this->call(WatchlistSeeder::class);
        $this->call(ProductReportSeeder::class);
        $this->call(BidSeeder::class);
        $this->call(ChatSeeder::class);
        $this->call(WithdrawSeeder::class);
        $this->call(TransactionSeeder::class);
        $this->call(ShipmentSeeder::class);
        $this->call(TransactionReportSeeder::class);
        $this->call(LogSeeder::class);
    }
}