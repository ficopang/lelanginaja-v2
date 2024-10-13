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

        $categoryNames = [
            'televisions',
            'mobile_phones',
            'laptops',
            'cameras',
            // 'mens_clothing',
            // 'womens_clothing',
            // 'jewelry',
            // 'watches',
        ];

        $categoryMap = [
            'televisions' => $ecommerce->televisions(),
            'mobile_phones' => $ecommerce->mobilePhones(),
            'laptops' => $ecommerce->laptops(),
            'cameras' => $ecommerce->cameras(),
            // 'mens_clothing' => $ecommerce->mensClothing(),
            // 'womens_clothing' => $ecommerce->womensClothing(),
            // 'jewelry' => $ecommerce->jewelry(),
            // 'watches' => $ecommerce->watches(),
        ];

        $categoryIndex = fake()->numberBetween(0, count($categoryNames) - 1);
        $category = $categoryNames[$categoryIndex];
        $imagePath = "public/{$category}";
        $imageFiles = Storage::files($imagePath);

        return [
            'user_id' => fake()->randomElement($users),
            'category_id' => Category::find($categoryIndex + 1),
            'name' => $categoryMap[$category],
            'description' => fake()->paragraph,
            'starting_price' => fake()->numberBetween(10, 1000) * 1000,
            'auction_type' => fake()->randomElement(['open', 'close']),
            'min_bid_increment' => fake()->numberBetween(1, 100) * 1000,
            'min_bid_users' => fake()->numberBetween(1, 3),
            // 'image_url' => $imageUrl,
            'reset_time' => 30,
            'start_time' => fake()->dateTimeBetween('now', '+1 week'),
            'start_time' => fake()->dateTimeBetween('now', '+1 week'),
            'end_time' => fake()->dateTimeBetween('+1 week', '+2 weeks'),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}