<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = DB::table('users')->pluck('id')->toArray();
        $ecommerce = new Ecommerce(fake());

        $categoryMap = [
            "electronics" => [
                'television' => $ecommerce->television(),
                'mobile_phone' => $ecommerce->mobilePhone(),
                'laptop' => $ecommerce->laptop(),
                'camera' => $ecommerce->camera(),
            ],
            "arts" => [
                'guitar' => $ecommerce->guitar(),
                'piano' => $ecommerce->piano(),
                'painting' => $ecommerce->painting(),
            ],
            "automotives" => [
                'car' => $ecommerce->car(),
                'motorcycle' => $ecommerce->motorcycle(),
            ],
            "clothings" => [
                'shirt' => $ecommerce->shirt(),
                'jean' => $ecommerce->jean(),
                'shoe' => $ecommerce->shoes(),
            ],
            "books" => [
                'novel' => $ecommerce->novel(),
                'lesson' => $ecommerce->lesson(),
            ],
        ];

        $randomCategoryKey = array_rand($categoryMap);
        $randomCategory = $categoryMap[$randomCategoryKey];
        $randomSubItemKey = array_rand($randomCategory);
        $randomCategorySubItem = $randomCategory[$randomSubItemKey];

        $imagePath = "public/{$randomCategory}/{$randomCategorySubItem}";
        $imageFiles = Storage::files($imagePath);

        return [
            'user_id' => fake()->randomElement($users),
            'category_id' => Category::where('name', $randomCategory)->first()->id,
            'name' => $randomCategory,
            'description' => fake()->paragraph,
            'starting_price' => fake()->numberBetween(1, 1000) * 1000,
            'auction_type' => fake()->randomElement(['open', 'close']),
            'min_bid_increment' => fake()->numberBetween(1, 100) * 1000,
            'min_bid_users' => fake()->numberBetween(1, 3),
            'reset_time' => 30,
            'start_time' => fake()->dateTimeBetween('now', '+1 week'),
            'start_time' => fake()->dateTimeBetween('now', '+1 week'),
            'end_time' => fake()->dateTimeBetween('-1 days', '+2 weeks'),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
