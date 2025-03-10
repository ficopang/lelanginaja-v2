<?php

namespace App\Http\Controllers;

use App\Events\PlaceBidEvent;
use App\Models\Bid;
use App\Models\Log;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class BidController extends Controller
{
    public function placeBid(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        // Validate the bid request
        $validator = Validator::make($request->all(), [
            'bid_amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        if ($request->input('bid_amount') == 0 || $request->input('bid_amount') % $product->min_bid_increment != 0) {
            return response()->json(['error' => 'Bid value must be multiply of bid increment'], 400);
        }

        // get latest bid and refund
        $latestBid = $product->bids()->latest('created_at')->first();
        if ($latestBid) {
            $latestBidder = User::find($latestBid->user_id);
            $latestBidder->balance += $product->getTotalBidAmountAttribute();

            if ($latestBid->user_id != auth()->user()->id && auth()->user()->balance < $product->getTotalBidAmountAttribute() + $request->input('bid_amount')) {
                return response()->json(['error' => 'Insufficient balancez'], 400);
            } else if ($latestBid->user_id == auth()->user()->id && $latestBidder->balance < $product->getTotalBidAmountAttribute() + $request->input('bid_amount')) {
                return response()->json(['error' => 'Insufficient balance'], 400);
            }
        }


        // Check if bid time is within 30 seconds of the end time
        $endTime = Carbon::parse($product->end_time);
        $bidTime = Carbon::now();
        $bidTimeDiff = $bidTime->diffInSeconds($endTime);

        if ($bidTime->greaterThan($endTime)) {
            return response()->json(['error' => 'Time limit exceeded'], 400);
        }

        if ($latestBid) {
            $latestBidder->save();
        }

        // deduct user balance
        $user = User::findOrFail(auth()->id());
        // check if logged in user already bid on product
        $user->balance -= $product->getTotalBidAmountAttribute() + $request->input('bid_amount');
        $user->save();

        // Place the bid
        $bid = new Bid();
        $bid->user_id = auth()->id();
        $bid->product_id = $productId;
        $bid->bid_amount = $request->input('bid_amount');
        $bid->save();

        // Update the product's end time
        if ($product->auction_type != 'close' && $bidTimeDiff <= $product->reset_time) {
            $endTime = $bidTime->addSeconds($product->reset_time); // Set the end time to 30 seconds from the current bid time

            $product->end_time = $endTime;
            $product->save();
        }

        $lastBidderFirstName = $product->bids()->latest('created_at')->first() ? $product->bids()->latest('created_at')->first()->user->first_name : null;

        // send event
        if ($product->auction_type != 'closed') {
            broadcast(new PlaceBidEvent(
                roomId: $productId,
                createdAt: $bid->created_at,
                endTime: $endTime,
                lastBidder: $bid->user_id,
                lastBidderName: $lastBidderFirstName,
                bidAmount: $bid->bid_amount,
                currentPrice: $product->getTotalBidAmountAttribute(),
                currentBalance: $user->balance,
            ))->toOthers();
        }

        $logs = new Log([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'action' => 'bid',
        ]);
        $logs->save();

        return response()->json(['message' => 'Bid placed successfully', 'balance' => $user->balance]);
    }
}