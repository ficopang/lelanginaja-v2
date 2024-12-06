<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Watchlist;
use Database\Factories\Ecommerce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            if (Auth::user()->isAdmin) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $request->validate([
            'firstname' => 'required|alpha',
            'lastname' => 'required|alpha',
            'email' => 'required|email|unique:users',
            'phone' => 'required|numeric|min:10',
            'address' => 'required',
            'password' => 'required|alpha_num|min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'required'
        ]);

        $user = new User();
        $user->first_name = $request->firstname;
        $user->last_name = $request->lastname;
        $user->email = $request->email;
        $user->phone_number = $request->phone;
        $user->balance = 1000000;
        $user->address = $request->address;
        $user->password = Hash::make($request->password);
        $user->save();

        // add dummy chats
        $users = DB::table('users')->pluck('id')->toArray();
        for ($i = 0; $i < 5; $i++) {
            $senderId = $user->id;
            $receiverId = fake()->randomElement($users);

            // Make sure sender and receiver are different users
            while ($senderId === $receiverId) {
                $receiverId = fake()->randomElement($users);
            }

            DB::table('chats')->insert([
                'sender_id' => $senderId,
                'receiver_id' => $receiverId,
                'message' => fake()->sentence,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        for ($i = 0; $i < 5; $i++) {
            $senderId = fake()->randomElement($users);
            $receiverId = $user->id;

            // Make sure sender and receiver are different users
            while ($senderId === $receiverId) {
                $receiverId = fake()->randomElement($users);
            }

            DB::table('chats')->insert([
                'sender_id' => $senderId,
                'receiver_id' => $receiverId,
                'message' => fake()->sentence,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // add dummy products
        for ($i = 0; $i < 5; $i++) {
            $users = DB::table('users')->pluck('id')->toArray();
            $ecommerce = new Ecommerce(fake());

            $categoryMap = [
                "electronic" => [
                    'television' => $ecommerce->television(),
                    'mobile_phone' => $ecommerce->mobilePhone(),
                    'laptop' => $ecommerce->laptop(),
                    'camera' => $ecommerce->camera(),
                ],
                "art" => [
                    'guitar' => $ecommerce->guitar(),
                    'piano' => $ecommerce->piano(),
                    'painting' => $ecommerce->painting(),
                ],
                "automotive" => [
                    'car' => $ecommerce->car(),
                    'motorcycle' => $ecommerce->motorcycle(),
                ],
                "fashion" => [
                    'shirt' => $ecommerce->shirt(),
                    'jean' => $ecommerce->jean(),
                    'shoe' => $ecommerce->shoes(),
                ],
                "book" => [
                    'novel' => $ecommerce->novel(),
                    'lesson' => $ecommerce->lesson(),
                ],
            ];

            $randomCategoryKey = array_rand($categoryMap);
            $randomCategoryItems = $categoryMap[$randomCategoryKey];
            $randomSubItemKey = array_rand($randomCategoryItems);
            $randomSubItem = $randomCategoryItems[$randomSubItemKey];

            $imagePath = "public/{$randomCategoryKey}s/{$randomSubItemKey}s";
            $imageFiles = Storage::files($imagePath);
            $imageUrl = str_replace('/storage', '', Storage::url(fake()->randomElement($imageFiles)));

            //eloquent
            $product = new Product();
            $product->user_id = $user->id;
            $product->category_id = Category::where('name', ucfirst($randomCategoryKey))->first()->id;
            $product->name = $randomSubItem;
            $product->description = fake()->paragraph;
            $product->starting_price = fake()->numberBetween(10, 1000) * 1000;
            $product->auction_type = fake()->randomElement(['open', 'close']);
            $product->min_bid_increment = fake()->numberBetween(1, 100) * 1000;
            $product->min_bid_users = fake()->numberBetween(1, 3);
            $product->reset_time = 30;
            $product->start_time = fake()->dateTimeBetween('now', '+1 week');
            $product->end_time = fake()->dateTimeBetween('+1 week', '+2 weeks');
            $product->save();

            DB::table('product_images')->insert([
                'product_id' => $product->id,
                'image_url' => $imageUrl,
            ]);

            if ($i < 2) {
                $product->user_id = fake()->randomElement($users);
                $product->end_time = now();
                $product->save();

                $bids = new Bid();
                $bids->user_id = $user->id;
                $bids->product_id = $product->id;
                $bids->bid_amount = $product->min_bid_increment;
                $bids->save();
            }
        }

        // add dummy transactions
        $products = DB::table('products')->pluck('id')->toArray();
        for ($i = 0; $i < 2; $i++) {
            $buyerId = $user->id;
            $sellerId = fake()->randomElement($users);
            $productId = fake()->randomElement($products);
            $finalPrice = fake()->numberBetween(10000, 1000000);
            $status = fake()->randomElement(['Completed', 'Pending', 'Cancelled']);

            DB::table('transactions')->insert([
                'buyer_id' => $buyerId,
                'seller_id' => $sellerId,
                'product_id' => $productId,
                'final_price' => $finalPrice,
                'status' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // add dummyy watchlist
        $watchlistItems = Product::all()->random(1); // Add 3 random products to the user's watchlist
        foreach ($watchlistItems as $product) {
            //eloquent
            $watchlist = new Watchlist();
            $watchlist->user_id = $user->id;
            $watchlist->product_id = $product->id;
            $watchlist->save();
        }

        // add winning products


        return redirect()->route('login')->withSuccess('Register successfully!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
