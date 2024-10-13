@extends('template.generic')

@section('title', 'Send Product')

@section('content')
    <!-- Send Product -->
    <div class="container section">
        <h1 class="mb-4">Transaction Detail</h1>

        <!-- Transaction Info -->
        <div class="card mb-4">
            <div class="card-header">
                Order #123456
            </div>
            <div class="card-body">
                <p class="mb-2"><strong>Customer:</strong> John Doe</p>
                <p class="mb-2"><strong>Email:</strong> john.doe@example.com</p>
                <p class="mb-2"><strong>Address:</strong> 123 Main St, Anytown, USA</p>
                <p class="mb-2"><strong>Payment:</strong> Credit Card (**** **** **** 1234)</p>
                <p class="mb-2"><strong>Status:</strong> Shipped</p>
                <p class="mb-0"><strong>Tracking Number:</strong> 1234567890</p>
            </div>
        </div>

        <!-- AWB Input Form -->
        <div class="card mb-4">
            <div class="card-header">
                Add AWB
            </div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label for="awb" class="form-label">Air Waybill Number</label>
                        <input type="text" class="form-control" id="awb" placeholder="Enter AWB Number">
                    </div>
                    <button type="submit" class="btn btn-primary">Add AWB</button>
                </form>
            </div>
        </div>

    </div>
    <!--/ End Send Product -->
@endsection
