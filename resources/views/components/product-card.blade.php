<!-- Start Single Product -->
<div class="single-product p-0">
    <div class="title bg-primary pt-2 fw-bold text-center">
        <a class="fs-6 d-inline-block text-white text-truncate" style="max-width: 12vw;"
            href="/product/{{ $product->id }}">{{ $product->name }}</a>
    </div>
    {{-- <a href="{{ route('products.search', ['category_id' => $product->category_id]) }}"> <span class="category"><i
                class="lni lni-tag"></i>
            {{ $product->category->name }}</span></a> --}}
    <div class="product-image px-4">
        <!-- Sale badge-->
        <div class="badge {{ $product->auction_type === 'close' ? 'bg-secondary' : 'bg-success' }} text-white position-absolute text-capitalize"
            style="bottom: 0.5rem; right: 0.5rem">
            {{ $product->auction_type }} bid
        </div>
        <img src="{{ $product->images()->first() ? asset('storage' . $product->images()->first()->image_url) : 'https://via.placeholder.com/1000x1000' }}"
            alt="{{ $product->name }}" />
    </div>
    <div class="product-info p-0">
        <p class="text-center">Current Bid</p>
        <div class="price text-center">
            <span class="fs-6">{{ formatRupiah($product->total_bid_amount) }}</span>
        </div>
        <p class="text-center">Time Left</p>
        <div class="countdown text-center text-danger" data-end-time="{{ $product->end_time }}">
            <span>{{ $product->end_time }}</span>
        </div>
        <div class="d-flex align-items-center justify-content-center p-2 gap-1">
            @auth
                <form action="{{ route('products.watchlist', $product) }}" method="POST">
                    @csrf
                    <button
                        class="btn {{ auth()->user()->watchlists->contains('product_id', $product->id)? 'btn-dark text-white': 'btn-outline-dark' }}""><i
                            class="lni
                    lni-eye"></i></button>
                </form>
            @endauth
            <a href="/product/{{ $product->id }}" class="btn btn-primary w-100">Bid</a>
        </div>
    </div>
</div>
<!-- End Single Product -->


{{-- <div class="single-product">
    <h4 class="title mt-2 mx-2 fw-bold text-center">
        <a class="d-inline-block text-truncate" style="max-width: 150px;"
            href="/product/{{ $offers->id }}">{{ $offers->name }}</a>
    </h4>
    <div class="product-image">
        <img src="{{ asset('storage' . $offers->image_url) }}" alt="#" />
    </div>
    <div class="product-info">
        <span class="category">{{ str_replace('_', ' ', $offers->category->name) }}</span>
        <div class="countdown text-center text-danger fs-5" data-end-time="{{ $offers->end_time }}">
            <h6>{{ $offers->end_time }}</h6>
        </div>
        <div class="price">
            <span>{{ 'Rp' . $offers->total_bid_amount }}</span>
        </div>
        <div class="last-bidder">
            <span
                class="text-dark text-muted">{{ $offers->bids()->latest('created_at')->first() ? 'Bidder: ' . $offers->bids()->latest('created_at')->first()->user->first_name : '' }}</span>
        </div>
        <div class="button mt-auto">
            <a href="/product/{{ $tp->id }}" class="btn w-100">Bid</a>
        </div>
    </div>
</div> --}}
