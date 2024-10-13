@extends('template.generic')

@section('title', 'Watchlists')

@section('content')
    <!-- Shopping Cart -->
    <div class="container shopping-cart section">
        <div class="card">
            <div class="card-body">
                <div class="cart-list-head">
                    <!-- Cart List Title -->
                    <div class="cart-list-title">
                        <div class="row">
                            <div class="col-lg-1 col-md-1 col-12">
                            </div>
                            <div class="col-lg-4 col-md-3 col-12">
                                <p>Product Name</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p>Price</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p>Latest Bid</p>
                            </div>
                            <div class="col-lg-1 col-md-2 col-12">
                                <p>Action</p>
                            </div>
                        </div>
                    </div>
                    <!-- End Cart List Title -->
                    @foreach ($watchlists as $watchlistItem)
                        <!-- Cart Single List list -->
                        <div class="cart-single-list">
                            <div class="row align-items-center">
                                <div class="col-lg-1 col-md-1 col-12">
                                    <a href="/product/{{ $watchlistItem->product->id }}"><img
                                            src="{{ $watchlistItem->product->images()->first() ? asset('storage' . $watchlistItem->product->images()->first()->image_url) : 'https://via.placeholder.com/1000x1000' }}"
                                            alt="#"></a>
                                </div>
                                <div class="col-lg-4 col-md-3 col-12">
                                    <h5 class="product-name"><a href="/product/{{ $watchlistItem->product->id }}">
                                            {{ $watchlistItem->product->name }}</a></h5>
                                </div>
                                <div class="col-lg-2 col-md-2 col-12">
                                    <p>{{ formatRupiah($watchlistItem->product->getTotalBidAmountAttribute()) }}</p>
                                </div>
                                <div class="col-lg-2 col-md-2 col-12">
                                    <p>{{ $watchlistItem->product->bids()->latest('created_at')->first() ? $watchlistItem->product->bids()->latest('created_at')->first()->user->first_name : '-' }}
                                    </p>
                                </div>
                                <div class="col-lg-1 col-md-2 col-12">
                                    <form action="{{ route('products.watchlist', $watchlistItem->product->id) }}"
                                        method="POST">
                                        @csrf
                                        <button class="remove-item"><i class="lni lni-close"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End Single List list -->
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Start Recommendation Product Area -->
    @if (count($recommendations) > 0)
        <section class="trending-product section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h2>You might like</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($recommendations as $recommend)
                        <div class="col-lg-3 col-md-6 col-12 d-flex align-items-stretch">
                            <x-product-card :product="$recommend" />
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- End Recommendation Product Area -->
    @endif
    <!--/ End Shopping Cart -->
@endsection
