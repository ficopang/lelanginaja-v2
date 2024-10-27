@extends('template.generic')

@section('title', 'Manage Products')

@section('content')
    <!-- Start my product Area -->
    <div class="container section">
        <div class="row">
            <div class="col-md-3 d-none d-md-block">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a class="nav-link active" href="#view-products" data-bs-toggle="pill">View Product List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#add-product" data-bs-toggle="pill">Add Product</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header border-bottom d-flex d-md-none">
                        <ul class="nav nav-tabs card-header-tabs nav-gap-x-1" role="tablist">
                            <li class="nav-item"> <a class="nav-link active" id="v-pills-add-product-tab"
                                    href="#add-product" data-bs-toggle="pill" role="tab" aria-controls="add-product"
                                    aria-selected="true"><i class="bx bx-plus"></i></a></li>
                            <li class="nav-item"> <a class="nav-link" id="v-pills-view-product-tab" href="#view-products"
                                    data-bs-toggle="pill" role="tab" aria-controls="v-pills-view-product"
                                    aria-selected="true"><i class="bx bxl-layer"></i></a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade p-2" id="add-product">
                                <h5 class="fw-bold">ADD PRODUCT</h5>
                                <hr>

                                <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="product-name" class="form-label">Product Name</label>
                                        <input type="text" class="form-control" id="product-name" name="product-name"
                                            placeholder="Iphone XR" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="category-select" class="form-label">Select a Category</label>
                                        <select class="form-select" id="category-select" name="category">
                                            <option selected disabled>Select a category</option>

                                            @foreach ($categories as $category)
                                                <option value="{{ $category['id'] }}" style="text-transform: capitalize;">
                                                    {{ str_replace('_', ' ', $category['name']) }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="product-description" class="form-label">Product Description</label>
                                        <textarea class="form-control" id="product-description" name="product-description" rows="3"
                                            placeholder="Iphone XR brand new in box" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="starting-price" class="form-label">Starting Price</label>
                                        <input type="number" min="0" class="form-control" id="starting-price"
                                            name="starting-price" required step="1000" placeholder="4000000">
                                    </div>
                                    <div class="mb-3">
                                        <label for="min-bid-increment" class="form-label">Minimum Bid Increment</label>
                                        <input type="number" class="form-control" id="min-bid-increment"
                                            name="min-bid-increment" min="1000" required step="1000"
                                            placeholder="100000">
                                    </div>
                                    <div class="mb-3">
                                        <label for="min-bid-users" class="form-label">Minimum Bid User(s)</label>
                                        <input type="number" min="1" class="form-control" id="min-bid-users"
                                            name="min-bid-users" value="1" placeholder="5" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="product-image" class="form-label">Product Image</label>
                                        <input type="file" class="form-control" id="product-image"
                                            name="product-image" accept="image/*" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="reset-time" class="form-label">Reset Time (second)</label>
                                        <input type="number" min="30" class="form-control" id="reset-time"
                                            name="reset-time" required step="30" value="30" placeholder="30">
                                    </div>
                                    <div class="mb-3">
                                        <label for="start-time" class="form-label">Start Time</label>
                                        <input type="datetime-local" class="form-control" id="start-time"
                                            name="start-time" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="end-time" class="form-label">End Time</label>
                                        <input type="datetime-local" class="form-control" id="end-time" name="end-time"
                                            required>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Add Product</button>
                                </form>
                            </div>


                            <div class="tab-pane fade show active p-2" id="view-products">
                                <h5 class="fw-bold">VIEW PRODUCT LIST</h5>
                                <hr>
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                {{-- menampilkan error validasi --}}
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="my-items">

                                    <div class="item-list-title">
                                        <div class="row align-items-center">
                                            <div class="col-lg-5 col-md-5 col-12">
                                                <p>Product</p>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-12">
                                                <p>Start Time</p>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-12">
                                                <p>End Time</p>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-12 align-right">
                                                <p>Action</p>
                                            </div>
                                        </div>
                                    </div>


                                    @foreach ($products as $product)
                                        <div class="single-item-list">
                                            <div class="row align-items-center">
                                                <div class="col-lg-5 col-md-5 col-12" data-bs-toggle="collapse"
                                                    data-bs-target="#product-details-{{ $product->id }}"
                                                    class="accordion-toggle">
                                                    <div class="item-image">
                                                        <img src="{{ $product->images()->first() ? asset('storage' . $product->images()->first()->image_url) : 'https://via.placeholder.com/1000x1000' }}"
                                                            alt="{{ $product->name }}" class="object-fit-cover">
                                                        <div class="content">
                                                            <h3 class="title"><a
                                                                    href="javascript:void(0)">{{ $product->name }}</a></h3>
                                                            <span
                                                                class="price">{{ formatRupiah($product->starting_price) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-12">
                                                    <p>{{ $product->start_time }}</p>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-12">
                                                    <p>{{ $product->end_time }}</p>
                                                </div>

                                                <div class="col-lg-3 col-md-3 col-12 align-right">
                                                    <ul class="action-btn">
                                                        {{-- <li><a href="{{ route('products.edit', $product->id) }}"><i class="bx bx-pencil"></i></a></li> --}}

                                                        <li class="border rounded-circle shadow-sm"><a
                                                                href="{{ route('products.edit', $product->id) }}"
                                                                class="text-primary"><i class="bx bx-pencil"></i></a>
                                                        </li>

                                                        <li class="border rounded-circle shadow-sm">
                                                            <a href="{{ route('products.destroy', $product->id) }}"
                                                                class="btn p-0 border-0 text-danger"
                                                                data-confirm-delete="true"><i class="bx bx-trash"></i></a>
                                                        </li>
                                                    </ul>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="collapse" id="product-details-{{ $product->id }}">
                                            <div class="card card-body">
                                                <p class="fw-bold">Product Details:</p>
                                                <ul>
                                                    <li>Description: {{ $product->description }}</li>
                                                    <li>Starting Price: {{ formatRupiah($product->starting_price) }}</li>
                                                    <li>Min Bid Increment: {{ formatRupiah($product->min_bid_increment) }}
                                                    </li>
                                                    <li>Min User: {{ $product->min_bid_users }}</li>
                                                    <li>Reset Time: {{ $product->reset_time }} second(s)</li>
                                                    <li>Start Time: {{ $product->start_time }}</li>
                                                    <li>End Time: {{ $product->end_time }}</li>
                                                    <li>Status: {{ $product->end_time > now() ? 'On Going' : 'Ended' }}
                                                    </li>
                                                    @if ($product->end_time < now())
                                                        @if ($product->bids->count() > 0)
                                                            @if ($product->auction_type == 'close')
                                                                <li>Winner:
                                                                    {{ $product->getHighestBidUser()->first_name . ' ' . $product->getHighestBidUser()->last_name }}
                                                                    ({{ formatRupiah($product->getTotalBidAmountUser($product->getHighestBidUser()->id)) }})
                                                                </li>
                                                            @else
                                                                <li>Winner:
                                                                    {{ $product->bids->last()->user->first_name . ' ' . $product->bids->last()->user->last_name }}
                                                                    ({{ formatRupiah($product->getTotalBidAmountAttribute()) }})
                                                                </li>
                                                            @endif
                                                            @if ($product->transaction && $product->transaction->shipment)
                                                                <li><br><br>
                                                                    Address:<br>
                                                                    To: {{ $product->transaction->shipment->name }}
                                                                    ({{ $product->transaction->shipment->phone_number }})
                                                                    <br>
                                                                    {{ $product->transaction->shipment->address }},
                                                                    {{ $product->transaction->shipment->province }},
                                                                    {{ $product->transaction->shipment->city }},
                                                                    {{ $product->transaction->shipment->country }},
                                                                    {{ $product->transaction->shipment->postal_code }}.
                                                                </li>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach

                                    <!-- Pagination -->
                                    <x-pagination :iterables=$products />
                                    <!--/ End Pagination -->



                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End my product Area -->
@endsection
