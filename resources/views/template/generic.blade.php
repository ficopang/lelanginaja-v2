<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>LelanginAja @hasSection('title')
            -
        @endif @yield('title')</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.svg') }}" />

    <!-- ========================= CSS here ========================= -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/LineIcons.3.0.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/tiny-slider.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/glightbox.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" />
    @yield('custom-header')
    {{-- @vite([]) --}}
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- /End Preloader -->

    <!-- Start Header Area -->
    <header class="header navbar-area position-sticky top-0" style="z-index: 999">
        <!-- Start Header Middle -->
        <div class="header-middle">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-3 col-7">
                        <!-- Start Header Logo -->
                        <a class="navbar-brand" href="/">
                            <img src="{{ asset('assets/images/logo/logo.svg') }}" alt="Logo">
                        </a>
                        <!-- End Header Logo -->
                    </div>
                    <div class="col-lg-5 col-md-7 d-xs-none">
                        <!-- Start Main Menu Search -->
                        <div class="main-menu-search">
                            <!-- navbar search start -->
                            <form class="navbar-search search-style-5" action="{{ route('products.search') }}"
                                method="GET">
                                <div class="search-select">
                                    <div class="select-position">
                                        <select id="category_id" name="category_id">
                                            <option value="" selected>All</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    style="text-transform: capitalize;">
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="search-input">
                                    <input type="text" id="query" name="query" placeholder="Search"
                                        accesskey="q">
                                </div>
                                <div class="search-btn">
                                    <button type="submit"><i class="lni lni-search-alt"></i></button>
                                </div>
                            </form>
                            <!-- navbar search Ends -->
                        </div>
                        <!-- End Main Menu Search -->
                    </div>
                    <div class="col-lg-4 col-md-2 col-5">
                        <div class="middle-right-area">
                            @auth
                                <div class="nav-hotline">
                                    <div class="row">
                                        <div class="col">
                                            <div class="button">
                                                <a href="{{ route('logout') }}" class="btn">Logout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="navbar-cart me-2">
                                    <div class="cart-items">
                                        <a href="javascript:void(0)" class="main-btn">
                                            <i class="lni lni-eye"></i>
                                            <span class="total-items">{{ auth()->user()->watchlists->count() }}</span>
                                        </a>
                                        <!-- Shopping Item -->
                                        <div class="shopping-item" style="z-index: 1000">
                                            <p class="p-0">Watchlist</p>
                                            <ul class="shopping-list">
                                                @foreach (auth()->user()->watchlists as $watchlistItem)
                                                    @if ($loop->iteration > 3)
                                                    @break
                                                @endif
                                                <li>
                                                    <div class="cart-img-head">
                                                        <a class="cart-img"
                                                            href="/product/{{ $watchlistItem->product->id }}"><img
                                                                src="{{ $watchlistItem->product->images()->first() ? asset('storage' . $watchlistItem->product->images()->first()->image_url) : 'https://via.placeholder.com/500x500' }}"
                                                                alt="{{ $watchlistItem->name }}"></a>
                                                    </div>

                                                    <div class="content d-flex align-items-center">
                                                        <div>
                                                            <h4 class="d-inline-block text-truncate"
                                                                style="max-width: 160px;"><a
                                                                    href="/product/{{ $watchlistItem->product->id }}">
                                                                    {{ $watchlistItem->product->name }}</a></h4>
                                                            <p class="quantity">
                                                                {{ $watchlistItem->product->lastbid() ? $watchlistItem->product->lastbid()->user->first_name . ' - ' : '' }}
                                                                <span
                                                                    class="amount text-primary">{{ formatRupiah($watchlistItem->product->getTotalBidAmountAttribute()) }}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <a href="{{ route('watchlist.index') }}"
                                            class="d-flex justify-content-center">See all</a>
                                    </div>
                                    <!--/ End Shopping Item -->
                                </div>
                                <div class="cart-items">
                                    <a href="javascript:void(0)" class="main-btn">
                                        <i class="lni lni-cart"></i>
                                        <span class="total-items">{{ $wonProducts->count() }}</span>
                                    </a>
                                    <!-- Shopping Item -->
                                    <div class="shopping-item" style="z-index: 1000;">
                                        <div class="dropdown-cart-header">
                                            <span>{{ $wonProducts->count() }} Items</span>
                                            <a class="text-primary fw-" href="/cart">View All</a>
                                        </div>
                                        <ul class="shopping-list">
                                            @foreach ($wonProducts as $product)
                                                <li>
                                                    <div class="cart-img-head">
                                                        <a class="cart-img" href="/product/{{ $product->id }}"><img
                                                                src="{{ $product->images()->first() ? asset('storage' . $product->images()->first()->image_url) : 'https://via.placeholder.com/1000x1000' }}"
                                                                alt="#"></a>
                                                    </div>

                                                    <div class="content">
                                                        <h4><a href="/product/{{ $product->id }}">
                                                                {{ $product->name }}</a></h4>
                                                        <p class="quantity"><span
                                                                class="amount">{{ formatRupiah($product->getTotalBidAmountAttribute()) }}</span>
                                                        </p>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="bottom">
                                            <div class="total">
                                                <span>Total</span>
                                                <span class="total-amount">{{ formatRupiah($totalBidAmount) }}</span>
                                            </div>
                                            <div class="button">
                                                <a href="{{ route('cart.checkout') }}"
                                                    class="btn animate">Checkout</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/ End Shopping Item -->
                                </div>
                            </div>
                        @else
                            <div class="navbar-cart ms-auto">
                                <div class="button me-2 d-sm-none d-lg-block">
                                    <a href="/register" class="btn">Register</a>
                                </div>
                                <div class="button">
                                    <a href="/login" class="btn">Login</a>
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header Middle -->
    <!-- Start Header Bottom -->
    @auth
        <div class="header-footer">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8 col-md-6 col-12">
                        <div class="nav-inner">
                            <!-- Start Mega Category Menu -->
                            <div class="mega-category-menu">
                                <span class="cat-button"><i class="lni lni-menu"></i>All Categories</span>
                                <ul class="sub-category">
                                    @foreach ($categories as $category)
                                        <li><a href="/category?id={{ $category->id }}">{{ $category->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- End Mega Category Menu -->
                            <!-- Start Navbar -->
                            <nav class="navbar navbar-expand-lg">
                                <button class="navbar-toggler mobile-menu-btn" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                                    aria-controls="navbarSupportedContent" aria-expanded="false"
                                    aria-label="Toggle navigation">
                                    <span class="toggler-icon"></span>
                                    <span class="toggler-icon"></span>
                                    <span class="toggler-icon"></span>
                                </button>
                                <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                    <ul id="nav" class="navbar-nav ms-auto">
                                        <li class="nav-item">
                                            <a href="/" aria-label="Toggle navigation">Home</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="/products" aria-label="Toggle navigation">My Products</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="dd-menu collapsed" href="javascript:void(0)"
                                                data-bs-toggle="collapse" data-bs-target="#submenu-1-4"
                                                aria-controls="navbarSupportedContent" aria-expanded="false"
                                                aria-label="Toggle navigation">Account</a>
                                            <ul class="sub-menu collapse" id="submenu-1-4">
                                                <li class="nav-item"><a href="{{ route('account') }}">Account
                                                        Settings</a></li>
                                                <li class="nav-item"><a href="{{ route('chat.index') }}">Chats</a>
                                                </li>
                                                <li class="nav-item"><a
                                                        href="{{ route('withdraw.index') }}">Withdraw</a>
                                                </li>
                                                <li class="nav-item"><a
                                                        href="{{ route('watchlist.index') }}">Watchlist</a></li>
                                                <li class="nav-item"><a
                                                        href="{{ route('transaction.index') }}">Transaction</a></li>
                                            </ul>
                                        </li>
                                        <li class="nav-item">
                                            <a href="/contact" aria-label="Toggle navigation">Contact Us</a>
                                        </li>
                                    </ul>
                                </div> <!-- navbar collapse -->
                            </nav>
                            <!-- End Navbar -->
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <!-- Start Nav Social -->
                        <div class="nav-social">
                            <h5 class="title">Follow Us:</h5>
                            <ul>
                                <li>
                                    <a href="javascript:void(0)"><i class="lni lni-facebook-filled"></i></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><i class="lni lni-twitter-original"></i></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><i class="lni lni-instagram"></i></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><i class="lni lni-skype"></i></a>
                                </li>
                            </ul>
                        </div>
                        <!-- End Nav Social -->
                    </div>
                </div>
            </div>
        </div>
    @endauth
    <!-- End Header Bottom -->
</header>
<!-- End Header Area -->

@hasSection('title')
    <!-- Start Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">@yield('title')</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> Home</a></li>
                        <li>@yield('title')</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
@endif

<div class="bg-light">
    @yield('content')
</div>

<!-- Start Footer Area -->
<footer class="footer">
    <!-- Start Footer Top -->
    <div class="footer-top">
        <div class="container">
            <div class="inner-content">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="footer-logo">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset('assets/images/logo/white-logo.svg') }}" alt="#">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8 col-12">
                        <div class="footer-newsletter">
                            <h4 class="title">
                                Subscribe to our Newsletter
                                <span>Get all the latest information, Sales and Offers.</span>
                            </h4>
                            <div class="newsletter-form-head">
                                <form action="#" method="get" target="_blank" class="newsletter-form">
                                    <input name="EMAIL" placeholder="Email address here..." type="email">
                                    <div class="button">
                                        <button class="btn">Subscribe<span class="dir-part"></span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer Top -->
    <!-- Start Footer Middle -->
    <div class="footer-middle">
        <div class="container">
            <div class="bottom-inner">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-12">
                        <!-- Single Widget -->
                        <div class="single-footer f-contact">
                            <h3>Get In Touch With Us</h3>
                            <p class="phone">Phone: +1 (900) 33 169 7720</p>
                            <ul>
                                <li><span>Monday-Friday: </span> 9.00 am - 8.00 pm</li>
                                <li><span>Saturday: </span> 10.00 am - 6.00 pm</li>
                            </ul>
                            <p class="mail">
                                <a href="mailto:support@lelanginaja.com">support@lelanginaja.com</a>
                            </p>
                        </div>
                        <!-- End Single Widget -->
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <!-- Single Widget -->
                        <div class="single-footer our-app">
                            <h3>Our Mobile App</h3>
                            <ul class="app-btn">
                                <li>
                                    <a href="javascript:void(0)">
                                        <i class="lni lni-apple"></i>
                                        <span class="small-title">Download on the</span>
                                        <span class="big-title">App Store</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">
                                        <i class="lni lni-play-store"></i>
                                        <span class="small-title">Download on the</span>
                                        <span class="big-title">Google Play</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- End Single Widget -->
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <!-- Single Widget -->
                        <div class="single-footer f-link">
                            <h3>Information</h3>
                            <ul>
                                <li><a href="/about">About Us</a></li>
                                <li><a href="/contact">Contact Us</a></li>
                                <li><a href="/faq">FAQs Page</a></li>
                            </ul>
                        </div>
                        <!-- End Single Widget -->
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <!-- Single Widget -->
                        <div class="single-footer f-link">
                            <h3>Categories</h3>
                            <ul>
                                @for ($i = 0; isset($categories[$i]) && $i <= 4; $i++)
                                    <li><a
                                            href="{{ $categories[$i]->id }}">{{ str_replace('_', ' ', $categories[$i]->name) }}</a>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                        <!-- End Single Widget -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer Middle -->
    <!-- Start Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="inner-content">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-12">
                        <div class="payment-gateway">
                            <span>We Accept:</span>
                            <img src="{{ asset('assets/images/footer/credit-cards-footer.png') }}"
                                alt="#">
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="copyright">
                            <p>&copy; {{ date('Y') }} LelanginAja</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <ul class="socila">
                            <li>
                                <span>Follow Us On:</span>
                            </li>
                            <li><a href="javascript:void(0)"><i class="lni lni-facebook-filled"></i></a></li>
                            <li><a href="javascript:void(0)"><i class="lni lni-twitter-original"></i></a></li>
                            <li><a href="javascript:void(0)"><i class="lni lni-instagram"></i></a></li>
                            <li><a href="javascript:void(0)"><i class="lni lni-google"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer Bottom -->
</footer>
<!--/ End Footer Area -->

<!-- Bottom Navbar -->
<nav class="navbar navbar-dark bg-primary navbar-expand fixed-bottom d-md-none d-lg-none d-xl-none p-0">
    <ul class="navbar-nav nav-justified w-100">
        <li class="nav-item">
            <a href="#" class="nav-link text-center">
                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-house" fill="currentColor"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
                    <path fill-rule="evenodd"
                        d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" />
                </svg>
                <span class="small d-block">Home</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link text-center">
                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z" />
                    <path fill-rule="evenodd"
                        d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z" />
                </svg>
                <span class="small d-block">Search</span>
            </a>
        </li>
        <li class="nav-item dropup">
            <a href="#" class="nav-link text-center" role="button" id="dropdownMenuProfile"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-person" fill="currentColor"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M10 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                </svg>
                <span class="small d-block">Profile</span>
            </a>
            <!-- Dropup menu for profile -->
            <div class="dropdown-menu" aria-labelledby="dropdownMenuProfile">
                <a class="dropdown-item" href="#">Edit Profile</a>
                <a class="dropdown-item" href="#">Notification</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Logout</a>
            </div>
        </li>
    </ul>
</nav>



<!-- ========================= scroll-top ========================= -->
<a href="#" class="scroll-top">
    <i class="lni lni-chevron-up"></i>
</a>

<!-- ========================= JS here ========================= -->
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/tiny-slider.js') }}"></script>
<script src="{{ asset('assets/js/glightbox.min.j') }}s"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script>
    // Countdown Timers
    var countdowns = document.querySelectorAll('.countdown');

    countdowns.forEach(function(countdown) {
        function updateCountdown() {
            var endTime = new Date(countdown.dataset.endTime).getTime(); // Read the dataset each time
            var now = new Date().getTime();
            var timeRemaining = endTime - now;

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

            if (timeRemaining <= 30) {
                countdown.classList.remove('text-dark');
                countdown.classList.add('text-danger');
            } else {
                countdown.classList.remove('text-danger');
                countdown.classList.add('text-dark');
            }

            if (timeRemaining <= 0) {
                countdown.innerHTML = "Auction Ended";
            } else {
                setTimeout(updateCountdown, 1000); // Re-run the function every second
            }
        }

        updateCountdown();
    });
</script>
@yield('custom-js')
</body>

</html>
