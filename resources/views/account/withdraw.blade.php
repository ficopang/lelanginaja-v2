@extends('template.generic')

@section('title', 'Withdraw')

@section('content')
    <!-- Start edit account Area -->
    <div class="container section">
        <div class="card">
            <div class="card-body">
                <h1>Withdraw Money</h1>
                <br />
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
                <br />
                <form method="post" action="{{ route('withdraw.request') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="amount" class="form-label">Withdrawal Amount</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" id="amount" name="amount" min="1"
                                step="1" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>

        <div>
            @csrf
            <div class="card">
                <div class="card-body">
                    <h2>Account Balance</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Transaction Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($withdraws as $withdraw)
                                <tr>
                                    <td>{{ $withdraw->created_at }}</td>
                                    <td>{{ $withdraw->status }}</td>
                                    <td>{{ $withdraw->amount }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        {{-- <tfoot>
                            <tr>
                                <td colspan="2"><strong>Total</strong></td>
                                <td>$1000.00</td>
                            </tr>
                        </tfoot> --}}
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- End edit account Area -->
@endsection
