<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Product;
use App\Models\Shipment;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function history()
    {
        $id = auth()->user()->id;
        $userTransactions = Transaction::where('buyer_id', $id)->get();
        return view('transaction.history', compact('userTransactions'));
    }

    public function index() {}

    public function checkout()
    {
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

        $totalBidAmount = $wonProducts->sum(function ($product) {
            return $product->getTotalBidAmountAttribute();
        });

        $log = new LogController();
        $recommendations = $log->recommendProducts(auth()->id()) ? $log->recommendProducts(auth()->id())->take(3) : Product::all()->random(3);

        return view('cart.checkout', compact('wonProducts', 'totalBidAmount', 'recommendations'));
    }

    public function saveShippingAddres(Request $request)
    {
        $user = User::find(auth()->id());
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

        $cost = "50";
        $status = "shipped";

        $this->validate($request, [
            'name' => 'required',
            'phone_number' => 'required|numeric',
            'address' => 'required|min:5|max:100',
            'city' => 'required',
            'province' => 'required',
            'country' => 'required',
            'postal_code' => 'required|integer|between:10000,999999',
        ]);

        foreach ($wonProducts as $product) {
            $transaction = new Transaction();
            $transaction->buyer_id = $user->id;
            $transaction->seller_id = $product->user_id;
            $transaction->product_id = $product->id;
            $transaction->final_price = $product->getTotalBidAmountAttribute();
            $transaction->status = "pending";
            $transaction->save();

            $shippingAddress = new Shipment();
            $shippingAddress->transaction_id = $transaction->id;
            $shippingAddress->name = $request->name;
            $shippingAddress->phone_number = $request->phone_number;
            $shippingAddress->address = $request->address;
            $shippingAddress->city = $request->city;
            $shippingAddress->province = $request->province;
            $shippingAddress->country = $request->country;
            $shippingAddress->postal_code = $request->postal_code;
            $shippingAddress->status = $status;
            $shippingAddress->save();
        }
        return redirect()->route('transaction.index');
    }

    public function finish(Request $request)
    {
        $tr = Transaction::find($request->transaction);

        if (!$tr) {
            return back()->with('error', 'Transaction not found');
        }

        $tr->status = "Completed";
        $tr->seller()->increment('balance', $tr->final_price);
        $tr->save();

        return back()->with('success', 'Transaction completed and balance added to seller');
    }
}
