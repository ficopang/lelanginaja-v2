@extends('admin.generic')

@section('title', 'Dashboard')

@section('content')
    <div class="row g-6">
        <!-- Card Border Shadow -->
        <div class="col-lg-3 col-sm-6">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-primary"><i
                                    class="bx bxs-user-account bx-lg"></i></span>
                        </div>
                        <h4 class="mb-0">{{ $userCount }}</h4>
                    </div>
                    <p class="mb-2">Users account created</p>
                    <p class="mb-0">
                        <span class="text-heading fw-medium me-2">+18.2%</span>
                        <span class="text-muted">than last week</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card card-border-shadow-warning h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-warning"><i
                                    class="bx bxs-package bx-lg"></i></span>
                        </div>
                        <h4 class="mb-0">{{ $productCount }}</h4>
                    </div>
                    <p class="mb-2">Products added</p>
                    <p class="mb-0">
                        <span class="text-heading fw-medium me-2">-8.7%</span>
                        <span class="text-muted">than last week</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card card-border-shadow-danger h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-danger"><i
                                    class="bx bxs-credit-card bx-lg"></i></span>
                        </div>
                        <h4 class="mb-0">{{ $transactionCount }}</h4>
                    </div>
                    <p class="mb-2">Transactions created</p>
                    <p class="mb-0">
                        <span class="text-heading fw-medium me-2">+4.3%</span>
                        <span class="text-muted">than last week</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card card-border-shadow-info h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-info"><i
                                    class="bx bxs-purchase-tag bx-lg"></i></span>
                        </div>
                        <h4 class="mb-0">{{ $bidCount }}</h4>
                    </div>
                    <p class="mb-2">Bids placed</p>
                    <p class="mb-0">
                        <span class="text-heading fw-medium me-2">-2.5%</span>
                        <span class="text-muted">than last week</span>
                    </p>
                </div>
            </div>
        </div>
        <!--/ Card Border Shadow -->

        <!-- Top Products -->
        <div class="col-12 col-xxl-8 mb-6">
            <div class="card h-100">
                <div class="row row-bordered g-0 h-100">
                    <div class="col-md-6">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2">Top Products by <span class="text-primary">Price</span></h5>
                        </div>
                        <div class="card-body pt-6">
                            <ul class="p-0 m-0">
                                @foreach ($topProductByTotalBidAmount as $product)
                                    <li class="d-flex align-items-center {{ $loop->iteration != 6 ? 'mb-6' : '' }}">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <img src="{{ $product->images()->first() ? asset('storage' . $product->images()->first()->image_url) : 'https://via.placeholder.com/100x100' }}"
                                                alt="{{ $product->name }}">
                                        </div>
                                        <div
                                            class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0 text-truncate" style="max-width: 12vw">{{ $product->name }}
                                                </h6>
                                                <small class="d-block">{{ $product->category->name }}</small>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <span
                                                    class="fw-medium">{{ formatRupiah($product->getTotalBidAmountAttribute()) }}</span>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2">Top Products by <span class="text-primary">Bids</span></h5>
                        </div>
                        <div class="card-body pt-6">
                            <ul class="p-0 m-0">
                                @foreach ($topProductByBidCount as $product)
                                    <li class="d-flex align-items-center {{ $loop->iteration != 6 ? 'mb-6' : '' }}">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <img src="{{ $product->images()->first() ? asset('storage' . $product->images()->first()->image_url) : 'https://via.placeholder.com/100x100' }}"
                                                alt="{{ $product->name }}" class="rounded">
                                        </div>
                                        <div
                                            class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0 text-truncate" style="max-width: 13vw">{{ $product->name }}
                                                </h6>
                                                <small class="d-block">{{ $product->category->name }}</small>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-3">
                                                <span class="fw-medium">{{ $product->bids()->count() }}</span>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Top Products -->

        <!-- Transactions -->
        <div class="col-xxl-4 col-lg-5">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-1 me-2">Transactions</h5>
                        <p class="card-subtitle">12% increase in this month</p>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                        @foreach ($transactions as $transaction)
                            <li class="d-flex align-items-center {{ $loop->iteration != 6 ? 'mb-6' : '' }}">
                                <div class="avatar flex-shrink-0 me-4">
                                    <img src="{{ $transaction->product->images()->first() ? asset('storage' . $transaction->product->images()->first()->image_url) : 'https://via.placeholder.com/100x100' }}"
                                        alt="{{ $transaction->product->name }}" class="rounded">
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-1 fw-normal">{{ $transaction->product->name }}</h6>
                                        <p class="text-success mb-0">
                                            {{ formatRupiah($product->getTotalBidAmountAttribute()) }}
                                        </p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <!--/ Transactions -->
    </div>
@endsection

@section('custom-js')
    <script src="{{ asset('assets/admin/js/dashboards-analytics.js') }}"></script>
@endsection
