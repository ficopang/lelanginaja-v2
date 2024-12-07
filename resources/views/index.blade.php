@extends('template.generic')

@section('custom-header')
    <link rel="stylesheet" href="{{ asset('assets/css/tiny-slider.css') }}" />
    <style>
        .featured-categories .single-category img {
            width: 30%;
        }

        .hero-slider .single-slider img {
            position: absolute;
            right: 5%;
            top: 52%;
            width: 35%;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
            z-index: 10;
        }


        .hero-small-banner img {
            position: absolute;
            right: 2%;
            top: 50%;
            height: 90%;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
            z-index: 10;
        }

        .single-banner img {
            position: absolute;
            left: 5%;
            top: 50%;
            width: 40%;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
            z-index: 10;
        }

        .ellipsis {
            max-width: 280px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            /* number of lines to show */
            -webkit-box-orient: vertical;
        }
    </style>
@endsection

@section('content')
    <!-- Start Hero Area -->
    <section class="hero-area">
        <div class="container">

            {{-- menampilkan error validasi --}}
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        <li>{{ $errors->first() }}</li>
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row">
                <div class="col-lg-8 col-12 custom-padding-right">
                    <div class="slider-head">
                        <!-- Start Hero Slider -->
                        <div class="hero-slider">
                            <!-- Start Single Slider -->
                            @foreach ($carousel as $cr)
                                <div class="single-slider"
                                    style="
                                    background: #fff;
                                    background-image: url({{ asset('assets/images/banner/home.jpg') }});
                                ">
                                    <div class="content" style="z-index: 11;">
                                        <h2 class="fs-3">
                                            {{ $cr->name }}
                                        </h2>
                                        <p class="ellipsis mt-3">
                                            {{ $cr->description }}
                                        </p>
                                        <h3><span>Starts from </span>{{ formatRupiah($cr->starting_price) }}
                                        </h3>
                                        <div class="button">
                                            <a href="/product/{{ $cr->id }}" class="btn">Bid Now!</a>
                                        </div>
                                    </div>
                                    <div class="images">
                                        <img src="{{ asset('storage/' . strtolower($cr->category->name) . 's/cover.webp') }}"
                                            alt="{{ $cr->name }}">
                                    </div>
                                </div>
                            @endforeach
                            <!-- End Single Slider -->
                        </div>
                        <!-- End Hero Slider -->
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-12 md-custom-padding">
                            <!-- Start Small Banner -->
                            <div class="hero-small-banner"
                                style="
                                /* background: #fff; */
                                background-image: url({{ asset('assets/images/banner/home.jpg') }});
                            ">
                                <div class="content" style="z-index: 11">
                                    <h2 class="col-5 fs-6">
                                        {{ $smallBanner->name }}
                                    </h2>
                                    <h3>{{ formatRupiah($smallBanner->total_bid_amount) }}</h3>
                                </div>
                                <div class="images">
                                    <img src="{{ asset('storage/' . strtolower($smallBanner->category->name) . 's/cover.webp') }}"
                                        alt="{{ $smallBanner->name }}">
                                </div>
                            </div>
                            <!-- End Small Banner -->
                        </div>
                        <div class="col-lg-12 col-md-6 col-12">
                            <!-- Start Small Banner -->
                            <div class="hero-small-banner style2">
                                <div class="content">
                                    <h2>Tuesday Funday</h2>
                                    <p class="mt-0 fw-normal">
                                        Free shipping only on Tuesday! (min Rp200.000)
                                    </p>
                                    <div class="button mt-2">
                                        <a class="btn" href="/product">Bid Now</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Start Small Banner -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Hero Area -->

    <!-- Start Featured Categories Area -->
    <section class="featured-categories section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Featured Categories</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($categories as $cat)
                    <div class="col-lg-6 col-md-6 col-12">
                        <!-- Start Single Category -->
                        <div class="single-category">
                            <a href="{{ route('products.search', $cat->id) }}" class="heading"
                                style="text-transform: capitalize;">{{ str_replace('_', ' ', $cat->name) }}
                            </a>
                            <ul>
                                @for ($i = 0; $i < 2; $i++)
                                    <?php $product = $cat->products()->inRandomOrder()->first(); ?>
                                    <li><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a>
                                    </li>
                                @endfor
                                <li><a href="{{ route('products.category', ['id' => $cat->id]) }}">View All</a></li>
                            </ul>
                            <div class="images">
                                <img src="{{ asset('storage/' . strtolower($cat->name) . 's/cover.webp') }}"
                                    alt="{{ $cat->name }}" />
                            </div>
                        </div>
                        <!-- End Single Category -->
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End Features Area -->

    <!-- Start Trending Product Area -->
    <section class="trending-product section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Trending Product</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($trendingProduct as $tp)
                    <div class="col-lg-3 col-md-6 col-12">
                        <x-product-card :product="$tp" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End Trending Product Area -->

    <!-- Start Special Offer -->
    <section class="special-offer section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Special Offer</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-12 col-12">
                    <div class="row">
                        @foreach ($specialOffer as $offer)
                            <div class="col-lg-4 col-md-6 col-12">
                                <!-- Start Single Product -->
                                <x-product-card :product="$offer" />
                                <!-- End Single Product -->
                            </div>
                        @endforeach
                    </div>
                    <!-- Start Banner -->
                    <div class="single-banner right"
                        style="
                        position: relative;
                        /* background: #fff; */
                        background-image: url({{ asset('assets/images/banner/home.jpg') }});
                        margin-top: 30px;
                    ">
                        <div class="content" style="z-index: 11">
                            <h2>{{ $banner->name }}</h2>
                            <p class="ellipsis ms-auto mt-3">
                                {{ $banner->description }}
                            </p>
                            <div class="price">
                                Current price: <span>{{ formatRupiah($banner->total_bid_amount) }}</span>
                            </div>
                            <div class="button mt-2">
                                <a href="/product/{{ $banner->id }}" class="btn">Bid Now!</a>
                            </div>
                        </div>
                        <div class="images">
                            <img src="{{ asset('storage/' . strtolower($banner->category->name) . 's/cover.webp') }}"
                                alt="{{ $product->name }}">
                        </div>
                    </div>
                    <!-- End Banner -->
                </div>
                <div class="col-lg-4 col-md-12 col-12">
                    <div class="offer-content">
                        <div class="image">
                            <img src="{{ $offer->images()->first() ? asset('storage' . $offer->images()->first()->image_url) : 'https://via.placeholder.com/1000x1000' }}"
                                alt="{{ $offer->name }}" />
                            <span class="sale-tag">-50%</span>
                        </div>
                        <div class="text">
                            <h2>
                                <a href="/product/{{ $offer->id }}">{{ $offer->name }}</a>
                            </h2>
                            <div class="price">
                                <span>{{ formatRupiah($offer->starting_price) }}</span>
                                <span class="discount-price">{{ formatRupiah($offer->undiscountedPrice()) }}</span>
                            </div>
                            <p>
                                {{ $offer->description }}
                            </p>
                        </div>
                        <div class="box-head">
                            <div class="box">
                                <h1 id="days">000</h1>
                                <h2 id="daystxt">Days</h2>
                            </div>
                            <div class="box">
                                <h1 id="hours">00</h1>
                                <h2 id="hourstxt">Hours</h2>
                            </div>
                            <div class="box">
                                <h1 id="minutes">00</h1>
                                <h2 id="minutestxt">Minutes</h2>
                            </div>
                            <div class="box">
                                <h1 id="seconds">00</h1>
                                <h2 id="secondstxt">Seconds</h2>
                            </div>
                        </div>
                        <div style="background: rgb(204, 24, 24)" class="alert">
                            <h1 style="padding: 50px 80px; color: white">
                                We are sorry, Event ended !
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Special Offer -->

    <!-- Start Home Product List -->
    <section class="home-product-list section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12 custom-responsive-margin">
                    <h4 class="list-title">Closest Auction</h4>
                    @foreach ($closestAuction as $ca)
                        <!-- Start Single List -->
                        <div class="single-list">
                            <div class="list-image">
                                <a href="/product/{{ $ca->id }}"><img
                                        src="{{ $ca->images()->first() ? asset('storage' . $ca->images()->first()->image_url) : 'https://via.placeholder.com/1000x1000' }}"
                                        alt="{{ $ca->name }}" /></a>
                            </div>
                            <div class="list-info">
                                <h3>
                                    <a href="/product/{{ $ca->id }}">{{ $ca->name }}</a>
                                </h3>
                                <span>{{ formatRupiah($product->total_bid_amount) }}</span>
                            </div>
                        </div>
                        <!-- End Single List -->
                    @endforeach
                </div>
                <div class="col-lg-6 col-md-6 col-12 custom-responsive-margin">
                    <h4 class="list-title">New Arrivals</h4>
                    <!-- Start Single List -->
                    @foreach ($newArrivals as $newarr)
                        <div class="single-list">
                            <div class="list-image">
                                <a href="/product/{{ $newarr->id }}"><img
                                        src="{{ $newarr->images()->first() ? asset('storage' . $newarr->images()->first()->image_url) : 'https://via.placeholder.com/1000x1000' }}"
                                        alt="{{ $newarr->name }}" /></a>
                            </div>
                            <div class="list-info">
                                <h3>
                                    <a href="/product/{{ $newarr->id }}">{{ $newarr->name }}</a>
                                </h3>
                                <span>{{ formatRupiah($newarr->total_bid_amount) }}</span>
                            </div>
                        </div>
                    @endforeach
                    <!-- End Single List -->
                </div>
            </div>
        </div>
    </section>
    <!-- End Home Product List -->

    <!-- Start Shipping Info -->
    <section class="shipping-info">
        <div class="container">
            <ul>
                <!-- Free Shipping -->
                <li>
                    <div class="media-icon">
                        <i class="bx bx-mail-send"></i>
                    </div>
                    <div class="media-body">
                        <h5>Free Shipping</h5>
                        <span>On order over Rp500.000</span>
                    </div>
                </li>
                <!-- Money Return -->
                <li>
                    <div class="media-icon">
                        <i class="bx bx-support"></i>
                    </div>
                    <div class="media-body">
                        <h5>24/7 Support.</h5>
                        <span>Live Chat Or Call.</span>
                    </div>
                </li>
                <!-- Support 24/7 -->
                <li>
                    <div class="media-icon">
                        <i class="bx bx-credit-card"></i>
                    </div>
                    <div class="media-body">
                        <h5>Online Payment.</h5>
                        <span>Secure Payment Services.</span>
                    </div>
                </li>
                <!-- Safe Payment -->
                <li>
                    <div class="media-icon">
                        <i class="bx bx-refresh"></i>
                    </div>
                    <div class="media-body">
                        <h5>Easy Return.</h5>
                        <span>Hassle Free Shopping.</span>
                    </div>
                </li>
            </ul>
        </div>
    </section>
    <!-- End Shipping Info -->
@endsection

@section('custom-js')
    <script src="{{ asset('assets/js/tiny-slider.js') }}"></script>
    <script type="text/javascript">
        tns({
            container: '.hero-slider',
            slideBy: 'page',
            autoplay: true,
            autoplayButtonOutput: false,
            mouseDrag: true,
            gutter: 0,
            items: 1,
            nav: false,
            controls: true,
            controlsText: ['<i class="bx bx-chevron-left"></i>', '<i class="bx bx-chevron-right"></i>'],
        });
        tns({
            container: '.brands-logo-carousel',
            autoplay: true,
            autoplayButtonOutput: false,
            mouseDrag: true,
            gutter: 15,
            nav: false,
            controls: false,
            responsive: {
                0: {
                    items: 1,
                },
                540: {
                    items: 3,
                },
                768: {
                    items: 5,
                },
                992: {
                    items: 6,
                }
            }
        });
    </script>
    <script>
        const finaleDate = new Date("{{ $offer->end_time }}").getTime();

        const timer = () => {
            const now = new Date().getTime();
            let diff = finaleDate - now;
            if (diff < 0) {
                // document.querySelector('.alert').style.display = 'block';
                // document.querySelector('.container').style.display = 'none';
            }

            let days = Math.floor(diff / (1000 * 60 * 60 * 24));
            let hours = Math.floor(diff % (1000 * 60 * 60 * 24) / (1000 * 60 * 60));
            let minutes = Math.floor(diff % (1000 * 60 * 60) / (1000 * 60));
            let seconds = Math.floor(diff % (1000 * 60) / 1000);

            days <= 99 ? days = `${days}` : days;
            days <= 9 ? days = `0${days}` : days;
            hours <= 9 ? hours = `0${hours}` : hours;
            minutes <= 9 ? minutes = `0${minutes}` : minutes;
            seconds <= 9 ? seconds = `0${seconds}` : seconds;

            document.querySelector('#days').textContent = days;
            document.querySelector('#hours').textContent = hours;
            document.querySelector('#minutes').textContent = minutes;
            document.querySelector('#seconds').textContent = seconds;

        }
        timer();
        setInterval(timer, 1000);
    </script>
@endsection
