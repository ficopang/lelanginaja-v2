@extends('template.generic')

@section('title', 'Product Details')

@section('custom-header')
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/admin/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <style>
        .icon-circle {
            width: 32px;
            height: 32px;
        }

        .last-bid-amounts:before {
            content: '';

            width: 95%;
            position: absolute;
            left: 12px;
            top: 0;

            border-top: 1px solid #dee2e6 !important;
            border-color: #dee2e6 !important;
            border-width: 2px !important;
        }

        #latestBid,
        #latestSecondBid,
        #latestThirdBid,
        #latestFourthBid {
            transition: transform 0.5s ease, opacity 0.5s ease;
            position: relative;
        }

        /* Highlight effect for the latest bid */
        #latestBid::after {
            content: '';
            width: 88%;
            position: absolute;
            left: 12px;
            top: 0;
            border-top: 1px solid #0d6efd !important;
            border-color: transparent;
            /* Start with transparent border */
            border-width: 2px !important;
            transition: border-color 0.5s ease;
            /* Smooth transition for border color */
        }

        /* Class to trigger the border highlight animation */
        .highlight-bid::after {
            border-color: #0d6efd !important;
            /* Highlight color */
        }

        /* Slide animations for first and second bids */
        .slide-left {
            transform: translateX(100%);
        }

        .slide-reset {
            transform: translateX(0);
        }

        /* Opacity transition for the third bid */
        #latestFourthBid.slide-left {
            opacity: 0;
            transform: translateX(50%);
            /* Less horizontal movement for third bid */
        }

        #latestFourthBid.slide-reset {
            opacity: 1;
            transform: translateX(0);
        }
    </style>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
@endsection

@section('content')
    <!-- Start Item Details -->
    <section class="item-details section">
        <div class="container">
            <div class="top-area">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="product-images">
                            <main id="gallery">
                                <div class="main-img d-flex align-items-center justify-content-center">
                                    <img src="{{ $product->images()->first() ? asset('storage' . $product->images()->first()->image_url) : 'https://via.placeholder.com/500x500' }}"
                                        id="current" alt="{{ $product->name }}">
                                </div>
                                <div class="images">
                                    @foreach ($product->images() as $img)
                                        <img src="{{ asset('storage' . $img->image_url) }}" class="img"
                                            alt="{{ $product->name }}">
                                    @endforeach
                                </div>
                            </main>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="product-info">
                            <div class="d-flex align-items-start justify-content-between">
                                <h2 class="title m-0">{{ $product->name }}</h2>
                                @auth
                                    <div class="d-flex gap-1">
                                        <form class="" action="{{ route('products.watchlist', $product) }}"
                                            method="POST">
                                            @csrf
                                            <button
                                                class="btn btn-sm shadow rounded-circle d-flex justify-content-center align-items-center icon-circle {{ auth()->user()->watchlists->contains('product_id', $product->id)? 'btn-dark text-white': 'btn-outline-dark' }}"><i
                                                    class="bx bx-low-vision"></i></button>
                                        </form>
                                        <a href="/account/chat/{{ $product->user_id }}"
                                            class="btn btn-sm shadow rounded-circle btn-outline-dark d-flex justify-content-center align-items-center icon-circle"><i
                                                class="bx bxs-conversation"></i></a>
                                    </div>
                                @endauth
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4 col-12">
                                    <i class="bx bxs-user text-dark me-1"></i> {{ $product->user->first_name }}
                                </div>
                                <div class="col-md-4 col-12">
                                    <a class="text-primary" href="/search?category_id={{ $product->category->id }}"
                                        style="text-transform: capitalize;">
                                        <p class="category"><i class="bx bxs-purchase-tag text-primary"></i></i>
                                            {{ $product->category->name }}
                                        </p>
                                    </a>
                                </div>
                                <div class="col-md-4 col-12">
                                    <a class="text-danger" href="{{ route('report.index', $product->id) }}">
                                        <i class="bx bxs-error me-1"></i> Report
                                    </a>
                                </div>
                            </div>

                            <div class="d-flex align-items-start justify-content-between mb-2">
                                <div class="d-flex flex-column gap-1">
                                    <p class="fw-bold">Current Bid</p>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar">
                                            <span id="last-bidders-initial"
                                                class="avatar-initial rounded-circle {{ auth()->user() && $product->bids()->latest('created_at')->first() && $product->bids()->latest('created_at')->first()->user->id === auth()->user()->id ? 'bg-primary' : 'bg-secondary' }}">
                                                {{ $product->bids()->latest('created_at')->first() ? $product->bids()->latest('created_at')->first()->user->first_name[0] : '?' }}</span>
                                        </div>
                                        <span
                                            class="d-inline {{ auth()->user() && $product->bids()->latest('created_at')->first() && $product->bids()->latest('created_at')->first()->user->id === auth()->user()->id ? 'text-primary' : 'text-secondary' }} fw-bold"
                                            id="last-bidder">
                                            {{ $product->bids()->latest('created_at')->first() ? $product->bids()->latest('created_at')->first()->user->first_name . ' ' . $product->bids()->latest('created_at')->first()->user->last_name : 'No bids yet' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex flex-column align-items-start">
                                    <p class="fw-bold">Auctions Ends in</p>
                                    <div id="countdown" class="countdown text-dark fw-bold fs-4"
                                        data-end-time="{{ $product->end_time }}">
                                    </div>
                                </div>
                            </div>
                            <div class="bid info-text my-0 pb-0 mb-3">
                                <div class="last-bid-amounts row position-relative">
                                    <div id="latestBid" class="col text-primary fw-bold position-relative pt-1">
                                        @if ($product->auction_type != 'close')
                                            {{ formatRupiah($product->getTotalBidAmountAttribute()) }}
                                        @elseif(auth()->user())
                                            {{ formatRupiah($product->starting_price) }}
                                        @else
                                            {{ formatRupiah($product->starting_price) }}
                                        @endif
                                    </div>
                                    <div id="latestSecondBid" class="col pt-1">
                                        @if ($product->auction_type != 'close')
                                            {{ $product->bids->count() > 1 ? formatRupiah($product->getTotalBidAmountAttribute($product->bids[$product->bids->count() - 2]->id)) : '' }}
                                        @endif
                                    </div>
                                    <div id="latestThirdBid" class="col pt-1">
                                        @if ($product->auction_type != 'close')
                                            {{ $product->bids->count() > 2 ? formatRupiah($product->getTotalBidAmountAttribute($product->bids[$product->bids->count() - 3]->id)) : '' }}
                                        @endif
                                    </div>
                                    <div id="latestFourthBid" class="col pt-1">
                                        @if ($product->auction_type != 'close')
                                            {{ $product->bids->count() > 3 ? formatRupiah($product->getTotalBidAmountAttribute($product->bids[$product->bids->count() - 4]->id)) : '' }}
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row info-text my-0 pb-0">
                                <div class="col-sm-6 col-12 fw-bold">Type</div>
                                <div class="col-sm-6 col-12">
                                    <!-- Sale badge-->
                                    <div
                                        class="badge {{ $product->auction_type === 'close' ? 'bg-secondary' : 'bg-success' }} text-white text-capitalize">
                                        {{ $product->auction_type }} bid
                                    </div>
                                </div>
                            </div>
                            <div class="row info-text my-0 pb-0">
                                <div class="col-sm-6 col-12 fw-bold">Start Time</div>
                                <div class="col-sm-6 col-12">{{ $product->start_time }}</div>
                            </div>
                            <div class="row info-text my-0 pb-0">
                                <div class="col-sm-6 col-12 fw-bold">Starting Price</div>
                                <div class="col-sm-6 col-12">{{ formatRupiah($product->starting_price) }}</div>
                            </div>
                            <div class="row info-text my-0 pb-0">
                                <div class="col-sm-6 col-12 fw-bold">Minimum Bid User</div>
                                <div class="col-sm-6 col-12">{{ $product->min_bid_users }}</div>
                            </div>
                            <div class="row info-text my-0 pb-0 mb-2">
                                <div class="col-sm-6 col-12 fw-bold">Minimum Bid Increment</div>
                                <div class="col-sm-6 col-12">{{ formatRupiah($product->min_bid_increment) }}</div>
                            </div>

                            <div class="bottom-content">
                                <div class="d-flex flex-column flex-md-row">
                                    <input type="text" class="form-control" id="bid-amount-preview"
                                        name="bid-amount-preview" oninput="formatRupiahInput(this)"
                                        value="{{ formatRupiah($product->min_bid_increment) }}">
                                    <input type="hidden" id="bid-amount" name="bid-amount"
                                        value="{{ $product->min_bid_increment }}">
                                    <div class="btn-group">
                                        <button class="btn btn-outline-primary" accesskey=","
                                            onclick="setMinimum()">Min</button>
                                        <button class="btn btn-outline-primary" accesskey="x"
                                            onclick="doubleAmount()">x2</button>
                                        <button class="btn btn-outline-primary" accesskey="/"
                                            onclick="halfAmount()">1/2</button>
                                        <button class="btn btn-outline-primary" accesskey="."
                                            onclick="setMaximum()">max</button>
                                    </div>
                                    <div class="button">
                                        @csrf
                                        <button class="btn w-100" id="bid-button" accesskey="b"
                                            onclick="placeBid({{ $product->id }})">Bid</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-details-info">
                <div class="single-block">
                    <div class="row">
                        <div class="col-12">
                            <div class="info-body custom-responsive-margin">
                                <ul class="nav nav-pills mb-3" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                            data-bs-target="#info-tab-pane" type="button" role="tab"
                                            aria-controls="info-tab-pane" aria-selected="true">Info</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="history-tab" data-bs-toggle="tab"
                                            data-bs-target="#history-tab-pane" type="button" role="tab"
                                            aria-controls="history-tab-pane" aria-selected="false"
                                            {{ $product->auction_type == 'close' ? 'disabled' : '' }}>History</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="info-tab-pane" role="tabpanel"
                                        aria-labelledby="info-tab" tabindex="0">
                                        <h4 class="fw-bold">Description</h4>
                                        <p>{{ $product->description }}</p>

                                        <p>Condition: New</p>
                                    </div>
                                    @if ($product->auction_type != 'close')
                                        <div class="tab-pane fade" id="history-tab-pane" role="tabpanel"
                                            aria-labelledby="history-tab" tabindex="0">
                                            <table id="history" class="table table-striped table-hover">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th scope="col">Date</th>
                                                        <th scope="col">Bidder</th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col">Total Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="history-data">
                                                    @foreach ($bids->reverse() as $bid)
                                                        <tr>
                                                            <th scope="row">{{ $bid->created_at }}</th>
                                                            <td>{{ $bid->user->first_name }}
                                                            </td>
                                                            <td>{{ formatRupiah($bid->bid_amount) }}</td>
                                                            <td>{{ formatRupiah($product->getTotalBidAmountAttribute($bid->id)) }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Item Details -->
@endsection

@section('custom-js')
    <script src="{{ asset('assets/js/vanilla-toast.min.js') }}"></script>

    <script src="{{ asset('assets/admin/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>

    <script type="text/javascript">
        const current = document.getElementById("current");
        const opacity = 0.6;
        const imgs = document.querySelectorAll(".img");
        imgs.forEach(img => {
            img.addEventListener("click", (e) => {
                imgs.forEach(img => {
                    img.style.opacity = 1;
                });
                current.src = e.target.src;
                e.target.style.opacity = opacity;
            });
        });
    </script>
    <script>
        function formatRupiahInput(input) {
            // Ambil nilai input tanpa karakter non-digit
            let angka = input.value.replace(/[^,\d]/g, '');

            // Simpan angka asli di input hidden
            document.getElementById('bid-amount').value = angka;

            // Format angka menjadi Rupiah
            input.value = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(angka);
        }

        function formatRupiah(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(value);
        }

        function setMinimum() {
            let minBid = parseFloat('{{ $product->min_bid_increment }}'.replace(/[^\d]/g, ''));
            document.getElementById('bid-amount-preview').value = formatRupiah(minBid);
            formatRupiahInput(document.getElementById('bid-amount-preview'));
        }

        function doubleAmount() {
            let amount = parseFloat(document.getElementById('bid-amount-preview').value.replace(/[^\d]/g, ''));
            @auth
            if (amount * 2 <= {{ auth()->user()->balance }}) amount *= 2;
        @else
            amount *= 2;
        @endauth

        document.getElementById('bid-amount-preview').value = formatRupiah(amount);
        formatRupiahInput(document.getElementById('bid-amount-preview'));
        }

        function halfAmount() {
            let amount = parseFloat(document.getElementById('bid-amount-preview').value.replace(/[^\d]/g, ''));
            if (amount / 2 >= {{ $product->min_bid_increment }}) amount /= 2;
            document.getElementById('bid-amount-preview').value = formatRupiah(amount);
            formatRupiahInput(document.getElementById('bid-amount-preview'));
        }

        function setMaximum() {
            @auth
            let maximumAmount = {{ auth()->user()->balance }};
        @else
            let maximumAmount = 1000000000000;
        @endauth
        document.getElementById('bid-amount-preview').value = formatRupiah(maximumAmount);
        formatRupiahInput(document.getElementById('bid-amount-preview'));
        }

        document.querySelector('form').addEventListener('submit', function(event) {
            const input = document.getElementById('rupiahInput');

            input.value = input.value.replace(/[^\d]/g, '');
        });
    </script>
    <script>
        let latestBidValue = {{ $product->getTotalBidAmountAttribute() }}

        function addNewBid(newBid) {
            const latestBid = document.getElementById('latestBid');
            const secondBid = document.getElementById('latestSecondBid');
            const thirdBid = document.getElementById('latestThirdBid');
            const fourthBid = document.getElementById('latestFourthBid');

            // Reset animation classes
            latestBid.classList.remove('slide-reset', 'highlight-bid');
            secondBid.classList.remove('slide-reset');
            thirdBid.classList.remove('slide-reset');
            fourthBid.classList.remove('slide-reset');

            // Force reflow to reset animation states
            void latestBid.offsetHeight;
            void secondBid.offsetHeight;
            void thirdBid.offsetHeight;
            void fourthBid.offsetHeight;

            // Add the slide-left animation to slide bids
            latestBid.classList.add('slide-left');
            secondBid.classList.add('slide-left');
            thirdBid.classList.add('slide-left');
            fourthBid.classList.add('slide-left');

            setTimeout(() => {
                // Shift bids after sliding
                fourthBid.innerHTML = thirdBid.innerHTML;
                thirdBid.innerHTML = secondBid.innerHTML;
                secondBid.innerHTML = latestBid.innerHTML;
                latestBid.innerHTML = newBid;

                // Reset sliding and trigger highlight animation
                latestBid.classList.remove('slide-left');
                secondBid.classList.remove('slide-left');
                thirdBid.classList.remove('slide-left');
                fourthBid.classList.remove('slide-left');

                latestBid.classList.add('slide-reset');
                secondBid.classList.add('slide-reset');
                thirdBid.classList.add('slide-reset');
                fourthBid.classList.add('slide-reset');

                // Add the highlight effect to the latest bid after reset
                latestBid.classList.add('highlight-bid');

                // Remove highlight after a delay (optional)
                setTimeout(() => {
                    latestBid.classList.remove('highlight-bid');
                }, 2000); // Highlight stays for 2 seconds
            }, 500); // The timeout matches the CSS transition time (0.5s)
        }

        function placeBid(productId) {
            @guest
            vt.error('Please login first to place a bid', {
                title: "Error",
                position: "top-right",
                duration: 2000,
                closable: true
            });
        @endguest
        @auth
        var bidAmount = document.getElementById('bid-amount').value;

        // Create a new XHR object
        var xhr = new XMLHttpRequest();

        // Set the request URL
        var url = '/product/' + productId + '/bid';

        // Set the request method to POST
        xhr.open('POST', url, true);

        // Set the request headers
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

        // Set the callback function to handle the response
        xhr.onload = function() {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                // alert(response.message);

                if (!response.error) {
                    vt.success(response.message, {
                        title: "Success",
                        position: "top-right",
                        duration: 10000,
                        closable: true
                    });

                    @if ($product->auction_type == 'close')
                        latestBidValue += parseInt(bidAmount);
                        addNewBid(formatRupiah(latestBidValue));
                    @endif
                } else {
                    vt.error(response.error, {
                        title: "Error",
                        position: "top-right",
                        duration: 2000,
                        closable: true
                    });
                }
            } else {
                try {
                    var error = JSON.parse(xhr.responseText);
                    vt.error(error.error, {
                        title: "Error",
                        position: "top-right",
                        duration: 2000,
                        closable: true
                    });
                } catch (e) {
                    vt.error("Something went wrong. Please try again later.", {
                        title: "Error",
                        position: "top-right",
                        duration: 2000,
                        closable: true
                    });
                }
            }
        };

        // Create the request data object
        var requestData = {
            bid_amount: bidAmount
        };

        // Send the request with the data
        xhr.send(JSON.stringify(requestData));
        @endauth
        }
    </script>
    @if ($product->auction_type != 'close')
        <script>
            const histories = $('#history').DataTable({
                "order": [
                    [0, 'desc']
                ],
                "pagingType": "simple_numbers",
                "language": {
                    "paginate": {
                        "previous": "<i class='bx bxs-chevron-left'></i>",
                        "next": "<i class='bx bxs-chevron-right'></i>"
                    }
                },
                "dom": '<"pagination-container"p>' // Controls the pagination placement
            });

            // Modify pagination to use a similar structure to Laravel's pagination
            $('div.pagination-container').addClass('pagination m-0');
            $('div.dataTables_paginate').addClass('text-start');
            $('div.pagination-container ul').addClass('pagination-list');
            $('div.pagination-container li').each(function() {
                $(this).addClass($(this).hasClass('active') ? 'active' : '');
            });

            function addHistory(data) {
                var bidAmount = formatRupiah(data.bidAmount);
                var currentPrice = formatRupiah(data.currentPrice);

                histories.row.add([
                    data.createdAt,
                    data.lastBidder,
                    bidAmount,
                    currentPrice
                ]).draw();
            }

            lastBidder =
                '{{ $product->bids()->latest('created_at')->first() ? $product->bids()->latest('created_at')->first()->user->first_name : '' }}'

            window.addEventListener('load', function() {
                Echo.channel('room.' + {{ $product->id }})
                    .listen('PlaceBidEvent', (data) => {
                        // Update the countdown
                        const endTime = data.endTime;
                        const countdownElement = document.getElementById('countdown');
                        countdownElement.dataset.endTime = endTime;

                        // Update the last bidder's first name
                        const lastBidderElement = document.getElementById('last-bidder');
                        const lastBidderInitial = document.getElementById('last-bidder-initial');
                        if (data.lastBidder) {
                            addNewBid(formatRupiah(data.currentPrice));
                            lastBidderElement.textContent = data.lastBidder;
                            lastBidderInitial.textContent = data.lastBidder[0];
                            addHistory(data);

                            if (lastBidder != data.lastBidder) {
                                vt.info("Current price: Rp" + data.currentPrice, {
                                    title: lastBidder + ' just place a bid',
                                    position: "top-right",
                                    duration: 10000,
                                    closable: true
                                });

                                lastBidder = data.lastBidder;
                            }
                        }
                    });
            });
        </script>
    @endif

@endsection
