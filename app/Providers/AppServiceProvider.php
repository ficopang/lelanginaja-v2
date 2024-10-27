<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
                    $query->where(function ($q) use ($userId) {
                        // Condition for closed auction type: check if the user has the highest bid
                        $q->where('auction_type', 'close')
                            ->whereHas('bids', function ($subQuery) use ($userId) {
                                $subQuery->select(DB::raw('SUM(bid_amount) as total_bid'))
                                    ->where('user_id', $userId)
                                    ->groupBy('user_id', 'product_id')
                                    ->orderBy('total_bid', 'desc')
                                    ->limit(1);
                            });
                    })
                        ->orWhere(function ($q) use ($userId) {
                            // Condition for open auction type: check if the user placed the last bid
                            $q->where('auction_type', 'open')
                                ->whereHas('bids', function ($subQuery) use ($userId) {
                                    $subQuery->where('user_id', $userId)
                                        ->orderBy('created_at', 'desc')
                                        ->limit(1); // Last bid by user
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