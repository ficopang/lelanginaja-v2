@extends('template.generic')

@section('title', 'Report Product')

@section('content')
    <!-- Report -->
    <div class="container section">
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
        <div class="card p-2">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <img src="{{ $product->images()->first() ? asset('storage' . $product->images()->first()->image_url) : 'https://via.placeholder.com/1000x1000' }}"
                            alt="{{ $product->name }}" style="max-width: 100px">
                    </div>
                    <div class="d-flex flex-column">
                        <h4><a href="/product/{{ $product->id }}">
                                {{ $product->name }}</a></h4>
                        <p class="quantity">
                            {{ $product->lastbid() ? $product->lastbid()->user->first_name . ' - ' : '' }}
                            <span
                                class="amount text-primary">{{ formatRupiah($product->getTotalBidAmountAttribute()) }}</span>
                        </p>
                    </div>
                </div>

                <form action="{{ route('report.store', $product) }}" method="POST">
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
