<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // timezone
        Carbon::setLocale('id');

        // Use the `view` method to specify the template(s) you want to pass data to
        View::composer('template.generic', function ($view) {
            $categories = Category::all();
            $userId = auth()->id();
            $wonProducts = Product::whereHas('bids', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
                ->whereDoesntHave('transaction')
                ->where('end_time', '<', Carbon::now()->addHours(7))
                ->where(function ($query) use ($userId) {
                    $query->where(function ($subQuery) use ($userId) {
                        $subQuery->where('auction_type', 'close')
                            ->whereRaw('products.id IN (SELECT b.product_id FROM bids b JOIN products p ON b.product_id = p.id GROUP BY b.user_id, b.product_id ORDER BY SUM(b.bid_amount) + p.starting_price DESC)'); 
                    })->orWhere(function ($subQuery) use ($userId) {
                        $subQuery->where('auction_type', 'open')
                            ->whereHas('bids', function ($bidQuery) use ($userId) {
                                $bidQuery->where('user_id', $userId)
                                    ->orderBy('created_at', 'desc')
                                    ->limit(1); 
                            });
                    });
                })
                ->get();

            $totalPrice = $wonProducts->sum(function ($product) {
                return $product->getTotalBidAmountAttribute();
            });

            $view->with('categories', $categories)->with('wonProducts', $wonProducts)->with('totalPrice', $totalPrice);
        });
    }
}