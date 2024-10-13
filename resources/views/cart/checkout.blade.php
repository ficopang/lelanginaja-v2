@extends('template.generic')

@section('title', 'Checkout')

@section('content')
    <!--====== Checkout Form Steps Part Start ======-->
    <section class="checkout-wrapper section">
        <form method="post" action="{{ route('cart.checkout') }}">
            @csrf
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="checkout-steps-form-style-1">
                            <ul id="accordionExample">
                                <li>
                                    @if (count($errors) > 0)
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <h6 class="title collapsed" data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                        aria-expanded="true" aria-controls="collapseFour">Shipping Address</h6>
                                    <section class="checkout-steps-form-content collapse show" id="collapseFour"
                                        aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="single-form form-default">
                                                    <label>Receiver's name</label>
                                                    <div class="row">
                                                        <div class="col-md-6 form-input form">
                                                            <input type="text" placeholder="First Name" name="firstname">
                                                        </div>
                                                        <div class="col-md-6 form-input form">
                                                            <input type="text" placeholder="Last Name" name="lastname">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>Phone Number</label>
                                                    <div class="form-input form">
                                                        <input type="text" placeholder="Phone Number"
                                                            name="phone_number">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="single-form form-default">
                                                    <label>Mailing Address</label>
                                                    <div class="form-input form">
                                                        <input type="text" placeholder="Mailing Address" name="address">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>City</label>
                                                    <div class="form-input form">
                                                        <input type="text" placeholder="City" name="city">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>Post Code</label>
                                                    <div class="form-input form">
                                                        <input type="text" placeholder="Post Code" name="postal_code">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>Province</label>
                                                    <div class="form-input form">
                                                        <input type="text" placeholder="Province" name="province">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>Country</label>
                                                    <div class="form-input form">
                                                        <input type="text" placeholder="Country" name="country">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="checkout-payment-option">
                                                    <h6 class="heading-6 font-weight-400 payment-title">Select Delivery
                                                        Option</h6>
                                                    <div class="payment-option-wrapper">
                                                        <div class="single-payment-option">
                                                            <input type="radio" name="shipping" checked id="shipping-1"
                                                                value="AnterAja">
                                                            <label for="shipping-1">
                                                                <img src="https://via.placeholder.com/60x32" alt="Sipping">
                                                                <p>AnterAja</p>
                                                                <span class="price">Rp40000</span>
                                                            </label>
                                                        </div>
                                                        <div class="single-payment-option">
                                                            <input type="radio" name="shipping" id="shipping-2"
                                                                value="JNT">
                                                            <label for="shipping-2">
                                                                <img src="https://via.placeholder.com/60x32" alt="Sipping">
                                                                <p>JNT</p>
                                                                <span class="price">Rp40000</span>
                                                            </label>
                                                        </div>
                                                        <div class="single-payment-option">
                                                            <input type="radio" name="shipping" id="shipping-3"
                                                                value="SiCepat">
                                                            <label for="shipping-3">
                                                                <img src="https://via.placeholder.com/60x32" alt="Sipping">
                                                                <p>SiCepat</p>
                                                                <span class="price">Rp40000</span>
                                                            </label>
                                                        </div>
                                                        <div class="single-payment-option">
                                                            <input type="radio" name="shipping" id="shipping-4"
                                                                value="JNE">
                                                            <label for="shipping-4">
                                                                <img src="https://via.placeholder.com/60x32"
                                                                    alt="Sipping">
                                                                <p>JNE</p>
                                                                <span class="price">Rp40000</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="steps-form-btn button">
                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                </li>
                                <li>
                                    <h6 class="title collapsed" data-bs-toggle="collapse" data-bs-target="#collapsefive"
                                        aria-expanded="true" aria-controls="collapsefive">Payment Info</h6>
                                    <section class="checkout-steps-form-content collapse show" id="collapsefive"
                                        aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="checkout-payment-form">
                                                    <div class="single-form form-default">
                                                        <label>Cardholder Name</label>
                                                        <div class="form-input form">
                                                            <input type="text" placeholder="Cardholder Name"
                                                                name="card_holder_name">
                                                        </div>
                                                    </div>
                                                    <div class="single-form form-default">
                                                        <label>Card Number</label>
                                                        <div class="form-input form">
                                                            <input id="credit-input" type="text"
                                                                placeholder="0000 0000 0000 0000" name="card_number">
                                                            <img src="assets/images/payment/card.png" alt="card">
                                                        </div>
                                                    </div>
                                                    <div class="payment-card-info">
                                                        <div class="single-form form-default mm-yy">
                                                            <label>Expiration</label>
                                                            <div class="expiration d-flex">
                                                                <div class="form-input form">
                                                                    <input type="text" placeholder="MM"
                                                                        name="exp_month">
                                                                </div>
                                                                <div class="form-input form">
                                                                    <input type="text" placeholder="YYYY"
                                                                        name="exp_year">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="single-form form-default">
                                                            <label>CVC/CVV <span><i
                                                                        class="mdi mdi-alert-circle"></i></span></label>
                                                            <div class="form-input form">
                                                                <input type="text" placeholder="***" name="cvv">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-form form-default button">
                                                        <button type="submit" class="btn btn-primary">Pay Now</button>
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
                                <p>Appy Coupon to get discount!</p>
                                <form action="#">
                                    <div class="single-form form-default">
                                        <div class="form-input form">
                                            <input type="text" placeholder="Coupon Code">
                                        </div>
                                        <div class="button">
                                            <button class="btn">apply</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="checkout-sidebar-price-table mt-30">
                                <h5 class="title">Pricing Table</h5>

                                <div class="sub-total-price">
                                    @foreach ($wonProducts as $wonProduct)
                                        <div class="total-price">
                                            <p class="value">{{ $wonProduct->name }}</p>
                                            <p class="price">Rp{{ $wonProduct->getTotalBidAmount() }}</p>
                                        </div>
                                    @endforeach
                                    <div class="total-price shipping">
                                        <p class="value">Shipping Price:</p>
                                        <p class="price">Rp40000</p>
                                    </div>
                                </div>

                                <div class="total-payable">
                                    <div class="payable-price">
                                        <p class="value">Subotal Price:</p>
                                        <p class="price">Rp{{ $totalBidAmount + 40000 }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
    </section>
    <!--====== Checkout Form Steps Part Ends ======-->
@endsection
