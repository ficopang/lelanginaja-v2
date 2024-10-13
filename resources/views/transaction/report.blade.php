@extends('template.generic')

@section('title', 'Report Transaction')

@section('content')
    <!-- Report -->
    <div class="container section">
        <div class="card p-2">
            <div class="card-body">
                {{-- menampilkan error validasi --}}
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row d-flex">
                    <di class="col-12 col-md-6 mb-4">
                        <div class="row">
                            <div class="col-4">Transaction Date</div>
                            <div class="col-8">{{ $transaction->created_at }}</div>
                        </div>
                        <div class="row">
                            <div class="col-4">Seller</div>
                            <div class="col-8">{{ $transaction->product->user->first_name }}</div>
                        </div>
                        <div class="row">
                            <div class="col-4">Category</div>
                            <div class="col-8">
                                <a class="text-primary" href="/search?category_id={{ $transaction->product->category->id }}"
                                    style="text-transform: capitalize;">{{ $transaction->product->category->name }}</a>
                            </div>
                        </div>
                    </di>
                    <di class="col-12 col-md-6 mb-4">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <img src="{{ $transaction->product->images()->first() ? asset('storage' . $transaction->product->images()->first()->image_url) : 'https://via.placeholder.com/1000x1000' }}"
                                    alt="{{ $transaction->product->name }}" style="max-width: 60px">
                            </div>
                            <div class="d-flex flex-column">
                                <h4><a href="/product/{{ $transaction->product->id }}">
                                        {{ $transaction->product->name }}</a></h4>
                                <p class="quantity">
                                    {{ $transaction->product->lastbid() ? $transaction->product->lastbid()->user->first_name . ' - ' : '' }}
                                    <span
                                        class="amount text-primary">{{ formatRupiah($transaction->product->getTotalBidAmountAttribute()) }}</span>
                                </p>
                            </div>
                        </div>
                    </di>
                </div>

                <form action="{{ route('report.store', $transaction->product) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="report-text" class="form-label">Reason</label>
                        <textarea class="form-control" id="report-text" name="report_text" rows="3"
                            placeholder="Enter a detailed description of the problem"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Report</button>
                </form>
            </div>
        </div>
    </div>
    <!--/ End Report -->
@endsection
