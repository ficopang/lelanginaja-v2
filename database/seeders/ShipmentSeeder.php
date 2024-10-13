<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ShipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactions = DB::table('transactions')->pluck('id')->toArray();

        $couriers = ['JNE', 'SiCepat', 'AnterAja'];

        foreach ($transactions as $transactionId) {
            $shippingCost = fake()->numberBetween(10, 50);
            $status = fake()->randomElement(['shipped', 'processing', 'delivered']);
            $courier = fake()->randomElement($couriers);

            DB::table('shipments')->insert([
                'transaction_id' => $transactionId,
                'name' => fake()->firstName() . " " . fake()->lastName(),
                'phone_number' => fake()->phoneNumber,
                'courier' => $courier,
                'address' => fake()->streetAddress,
                'city' => fake()->city,
                'province' => fake()->state,
                'country' => fake()->country,
                'postal_code' => fake()->postcode,
                'cost' => $shippingCost,
                'status' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
