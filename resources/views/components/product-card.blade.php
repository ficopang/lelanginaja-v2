<!-- Start Single Product -->
<div class="single-product w-100 p-0">
    <div class="title bg-primary pt-2 fw-bold text-center">
        <a class="fs-6 d-inline-block text-white text-truncate" style="max-width: 80%;"
            href="/product/{{ $product->id }}">{{ $product->name }}</a>
    </div>
    <div class="product-image p-0 m-0">
        <!-- Sale badge-->
        <div class="badge {{ $product->auction_type === 'close' ? 'bg-secondary' : 'bg-success' }} text-white position-absolute text-capitalize"
            style="bottom: 1rem; right: 0.5rem; z-index:100;">
            {{ $product->auction_type }} bid
        </div>
        <img style="height: 200px; width: 100%; object-fit: cover;"
            src="{{ $product->images()->first() ? asset('storage' . $product->images()->first()->image_url) : 'https://via.placeholder.com/1000x1000' }}"
            alt="{{ $product->name }}" />
    </div>
    <div class="product-info p-0 pt-1">
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
                            class="bx bx-low-vision"></i></button>
                </form>
            @endauth
            <a href="/product/{{ $product->id }}" class="btn btn-primary w-100">Bid</a>
        </div>
    </div>
</div>
<!-- End Single Product -->
