@extends('template.generic')

@section('title', 'Manage Product')

@section('content')
    <!-- Start my product Area -->
    <div class="container section">
        <div class="card">
            <div class="card-body">

                <h3 class="fw-bold mb-2">Update Product</h3>

                <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="product-name" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="product-name" name="product-name"
                            value="{{ $product->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="category-select" class="form-label">Select a Category</label>
                        <select class="form-select" id="category-select" name="category">
                            <option selected disabled>Select a category</option>
                            @foreach ($categories as $category)
                                <option
                                    value="{{ $category['id'] }}"{{ $category['id'] == $product->category_id ? 'selected' : '' }}>
                                    {{ $category['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="product-description" class="form-label">Product Description</label>
                        <textarea class="form-control" id="product-description" name="product-description" rows="3" required>{{ $product->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="starting-price" class="form-label">Starting Price</label>
                        <input type="number" min="0" class="form-control" id="starting-price" name="starting-price"
                            value="{{ $product->starting_price }}" required step="1000">
                    </div>
                    <div class="mb-3">
                        <label for="min-bid-increment" class="form-label">Minimum Bid Increment</label>
                        <input type="number" min="1000" class="form-control" id="min-bid-increment"
                            name="min-bid-increment" value="{{ $product->min_bid_increment }}" required step="1000">
                    </div>
                    <div class="mb-3">
                        <label for="min-bid-users" class="form-label">Minimum Bid Users</label>
                        <input type="number" min="1" class="form-control" id="min-bid-users" name="min-bid-users"
                            value="{{ $product->min_bid_users }}" required step="1">
                    </div>
                    <div class="mb-3">
                        <label for="product-image" class="form-label">Product Image</label>
                        <input type="file" class="form-control" id="product-image" name="product-image" accept="image/*"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="reset-time" class="form-label">Reset Time</label>
                        <input type="number" min="0" class="form-control" id="reset-time" name="reset-time"
                            value="{{ $product->reset_time }}" required step="30">
                    </div>
                    <div class="mb-3">
                        <label for="start-time" class="form-label">Start Time</label>
                        <input type="datetime-local" class="form-control" id="start-time" name="start-time"
                            value="{{ $product->start_time }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="end-time" class="form-label">End Time</label>
                        <input type="datetime-local" class="form-control" id="end-time" name="end-time"
                            value="{{ $product->end_time }}" required>
                    </div>

                    <div style="margin-top: 40px;">
                        <button type="submit" class="btn btn-primary">Update Product</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <!-- End my product Area -->
@endsection
