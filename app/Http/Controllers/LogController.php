<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Product;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Get product recommendations for a user.
     *
     * @param int $user_id
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function recommendProducts($user_id)
    {
        // Step 1: Fetch user interaction history (views and searches)
        $userLogs = Log::where('user_id', $user_id)->get();

        // Get a list of all products the user has viewed or searched
        $userProducts = $userLogs->pluck('product_id')->unique()->toArray();

        // If the user hasn't interacted with any product, return empty recommendations
        if (empty($userProducts)) {
            return null;
        }

        // Step 2: Calculate similarity between user-interacted products and other products
        $recommendations = [];
        $allProducts = Product::all()->pluck('id')->toArray();

        foreach ($allProducts as $productId) {
            if (in_array($productId, $userProducts)) {
                // Skip products the user has already interacted with
                continue;
            }

            // Calculate similarity between this product and all user-interacted products
            $similarityScore = $this->calculateItemSimilarity($productId, $userProducts);

            // Store the similarity score
            if ($similarityScore > 0) {
                $recommendations[$productId] = $similarityScore;
            }
        }

        // Step 3: Sort recommendations by similarity score in descending order
        arsort($recommendations);

        // Step 4: Fetch the recommended products' details
        $recommendedProductIds = array_keys($recommendations);
        $recommendedProducts = Product::whereIn('id', $recommendedProductIds)->get();

        // Return recommendations as JSON response
        return $recommendedProducts;
    }

    /**
     * Calculate similarity between two products based on user interactions.
     *
     * @param int $productId
     * @param array $userProducts
     * @return float
     */
    private function calculateItemSimilarity($productId, $userProducts)
    {
        $similaritySum = 0;

        foreach ($userProducts as $userProductId) {
            $similaritySum += $this->cosineSimilarity($productId, $userProductId);
        }

        // Return the average similarity score
        return count($userProducts) > 0 ? $similaritySum / count($userProducts) : 0;
    }

    /**
     * Cosine similarity between two products based on user interaction logs.
     *
     * @param int $productA
     * @param int $productB
     * @return float
     */
    private function cosineSimilarity($productA, $productB)
    {
        // Fetch users who interacted with Product A and Product B
        $usersA = Log::where('product_id', $productA)->pluck('user_id')->toArray();
        $usersB = Log::where('product_id', $productB)->pluck('user_id')->toArray();

        // Calculate the intersection and the union of the two user sets
        $intersection = array_intersect($usersA, $usersB);
        $normA = sqrt(count($usersA));
        $normB = sqrt(count($usersB));

        if ($normA > 0 && $normB > 0) {
            return count($intersection) / ($normA * $normB);
        } else {
            return 0;
        }
    }
}
