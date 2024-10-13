@extends('template.generic')

@section('title', 'Register')

@section('content')
    <!-- Start Account Register Area -->
    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <div class="register-form">
                        <div class="title">
                            <h3>No Account? Register</h3>
                            <p>You need an account to place a bid</p>
                        </div>
                        <form action="{{ route('register') }}" class="row" method="post">
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
                            @csrf
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="firstname">First Name</label>
                                    <input class="form-control" type="text" id="firstname" name="firstname"
                                        value="{{ old('firstname') }}" placeholder="John" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="lastname">Last Name</label>
                                    <input class="form-control" type="text" id="lastname" name="lastname"
                                        value="{{ old('lastname') }}" placeholder="Doe" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email">E-mail Address</label>
                                    <input class="form-control" type="email" id="email" name="email"
                                        value="{{ old('email') }}" placeholder="email@example.com" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input class="form-control" type="text" id="phone" name="phone"
                                        value="{{ old('phone') }}" placeholder="081296595207" required>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input class="form-control" type="text" id="address" name="address"
                                        value="{{ old('address') }}" placeholder="Mawar Raya Street no. 123" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input class="form-control" type="password" id="password" name="password"
                                        placeholder="******" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="confirm_password">Confirm Password</label>
                                    <input class="form-control" type="password" id="confirm_password"
                                        name="confirm_password" placeholder="******" required>
                                </div>
                            </div>
                            <div class="button">
                                <button class="btn" type="submit">Register</button>
                            </div>
                            <p class="outer-link">Already have an account? <a href="{{ route('login') }}">Login Now</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Account Register Area -->
@endsection
