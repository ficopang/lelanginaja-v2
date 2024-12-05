@extends('template.generic')

@section('title', 'History')

@section('content')
    <!-- Report -->
    <div class="container section">
        <div class="card">
            <div class="card-header">
                Transaction History
            </div>
            <div class="card-body">
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
                <div class="my-items">
                    <div class="item-list-title">
                        <div class="row align-items-center">
                            <div class="col-lg-4 col-md-5 col-12">
                                <p>Product</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p>Price</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p>Date</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p>Seller</p>
                            </div>
                            <div class="col-lg-2 col-md-3 col-12 align-right">
                                <p>Action</p>
                            </div>
                        </div>
                    </div>
                    @foreach ($userTransactions as $tr)
                        <div class="single-item-list" data-bs-toggle="collapse"
                            data-bs-target="#product-details-{{ $tr->product->id }}" class="accordion-toggle">
                            <div class="row align-items-center">
                                <div class="col-lg-4 col-md-5 col-12">
                                    <div class="item-image">
                                        <img src="{{ $tr->product->images()->first() ? asset('storage' . $tr->product->images()->first()->image_url) : 'https://via.placeholder.com/1000x1000' }}"
                                            alt="#" data-pagespeed-url-hash="3023132953"
                                            onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                                        <div class="content">
                                            <h3 class="title"><a
                                                    href="/product/{{ $tr->product->id }}">{{ $tr->product->name }}</a>
                                            </h3>
                                            <span class="price">{{ 'Rp' . $tr->final_price }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-12">
                                    <p>{{ 'Rp' . $tr->final_price }}</p>
                                </div>
                                <div class="col-lg-2 col-md-2 col-12">
                                    <p>{{ $tr->created_at }}</p>
                                </div>
                                <div class="col-lg-2 col-md-2 col-12">
                                    <p>{{ $tr->seller->first_name . ' ' . $tr->seller->last_name }}</p>
                                </div>
                                <div class="col-lg-2 col-md-3 col-12 align-right">
                                    <ul class="action-btn">
                                        <li>
                                            <a href="{{ route('chat.index', $tr->product->id) }}"
                                                class="btn btn-sm shadow rounded-circle btn-outline-dark d-flex justify-content-center align-items-center icon-circle"><i
                                                    class="bx bxs-conversation"></i></a>
                                        </li>
                                        @if ($tr->status == 'Pending')
                                            <li>

                                                <form action="{{ route('transaction.finish', $tr->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-sm shadow rounded-circle btn-outline-dark d-flex justify-content-center align-items-center icon-circle text-success"><i
                                                            class="bx bxs-check-circle"></i></button>
                                                </form>
                                            </li>
                                        @endif
                                        <li>
                                            <a href="{{ route('transaction.report.store', $tr->id) }}"
                                                class="btn btn-sm shadow rounded-circle btn-outline-dark d-flex justify-content-center align-items-center icon-circle text-danger"><i
                                                    class="bx bxs-error"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="collapse" id="product-details-{{ $tr->product->id }}">
                            <div class="card card-body">
                                <p class="fw-bold">Product Details:</p>
                                <ul>
                                    <li>Name: {{ $tr->product->name }}</li>
                                    <li>Description: {{ $tr->product->description }}</li>
                                    <li>Starting Price: {{ 'Rp' . $tr->product->starting_price }}</li>
                                    <li>Min Bid Increment: {{ 'Rp' . $tr->product->min_bid_increment }}</li>
                                    <li>Start Time: {{ $tr->product->start_time }}</li>
                                    <li>End Time: {{ $tr->product->end_time }}</li>
                                    <li>Status: {{ $tr->status }}</li>
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!--/ End Report -->
@endsection
