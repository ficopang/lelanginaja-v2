@extends('template.generic')

@section('title', 'Login')

@section('content')
    <!-- Start Account Login Area -->
    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <form action="{{ route('login') }}" class="card login-form" method="post">
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

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @csrf

                        <div class="card-body">
                            <div class="title">
                                <h3>Login Now</h3>
                            </div>
                            <div class="form-group input-group">
                                <label for="email">Email</label>
                                <input class="form-control" type="email" id="email" name="email"
                                    value="{{ old('email') }}" placeholder="email@example.com" required>
                            </div>
                            <div class="form-group input-group">
                                <label for="password">Password</label>
                                <input class="form-control" type="password" id="password" name="password"
                                    placeholder="******" required>
                            </div>
                            <div class="d-flex flex-wrap justify-content-between bottom-content">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input width-auto" id="remember"
                                        name="remember">
                                    <label for="remember" class="form-check-label">Remember me</label>
                                </div>
                                {{-- <a class="lost-pass" href="account-password-recovery.html">Forgot password?</a> --}}
                            </div>
                            <div class="button">
                                <button class="btn" type="submit">Login</button>
                            </div>
                            <p class="outer-link">Don't have an account? <a href="{{ route('register') }}">Register here
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Account Login Area -->
@endsection
