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
        $wonProducts = Product::whereHas('bids', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->whereDoesntHave('transaction')
            ->where('end_time', '<', Carbon::now()->addHours(7))
            ->get();

        $totalBidAmount = $wonProducts->sum(function ($product) {
            return $product->getTotalBidAmountAttribute();
        });

        $log = new LogController();
        $recommendations = $log->recommendProducts(auth()->id())->take(3);

        return view('cart.checkout', compact('wonProducts', 'totalBidAmount', 'recommendations'));
    }

    public function saveShippingAddres(Request $request)
    {
        $user = User::find(auth()->id());
        $userId = auth()->id();
        $wonProducts = Product::whereHas('bids', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->whereDoesntHave('transaction')
            ->where('end_time', '<', Carbon::now()->addHours(7))
            ->get();

        $cost = "50";
        $status = "shipped";

        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'phone_number' => 'required',
            'shipping' => 'required',
            'address' => 'required|min:5|max:100',
            'city' => 'required',
            'province' => 'required',
            'country' => 'required',
            'postal_code' => 'required|integer|between:10000,99999',
            'card_holder_name' => 'required',
            'card_number' => 'required|max:16|min:16',
            'exp_month' => 'required|integer|between:1,12',
            'exp_year' => 'required|integer|between:1,9999',
            'cvv' => 'required|integer|between:100,999'
        ]);

        foreach ($wonProducts as $product) {
            $transaction = new Transaction();
            $transaction->buyer_id = $user->id;
            $transaction->seller_id = $product->user_id;
            $transaction->product_id = $product->id;
            $transaction->final_price = $product->getTotalBidAmount();
            $transaction->status = "pending";
            $transaction->save();

            $shippingAddress = new Shipment();
            $shippingAddress->transaction_id = $transaction->id;
            $shippingAddress->firstname = $request->firstname;
            $shippingAddress->lastname = $request->lastname;
            $shippingAddress->phone_number = $request->phone_number;
            $shippingAddress->courier = "JNE";
            $shippingAddress->address = $request->address;
            $shippingAddress->city = $request->city;
            $shippingAddress->province = $request->province;
            $shippingAddress->country = $request->country;
            $shippingAddress->postal_code = $request->postal_code;
            $shippingAddress->cost = $cost;
            $shippingAddress->status = $status;
            $shippingAddress->save();
        }
        return redirect()->route('transaction.index');
    }
}
