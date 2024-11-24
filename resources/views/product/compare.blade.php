@extends('template.generic')

@section('title', 'Compare Product')

@section('custom-header')
    <style>
        .compare-search .search-input {
            position: relative;
        }

        .compare-search .search-input input {
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

        .compare-search .search-btn button {
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

        .suggestions-box {
            border: 1px solid #ccc;
            background-color: #fff;
            position: absolute;
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
        }

        .suggestion-item {
            padding: 10px;
            cursor: pointer;
        }

        .suggestion-item:hover {
            background-color: #f0f0f0;
        }
    </style>
@endsection

@section('content')
    <!-- Report -->
    <div class="container section text-center">
        <div class="card pt-4">
            <div class="card-body">
                <div class="row mb-5">
                    <form id="search" class="d-flex" action="{{ route('products.compare') }}" method="GET">
                        <div class="col-lg-2 col"></div>
                        <div class="col-lg-5 col">
                            <div>Product 1</div>
                            <div class="d-flex compare-search mx-2">
                                <div class="search-input w-100">
                                    <input type="text" id="query1" placeholder="Search">
                                    <input type="text" id="selectedProduct1" name="product1"
                                        value="{{ app('request')->input('product1') }}" hidden>
                                    <div id="suggestions1" class="suggestions-box"></div>
                                </div>
                                <div class="search-btn">
                                    <button type="submit"><i class="bx bx-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col">
                            <div>Product 2</div>
                            <div class="d-flex compare-search mx-2">
                                <div class="search-input w-100">
                                    <input type="text" id="query2" placeholder="Search">
                                    <input type="text" id="selectedProduct2" name="product2"
                                        value="{{ app('request')->input('product2') }}" hidden>
                                    <div id="suggestions2" class="suggestions-box"></div>
                                </div>
                                <div class="search-btn">
                                    <button type="submit"><i class="bx bx-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-2 col">Product</div>
                    <div class="col-lg-5 col">
                        @if ($product1)
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="me-3">
                                    <img src="{{ $product1->images()->first() ? asset('storage' . $product1->images()->first()->image_url) : 'https://via.placeholder.com/1000x1000' }}"
                                        alt="{{ $product1->name }}" style="max-width: 100px">
                                </div>
                                <div class="d-flex flex-column">
                                    <h4><a href="/product/{{ $product1->id }}">
                                            {{ $product1->name }}</a></h4>
                                </div>
                            </div>
                        @else
                            -
                        @endif
                    </div>
                    <div class="col-lg-5 col">
                        @if ($product2)
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="me-3">
                                    <img src="{{ $product2->images()->first() ? asset('storage' . $product2->images()->first()->image_url) : 'https://via.placeholder.com/1000x1000' }}"
                                        alt="{{ $product2->name }}" style="max-width: 100px">
                                </div>
                                <div class="d-flex flex-column">
                                    <h4><a href="/product/{{ $product2->id }}">
                                            {{ $product2->name }}</a></h4>
                                </div>
                            </div>
                        @else
                            -
                        @endif
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-2 col">Category</div>
                    <div class="col-lg-5 col text-primary">{{ $product1 ? $product1->category->name : '-' }}</div>
                    <div class="col-lg-5 col text-primary">{{ $product2 ? $product2->category->name : '-' }}</div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-2 col">Seller</div>
                    <div class="col-lg-5 col text-primary">{{ $product1 ? $product1->user->first_name : '-' }}</div>
                    <div class="col-lg-5 col text-primary">{{ $product2 ? $product2->user->first_name : '-' }}</div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-2 col">Starting Price</div>
                    <div
                        class="col-lg-5 col {{ $product1 && $product2 && $product1->starting_price > $product2->starting_price ? 'text-danger' : 'text-success' }}">
                        {{ $product1 ? $product1->starting_price : '-' }}</div>
                    <div
                        class="col-lg-5 col {{ $product1 && $product2 && $product1->starting_price >= $product2->starting_price ? 'text-success' : 'text-danger' }}">
                        {{ $product2 ? $product2->starting_price : '-' }}</div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-2 col">Current Price</div>
                    <div
                        class="col-lg-5 col {{ $product1 && $product2 && $product1->getTotalBidAmountAttribute() > $product2->getTotalBidAmountAttribute() ? 'text-danger' : 'text-success' }}">
                        {{ $product1 ? $product1->getTotalBidAmountAttribute() : '-' }}</div>
                    <div
                        class="col-lg-5 col {{ $product1 && $product2 && $product1->getTotalBidAmountAttribute() >= $product2->getTotalBidAmountAttribute() ? 'text-success' : 'text-danger' }}">
                        {{ $product2 ? $product2->getTotalBidAmountAttribute() : '-' }}</div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-2 col">Time Left</div>
                    <div
                        class="col-lg-5 col {{ $product1 && $product2 && $product1->end_time > $product2->end_time ? 'text-success' : 'text-danger' }}">
                        @if ($product1)
                            <div class="countdown text-center text-danger" data-end-time="{{ $product1->end_time }}">
                                <span>{{ $product1->end_time }}</span>
                            </div>
                        @endif
                    </div>
                    <div
                        class="col-lg-5 col {{ $product1 && $product2 && $product1->end_time >= $product2->end_time ? 'text-success' : 'text-danger' }}">
                        @if ($product2)
                            <div class="countdown text-center text-danger" data-end-time="{{ $product2->end_time }}">
                                <span>{{ $product2->end_time }}</span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-2 col">Minumum Bid User</div>
                    <div
                        class="col-lg-5 col {{ $product1 && $product2 && $product1->min_bid_users > $product2->min_bid_users ? 'text-danger' : 'text-success' }}">
                        {{ $product1 ? $product1->min_bid_users : '-' }}</div>
                    <div
                        class="col-lg-5 col {{ $product1 && $product2 && $product1->min_bid_users >= $product2->min_bid_users ? 'text-success' : 'text-danger' }}">
                        {{ $product2 ? $product2->min_bid_users : '-' }}</div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-2 col">Minumum Bid Increment</div>
                    <div
                        class="col-lg-5 col {{ $product1 && $product2 && $product1->min_bid_increment > $product2->min_bid_increment ? 'text-danger' : 'text-success' }}">
                        {{ $product1 ? $product1->min_bid_increment : '-' }}</div>
                    <div
                        class="col-lg-5 col {{ $product1 && $product2 && $product1->min_bid_increment >= $product2->min_bid_increment ? 'text-success' : 'text-danger' }}">
                        {{ $product2 ? $product2->min_bid_increment : '-' }}</div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End Report -->
@endsection

@section('custom-js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const queryInput1 = document.getElementById('query1');
            const selected1 = document.getElementById('selectedProduct1');
            const suggestionsBox1 = document.getElementById('suggestions1');
            const form = document.getElementById('search');

            queryInput1.addEventListener('input', function() {
                const query = queryInput1.value;

                if (query.length > 2) {
                    fetch(`{{ route('search.suggestions') }}?query=${query}`)
                        .then(response => response.json())
                        .then(data => {
                            suggestionsBox1.innerHTML = '';
                            data.forEach(item => {
                                const suggestionItem = document.createElement('div');
                                suggestionItem.classList.add('suggestion-item');
                                suggestionItem.textContent = item.name;
                                suggestionItem.addEventListener('click', function() {
                                    queryInput1.value = item.name;
                                    selected1.value = item.id;
                                    suggestionsBox1.innerHTML = '';
                                    form.submit();
                                });
                                suggestionsBox1.appendChild(suggestionItem);
                            });
                        });
                } else {
                    suggestionsBox1.innerHTML = '';
                }
            });

            const queryInput2 = document.getElementById('query2');
            const suggestionsBox2 = document.getElementById('suggestions2');
            const selected2 = document.getElementById('selectedProduct2');

            queryInput2.addEventListener('input', function() {
                const query = queryInput2.value;

                if (query.length > 2) {
                    fetch(`{{ route('search.suggestions') }}?query=${query}`)
                        .then(response => response.json())
                        .then(data => {
                            suggestionsBox2.innerHTML = '';
                            data.forEach(item => {
                                const suggestionItem = document.createElement('div');
                                suggestionItem.classList.add('suggestion-item');
                                suggestionItem.textContent = item.name;
                                suggestionItem.addEventListener('click', function() {
                                    queryInput2.value = item.name;
                                    selected2.value = item.id;
                                    suggestionsBox2.innerHTML = '';
                                    form.submit();
                                });
                                suggestionsBox2.appendChild(suggestionItem);
                            });
                        });
                } else {
                    suggestionsBox2.innerHTML = '';
                }
            });
        });
    </script>
@endsection
