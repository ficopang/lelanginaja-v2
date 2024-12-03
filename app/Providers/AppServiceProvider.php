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

        // force URLs to 'https'
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        };

        // Use the `view` method to specify the template(s) you want to pass data to
        View::composer('template.generic', function ($view) {
            $categories = Category::all();
            $userId = auth()->id();
            $joinedAuctionProducts = Product::whereHas('bids', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
                ->whereDoesntHave('transaction')
                ->where('end_time', '<', Carbon::now()->addHours(7))
                ->get();

            // Get the products where auction_type is 'open'
            $openAuctionProducts = $joinedAuctionProducts->filter(function ($product) use ($userId) {
                return $product->auction_type === 'open' && $product->bids()->latest()->first()->user_id === $userId;
            });

            // Get the products where auction_type is not 'open'
            $closedAuctionProducts = $joinedAuctionProducts->filter(function ($product) use ($userId) {
                return $product->auction_type === 'close' && $product->getHighestBidUser()->id === $userId;
            });


            $wonProducts = $openAuctionProducts->merge($closedAuctionProducts)->unique('id');

            $totalPrice = $wonProducts->sum(function ($product) {
                return $product->getTotalBidAmountAttribute();
            });

            $view->with('categories', $categories)->with('wonProducts', $wonProducts)->with('totalPrice', $totalPrice);
        });
    }
}
