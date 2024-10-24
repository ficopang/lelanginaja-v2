@extends('template.generic')

@section('title', 'Product List')

@section('custom-header')
    <style>
        .product-search .search-input {
            position: relative;
        }

        .product-search .search-input input {
            width: 100%;
            height: 45px;
            border: 1px solid #e2e2e2;
            background-color: #fff;
            color: #000;
            border-radius: 0;
            padding: 0 15px;
            -webkit-transition: all 0.3s linear;
            transition: all 0.3s linear;
            font-size: 14px;
        }

        .product-search .search-btn button {
            background-color: #0167f3;
            color: #fff;
            width: 45px;
            height: 45px;
            padding: 0;
            border: 0;
            border-radius: 0 4px 4px 0;
            margin-left: -2px;
            -webkit-transition: all 0.4s ease;
            transition: all 0.4s ease;
            font-size: 18px;
        }
    </style>
@endsection

@section('content')
    <!-- Start Product Grids -->
    <section class="product-grids section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-12">
                    <!-- Start Product Sidebar -->
                    <div class="product-sidebar">
                        <!-- Start Single Widget -->
                        <div class="single-widget product-search">
                            <h3 class="mb-2">Search Product</h3>
                            <form id="searchForm" class="d-flex" action="{{ route('products.search') }}" method="GET">
                                <div class="search-input">
                                    <input type="text" id="search-query" name="query" placeholder="Search">
                                </div>
                                <div class="search-btn">
                                    <button type="submit"><i class="bx bx-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <!-- End Single Widget -->
                        <!-- Start Single Widget -->
                        <div class="single-widget">
                            <h3 class="mb-2">All Categories</h3>
                            <ul class="list">
                                @foreach ($categories as $category)
                                    <li>
                                        <a href="/search?category_id={{ $category->id }}"
                                            onclick="updateCategory({{ $category->id }}); return false;"
                                            class="{{ app('request')->input('category_id') == $category->id ? 'text-primary' : '' }}"
                                            style="text-transform: capitalize;">{{ str_replace('_', ' ', $category->name) }}
                                        </a><span>({{ $category->products()->count() }})</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- End Single Widget -->
                    </div>
                    <!-- End Product Sidebar -->
                </div>
                <div class="col-lg-9 col-12">
                    <div class="product-grids-head">
                        <div class="product-grid-topbar">
                            <div class="row align-items-center">
                                <div class="col-lg-9 col-md-8 col-12">
                                    <h6 class="total-show-product">Total: <span> {{ $products->count() }} items</span></h6>
                                    <div class="product-sorting">
                                        <label for="sorting">Sort by:</label>
                                        <select class="form-control" id="sorting" name="sort_by"
                                            onchange="updateSortingAndRedirect()">
                                            <option value="popularity"
                                                {{ app('request')->input('sort_by') == 'popularity' ? 'selected' : '' }}>
                                                Popularity</option>
                                            <option value="low_high_price"
                                                {{ app('request')->input('sort_by') == 'low_high_price' ? 'selected' : '' }}>
                                                Low - High Price</option>
                                            <option value="high_low_price"
                                                {{ app('request')->input('sort_by') == 'high_low_price' ? 'selected' : '' }}>
                                                High - Low Price</option>
                                            <option value="a_z_order"
                                                {{ app('request')->input('sort_by') == 'a_z_order' ? 'selected' : '' }}>
                                                A - Z Order</option>
                                            <option value="z_a_order"
                                                {{ app('request')->input('sort_by') == 'z_a_order' ? 'selected' : '' }}>
                                                Z - A Order</option>
                                        </select>
                                        <h3 class="total-show-product">Showing: <span>{{ $products->firstItem() }} -
                                                {{ $products->lastItem() }} items</span></h3>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-12">
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <button class="nav-link active" id="nav-grid-tab" data-bs-toggle="tab"
                                                data-bs-target="#nav-grid" type="button" role="tab"
                                                aria-controls="nav-grid" aria-selected="true"><i
                                                    class="bx bx-grid-alt"></i></button>
                                            <button class="nav-link" id="nav-list-tab" data-bs-toggle="tab"
                                                data-bs-target="#nav-list" type="button" role="tab"
                                                aria-controls="nav-list" aria-selected="false"><i
                                                    class="bx bx-list-ul"></i></button>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-grid" role="tabpanel"
                                aria-labelledby="nav-grid-tab">
                                <div class="row gx-4 gx-lg-4 row-cols-2 row-cols-md-3 row-cols-xl-4">
                                    @foreach ($products as $product)
                                        <div class="col">
                                            <x-product-card :product=$product />
                                        </div>
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <!-- Pagination -->
                                        <div class="pagination left">
                                            <ul class="pagination-list">
                                                @if ($products->onFirstPage())
                                                    <!-- No previous page available -->
                                                    <li class="disabled">
                                                        <span><i class="bx bx-chevron-left"></i></span>
                                                    </li>
                                                @else
                                                    <!-- Previous page available -->
                                                    <li>
                                                        <a
                                                            href="{{ $products->previousPageUrl() . '&' . http_build_query(request()->except('page')) }}">
                                                            <i class="bx bx-chevron-left"></i>
                                                        </a>
                                                    </li>
                                                @endif

                                                @foreach ($products->links()->elements[0] as $page => $url)
                                                    <li class="{{ $products->currentPage() == $page ? 'active' : '' }}">
                                                        <a
                                                            href="{{ $url . '&' . http_build_query(request()->except('page')) }}">{{ $page }}</a>
                                                    </li>
                                                @endforeach

                                                @if ($products->hasMorePages())
                                                    <!-- Next page available -->
                                                    <li>
                                                        <a
                                                            href="{{ $products->nextPageUrl() . '&' . http_build_query(request()->except('page')) }}">
                                                            <i class="bx bx-chevron-right"></i>
                                                        </a>
                                                    </li>
                                                @else
                                                    <!-- No next page available -->
                                                    <li class="disabled">
                                                        <span><i class="bx bx-chevron-right"></i></span>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                        <!--/ End Pagination -->
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-list" role="tabpanel" aria-labelledby="nav-list-tab">
                                <div class="row">
                                    @foreach ($products as $product)
                                        <div class="col-lg-12 col-md-12 col-12">
                                            <!-- Start Single Product -->
                                            <div class="single-product p-0">
                                                <div class="title bg-primary pt-2 fw-bold text-center">
                                                    <a class="fs-6 d-inline-block text-white overflow-hidden"
                                                        href="/product/{{ $product->id }}">{{ $product->name }}</a>
                                                </div>
                                                <div class="row align-items-center">
                                                    <div class="col-lg-4 col-md-4 col-12">
                                                        <div
                                                            class="product-image ps-2 d-flex align-items-center justify-content-center">
                                                            <img src="{{ $product->images()->first() ? asset('storage' . $product->images()->first()->image_url) : 'https://via.placeholder.com/1000x1000' }}"
                                                                alt="{{ $product->name }}" style="width: 170px">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-12">
                                                        <div class="product-info p-0">
                                                            <div class="row p-2 mt-2">
                                                                <div class="col">
                                                                    <p class="text-center">Type</p>
                                                                    <!-- Sale badge-->
                                                                    <div
                                                                        class="d-flex justify-content-center align-items-center">
                                                                        <div
                                                                            class="badge {{ $product->auction_type === 'close' ? 'bg-secondary' : 'bg-success' }} text-white text-capitalize">
                                                                            {{ $product->auction_type }} bid
                                                                        </div>
                                                                    </div>
                                                                    <p class="text-center">Seller</p>
                                                                    <div class="text-center text-dark">
                                                                        {{ $product->user->first_name }}
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <p class="text-center">Current Bid</p>
                                                                    <div class="price text-center">
                                                                        <span
                                                                            class="fs-6">{{ formatRupiah($product->getTotalBidAmountAttribute()) }}</span>
                                                                    </div>
                                                                    <p class="text-center">Time Left</p>
                                                                    <div class="countdown text-center text-danger"
                                                                        data-end-time="{{ $product->end_time }}">
                                                                        <span>{{ $product->end_time }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="d-flex align-items-center justify-content-center p-2 gap-1">
                                                                @auth
                                                                    <form action="{{ route('products.watchlist', $product) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <button
                                                                            class="d-flex align-items-center justify-content-center gap-1 btn {{ auth()->user()->watchlists->contains('product_id', $product->id)? 'btn-dark text-white': 'btn-outline-dark' }}""><i
                                                                                class="bx bx-low-vision"></i> Watchlist</button>
                                                                    </form>
                                                                @endauth
                                                                <a href="/product/{{ $product->id }}"
                                                                    class="btn btn-primary w-100">Bid</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Single Product -->
                                        </div>
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <!-- Pagination -->
                                        <div class="pagination left">
                                            <ul class="pagination-list">
                                                @if ($products->onFirstPage())
                                                    <!-- No previous page available -->
                                                    <li class="disabled">
                                                        <span><i class="bx bx-chevron-left"></i></span>
                                                    </li>
                                                @else
                                                    <!-- Previous page available -->
                                                    <li>
                                                        <a
                                                            href="{{ $products->previousPageUrl() . '&' . http_build_query(request()->except('page')) }}">
                                                            <i class="bx bx-chevron-left"></i>
                                                        </a>
                                                    </li>
                                                @endif

                                                @foreach ($products->links()->elements[0] as $page => $url)
                                                    <li class="{{ $products->currentPage() == $page ? 'active' : '' }}">
                                                        <a
                                                            href="{{ $url . '&' . http_build_query(request()->except('page')) }}">{{ $page }}</a>
                                                    </li>
                                                @endforeach

                                                @if ($products->hasMorePages())
                                                    <!-- Next page available -->
                                                    <li>
                                                        <a
                                                            href="{{ $products->nextPageUrl() . '&' . http_build_query(request()->except('page')) }}">
                                                            <i class="bx bx-chevron-right"></i>
                                                        </a>
                                                    </li>
                                                @else
                                                    <!-- No next page available -->
                                                    <li class="disabled">
                                                        <span><i class="bx bx-chevron-right"></i></span>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                        <!--/ End Pagination -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Product Grids -->
@endsection

@section('custom-js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("searchForm").addEventListener("submit", function(event) {
                event.preventDefault(); // Prevent the default form submission

                var currentUrl = window.location.href;
                var newUrl;
                var query = document.getElementById('search-query').value.trim();

                // Encode the search query to make sure it's URL-safe
                var encodedQuery = encodeURIComponent(query);

                // Regular expression to match the query parameter in the URL
                var regex = /([\?&])query=([^&]*)/;
                if (regex.test(currentUrl)) {
                    // If the query parameter already exists, replace its value
                    newUrl = currentUrl.replace(regex, '$1query=' + encodedQuery);
                } else {
                    // If the query parameter doesn't exist, append it to the URL
                    newUrl = currentUrl + (currentUrl.indexOf('?') !== -1 ? '&' : '?') + 'query=' +
                        encodedQuery;
                }

                // Redirect to the new URL
                window.location.href = newUrl;
            });
        });


        function updateSortingAndRedirect() {
            var currentUrl = window.location.href;
            var newUrl;
            var sortBy = document.getElementById('sorting').value;

            // Check if sort_by parameter already exists in the URL
            if (currentUrl.indexOf('sort_by=') !== -1) {
                newUrl = currentUrl.replace(/(sort_by=)[^\&]+/, '$1' + sortBy);
            } else {
                // Append sort_by parameter to the URL
                newUrl = currentUrl + (currentUrl.indexOf('?') !== -1 ? '&' : '?') + 'sort_by=' + sortBy;
            }

            // Redirect to the new URL
            window.location.href = newUrl;
        }

        function updateCategory(categoryId) {
            var currentUrl = window.location.href;
            var newUrl;

            // Check if category_id parameter already exists in the URL
            if (currentUrl.indexOf('category_id=') !== -1) {
                newUrl = currentUrl.replace(/(category_id=)[^\&]+/, '$1' + categoryId);
            } else {
                // Append category_id parameter to the URL
                newUrl = currentUrl + (currentUrl.indexOf('?') !== -1 ? '&' : '?') + 'category_id=' + categoryId;
            }

            // Update the URL without reloading the page
            window.location.href = newUrl;
        }
    </script>
    <script>
        // Countdown Timers
        var countdowns = document.querySelectorAll('.countdown');

        countdowns.forEach(function(countdown) {
            var endTime = new Date(countdown.dataset.endTime).getTime();
            var now = new Date().getTime();
            var timeRemaining = endTime - now;

            function updateCountdown() {
                var days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
                var hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

                // Format the countdown timer
                var formattedCountdown = days.toString().padStart(2, '0') + ':' +
                    hours.toString().padStart(2, '0') + ':' +
                    minutes.toString().padStart(2, '0') + ':' +
                    seconds.toString().padStart(2, '0');

                countdown.innerHTML = formattedCountdown;

                if (timeRemaining <= 0) {
                    countdown.innerHTML = "Auction Ended";
                } else {
                    timeRemaining -= 1000;
                    setTimeout(updateCountdown, 1000);
                }
            }
            updateCountdown();
        });
    </script>
@endsection
