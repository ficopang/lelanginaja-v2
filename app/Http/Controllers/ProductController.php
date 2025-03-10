<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Category;
use App\Models\Log;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Watchlist;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $products = Product::where('user_id', Auth::user()->id)->paginate(4);

        $title = 'Delete Product';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('product.manage', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product-name' => 'required',
            'category' => 'required',
            'product-description' => 'required',
            'starting-price' => 'required|numeric|min:0',
            'min-bid-increment' => 'required|numeric|min:1000',
            'min-bid-users' => 'required|numeric|min:1',
            'product-image' => 'required|image',
            'reset-time' => 'required|numeric|min:30',
            'start-time' => 'required|date',
            'end-time' => 'required|date|after:start-time',
        ]);

        $product = new Product();
        $product->name = $validatedData['product-name'];
        $product->user_id = auth()->id();
        $product->category_id = $validatedData['category'];
        $product->description = $validatedData['product-description'];
        $product->starting_price = $validatedData['starting-price'];
        $product->auction_type = 'open';
        $product->min_bid_increment = $validatedData['min-bid-increment'];
        $product->min_bid_users = $validatedData['min-bid-users'];

        $product->reset_time = $validatedData['reset-time'];
        $product->start_time = $validatedData['start-time'];
        $product->end_time = $validatedData['end-time'];

        $product->save();

        if ($request->hasFile('product-image')) {
            $image = $request->file('product-image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('product-images', $imageName, 'public');
            $image = new ProductImage();
            $image->product_id = $product->id;
            $image->image_url = "/" . $imagePath;
            $image->save();
            // $product->image_url = "/" . $imagePath;
        }

        Alert::success('Success', 'Product added successfully');

        return redirect()->route('products.index')->with('success', 'Product added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $bids = Bid::where('product_id', '=', $product->id)->paginate(10);

        $logs = new Log([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'action' => 'view',
        ]);
        $logs->save();

        return view('product.product-details', compact('product', 'bids'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'product-name' => 'required',
            'category' => 'required',
            'product-description' => 'required',
            'starting-price' => 'required|numeric|min:0',
            'min-bid-increment' => 'required|numeric|min:1000',
            'min-bid-users' => 'required|numeric|min:1',
            'product-image' => 'image',
            'reset-time' => 'required|numeric|min:30',
            'start-time' => 'required|date',
            'end-time' => 'required|date|after:start-time',
        ]);

        $product->name = $request->input('product-name');
        $product->category_id = $request->input('category');
        $product->description = $request->input('product-description');
        $product->starting_price = $request->input('starting-price');
        $product->min_bid_increment = $request->input('min-bid-increment');
        $product->min_bid_users = $request->input('min-bid-users');

        $product->reset_time = $validatedData['reset-time'];
        $product->start_time = $validatedData['start-time'];
        $product->end_time = $validatedData['end-time'];

        $product->save();

        if ($request->hasFile('product-image')) {
            $image = $request->file('product-image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('product-images', $imageName, 'public');
            $image = new ProductImage();
            $image->product_id = $product->id;
            $image->image_url = "/" . $imagePath;
            $image->save();
            // $product->image_url = "/" . $imagePath;
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->logs()->delete();
        $product->transaction ? $product->transaction->report->delete() : null;
        $product->transaction()->delete();
        $product->bids()->delete();
        $product->images()->delete();
        $product->watchlists()->delete();
        $product->reports()->delete();
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }

    public function compare(Request $request)
    {
        $product1 = Product::find($request->input('product1'));
        $product2 = Product::find($request->input('product2'));

        return view('product.compare', compact('product1', 'product2'));
    }

    public function searchSuggestions(Request $request)
    {
        $query = $request->input('query');
        $suggestions = Product::where('name', 'LIKE', "%{$query}%")->take(5)->get();

        return response()->json($suggestions);
    }
}
