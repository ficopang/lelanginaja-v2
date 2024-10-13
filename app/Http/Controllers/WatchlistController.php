<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Product;
use App\Models\Watchlist;
use Illuminate\Http\Request;

class WatchlistController extends Controller
{
    public function index()
    {
        $watchlists = Auth()->user()->watchlists;

        // $recommendations = Product::all()->random(4);
        $log = new LogController();
        $recommendations = $log->recommendProducts(auth()->id())->take(4);

        return view('account.watchlist', compact('watchlists', 'recommendations'));
    }

    public function toggle(Product $product)
    {
        $watchlist = Watchlist::where('user_id', auth()->user()->id)
            ->where('product_id', $product->id)
            ->first();

        if ($watchlist) {
            $watchlist->delete();
        } else {
            $watchlist = new Watchlist();
            $watchlist->user_id = auth()->id();
            $watchlist->product_id = $product->id;
            $watchlist->save();

            $logs = new Log([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'action' => 'watchlist',
            ]);
            $logs->save();
        }

        return back();
    }
}
