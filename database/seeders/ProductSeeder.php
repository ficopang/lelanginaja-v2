<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Database\Factories\Ecommerce;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Product::factory()
        //     ->count(50)
        //     ->create();

        for ($i = 0; $i < 100; $i++) {
            $users = DB::table('users')->pluck('id')->toArray();
            $ecommerce = new Ecommerce(fake());

            $categoryMap = [
                "electronic" => [
                    'television' => $ecommerce->television(),
                    'mobile_phone' => $ecommerce->mobilePhone(),
                    'laptop' => $ecommerce->laptop(),
                    'camera' => $ecommerce->camera(),
                ],
                "art" => [
                    'guitar' => $ecommerce->guitar(),
                    'piano' => $ecommerce->piano(),
                    'painting' => $ecommerce->painting(),
                ],
                "automotive" => [
                    'car' => $ecommerce->car(),
                    'motorcycle' => $ecommerce->motorcycle(),
                ],
                "fashion" => [
                    'shirt' => $ecommerce->shirt(),
                    'jean' => $ecommerce->jean(),
                    'shoe' => $ecommerce->shoes(),
                ],
                "book" => [
                    'novel' => $ecommerce->novel(),
                    'lesson' => $ecommerce->lesson(),
                ],
            ];

            $randomCategoryKey = array_rand($categoryMap);
            $randomCategoryItems = $categoryMap[$randomCategoryKey];
            $randomSubItemKey = array_rand($randomCategoryItems);
            $randomSubItem = $randomCategoryItems[$randomSubItemKey];

            $imagePath = "public/{$randomCategoryKey}s/{$randomSubItemKey}s";
            $imageFiles = Storage::files($imagePath);
            $imageUrl = str_replace('/storage', '', Storage::url(fake()->randomElement($imageFiles)));

            $product = Product::create([
                'user_id' => fake()->randomElement($users),
                'category_id' => Category::where('name', ucfirst($randomCategoryKey))->first()->id,
                'name' => $randomSubItem,
                'description' => fake()->paragraph,
                'starting_price' => fake()->numberBetween(10, 1000) * 1000,
                'auction_type' => fake()->randomElement(['open', 'close']),
                'min_bid_increment' => fake()->numberBetween(1, 100) * 1000,
                'min_bid_users' => fake()->numberBetween(1, 3),
                'reset_time' => 30,
                'start_time' => fake()->dateTimeBetween('now', '+1 week'),
                'start_time' => fake()->dateTimeBetween('now', '+1 week'),
                'end_time' => fake()->dateTimeBetween('+1 week', '+2 weeks'),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::table('product_images')->insert([
                'product_id' => $product->id,
                'image_url' => $imageUrl,
            ]);
        }
    }
}