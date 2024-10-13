<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        foreach ($products as $product) {
            $category = str_replace(' ', '_', strtolower($product->category->name));
            $imagePath = "public/{$category}s";
            $imageFiles = Storage::files($imagePath);
            $imageUrl = str_replace('/storage', '', Storage::url(fake()->randomElement($imageFiles)));

            DB::table('product_images')->insert([
                'product_id' => $product->id,
                'image_url' => $imageUrl,
            ]);
        }
    }
}