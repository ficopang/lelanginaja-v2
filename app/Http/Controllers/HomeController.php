<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $carousel = Product::inRandomOrder()->limit(4)->get();
        $smallBanner = Product::inRandomOrder()->limit(1)->get()->first();

        $categories = Category::all()->take(6);

        $trendingProduct = Product::withCount('bids')
            ->orderBy('bids_count', 'desc')
            ->take(4)
            ->get();

        $specialOffer = Product::orderBy('start_time', 'asc')->limit(3)->get();
        $banner = Product::inRandomOrder()->limit(1)->get()->first();
        $offer = Product::inRandomOrder()->limit(1)->get()->first();

        $bestSellers = Product::inRandomOrder()->limit(3)->get();
        $newArrivals = Product::orderBy('created_at', 'asc')->limit(3)->get();
        $topRated = Product::inRandomOrder()->limit(3)->get();

        return view('index', compact('carousel', 'smallBanner', 'categories', 'trendingProduct', 'specialOffer', 'banner', 'offer', 'bestSellers', 'newArrivals', 'topRated'));
    }

    public function lang(Request $request, $locale)
    {
        if (!in_array($locale, ['en', 'id'])) {
            abort(400);
        }

        App::setLocale($locale);

        return redirect()->back();
    }

    public function category(Request $request)
    {
        $category = Category::findOrFail($request->input('id'));
        $products = $category->products()->paginate(6);

        $categories = Category::all();

        return view('product.product-grids', compact('products', 'categories'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $categoryId = $request->input('category_id');

        $products = Product::query();
        $categories = Category::all();

        if ($query) {
            $products->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'like', "%$query%")
                    ->orWhere('description', 'like', "%$query%");
            });
        }

        if ($categoryId) {
            $products->where('category_id', $categoryId);
        }

        if (!$query && !$categoryId) {
            $products->whereNotNull('id'); // Include all products
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'popularity'); // Default sorting by popularity
        if ($sortBy === 'popularity') {
            // Sort by popularity based on the number of bids
            $products->withCount('bids')->orderByDesc('bids_count');
        } elseif ($sortBy === 'low_high_price') {
            // Sort by low to high price
            $products = $products->leftJoin('bids', 'products.id', '=', 'bids.product_id')
                ->selectRaw('products.*, (products.starting_price + COALESCE(SUM(bids.bid_amount), 0)) as calculated_price')
                ->whereNotNull('products.id')
                ->whereNull('products.deleted_at')
                ->groupBy(
                    'products.id',
                    'products.name',
                    'products.starting_price',
                    'products.user_id',
                    'products.category_id',
                    'products.description',
                    'products.auction_type',
                    'products.min_bid_increment',
                    'products.min_bid_users',
                    'products.image_url',
                    'products.reset_time',
                    'products.start_time',
                    'products.end_time',
                    'products.deleted_at',
                    'products.created_at',
                    'products.updated_at',
                )
                ->orderBy('calculated_price', 'asc');
        } elseif ($sortBy === 'high_low_price') {
            // Sort by high to low price
            $products = $products->leftJoin('bids', 'products.id', '=', 'bids.product_id')
                ->selectRaw('products.*, (products.starting_price + COALESCE(SUM(bids.bid_amount), 0)) as calculated_price')
                ->whereNotNull('products.id')
                ->whereNull('products.deleted_at')
                ->groupBy(
                    'products.id',
                    'products.name',
                    'products.starting_price',
                    'products.user_id',
                    'products.category_id',
                    'products.description',
                    'products.auction_type',
                    'products.min_bid_increment',
                    'products.min_bid_users',
                    'products.image_url',
                    'products.reset_time',
                    'products.start_time',
                    'products.end_time',
                    'products.deleted_at',
                    'products.created_at',
                    'products.updated_at',
                )
                ->orderBy('calculated_price', 'desc');
        } elseif ($sortBy === 'a_z_order') {
            // Sort by name in ascending order
            $products->orderBy('name', 'asc');
        } elseif ($sortBy === 'z_a_order') {
            // Sort by name in descending order
            $products->orderBy('name', 'desc');
        }

        $products = $products->paginate(8);

        return view('product.product-grids', compact('products', 'query', 'categoryId', 'categories'));
    }
}
