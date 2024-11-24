@extends('template.generic')

@section('title', 'Checkout')

@section('content')
    <!--====== Checkout Form Steps Part Start ======-->
    <section class="checkout-wrapper section">
        <form method="post" action="{{ route('cart.checkout') }}">
            @csrf
            <div class="container">
                {{-- menampilkan error validasi --}}
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            <li>{{ $errors->first() }}</li>
                        </ul>
                    </div>
                @endif
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="checkout-steps-form-style-1">
                            <ul id="accordionExample">
                                <li>
                                    <h6 class="title collapsed" data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                        aria-expanded="true" aria-controls="collapseFour">Shipping Address</h6>
                                    <section class="checkout-steps-form-content collapse show" id="collapseFour"
                                        aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="single-form form-default">
                                                    <div class="row">
                                                        <div class="col-md-6 form-input form">
                                                            <label for="name">Receiver's name</label>
                                                            <input type="text" class="form-control"
                                                                placeholder="Jane Doe" name="name" id="name"
                                                                value="{{ old('name') }}">
                                                        </div>
                                                        <div class="col-md-6 form-input form">
                                                            <label for="phone_number">Phone Number</label>
                                                            <input type="text" class="form-control"
                                                                placeholder="081296595207" id="phone_number"
                                                                name="phone_number" value="{{ old('phone_number') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="single-form form-default">
                                                    <div class="form-input form">
                                                        <label for="addres">Address</label>
                                                        <textarea class="form-control" placeholder="Mawar Raya Street No. 123" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <div class="form-input form">
                                                        <label for="city">City</label>
                                                        <input type="text" class="form-control" placeholder="Tangerang"
                                                            id="city" name="city" value="{{ old('city') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <div class="form-input form">
                                                        <label for="postal_code">Post Code</label>
                                                        <input type="text" class="form-control" placeholder="15138"
                                                            id="postal_code" name="postal_code"
                                                            value="{{ old('postal_code') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <div class="form-input form">
                                                        <label for="province">Province</label>
                                                        <input type="text" class="form-control" placeholder="Banten"
                                                            id="province" name="province">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <div class="form-input form">
                                                        <label for="country">Country</label>
                                                        <input type="text" class="form-control" placeholder="Indonesia"
                                                            id="country" name="country">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="checkout-sidebar">
                            <div class="checkout-sidebar-coupon">
                                <!-- Shopping Item -->
                                <div class="shopping-item" style="z-index: 1000;">
                                    <div class="dropdown-cart-header">
                                        <span>{{ $wonProducts->count() }} Items</span>
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
                                            <button type="submit" class="btn animate">Checkout</button>
                                        </div>
                                    </div>
                                </div>
                                <!--/ End Shopping Item -->
                            </div>
                            @if (count($recommendations) > 0)
                                <div class="checkout-sidebar-price-table mt-30">
                                    <h5 class="title">You might like</h5>
                                    <div>

                                        @foreach ($recommendations as $recommend)
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    <img src="{{ $recommend->images()->first() ? asset('storage' . $recommend->images()->first()->image_url) : 'https://via.placeholder.com/1000x1000' }}"
                                                        alt="{{ $recommend->name }}" style="max-width: 64px">
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <h4><a href="{{ route('products.show', $recommend->id) }}">
                                                            {{ $recommend->name }}</a></h4>
                                                    <p class="quantity">
                                                        {{ $recommend->lastbid() ? $recommend->lastbid()->user->first_name . ' - ' : '' }}
                                                        <span
                                                            class="amount text-primary">{{ formatRupiah($recommend->getTotalBidAmountAttribute()) }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
        </form>
    </section>
    <!--====== Checkout Form Steps Part Ends ======-->
@endsection
