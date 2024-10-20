@extends('template.generic')

@section('title', 'Account')


@section('content')
    <!-- Start edit account Area -->
    <div class="container section">
        <div class="row">
            <div class="col-md-3 d-none d-md-block">
                <div class="card">
                    <div class="card-body">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="v-pills-profile-tab" data-bs-toggle="pill" href="#v-pills-profile"
                                role="tab" aria-controls="v-pills-profile" aria-selected="true">Profile Information</a>
                            <a class="nav-link" id="v-pills-security-tab" data-bs-toggle="pill" href="#v-pills-security"
                                role="tab" aria-controls="v-pills-security" aria-selected="false">Security</a>
                            <a class="nav-link" id="v-pills-account-tab" data-bs-toggle="pill" href="#v-pills-account"
                                role="tab" aria-controls="v-pills-account" aria-selected="false">Account Settings</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header border-bottom mb-3 d-flex d-md-none">
                        <ul class="nav nav-tabs card-header-tabs nav-gap-x-1" role="tablist">
                            <li class="nav-item"> <a class="nav-link active" id="v-pills-profile-tab" data-bs-toggle="pill"
                                    href="#v-pills-profile" role="tab" aria-controls="v-pills-profile"
                                    aria-selected="true"><i class="lni lni-user"></i></a></li>
                            <li class="nav-item"> <a class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill"
                                    href="#v-pills-security" role="tab" aria-controls="v-pills-security"
                                    aria-selected="true"><i class="lni lni-protection"></i></a></li>
                            <li class="nav-item"> <a class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill"
                                    href="#v-pills-account" role="tab" aria-controls="v-pills-account"
                                    aria-selected="true"><i class="lni lni-cog"></i></a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active p-2" id="v-pills-profile" role="tabpanel"
                                aria-labelledby="v-pills-profile-tab">
                                <h5 class="fw-bold">YOUR PROFILE INFORMATION</h5>
                                <hr>
                                <form action="{{ route('account.update') }}" method="POST">
                                    @method('PUT')
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
                                    <div class="mb-3">
                                        <label for="name" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name"
                                            value="{{ $user->first_name }}" placeholder="Enter your first name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name"
                                            value="{{ $user->last_name }}" placeholder="Enter your last name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email address</label>
                                        <input disabled type="email" class="form-control" id="email" name="email"
                                            placeholder="{{ $user->email }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="address" class="form-control" id="address" name="address"
                                            value="{{ $user->address }}" placeholder="Enter your address">
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone number</label>
                                        <input type="tel" class="form-control" id="phone" name="phone"
                                            value="{{ $user->phone_number }}" placeholder="Enter your phone number">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </form>
                            </div>
                            <div class="tab-pane fade p-2" id="v-pills-security" role="tabpanel"
                                aria-labelledby="v-pills-security-tab">
                                <h5 class="fw-bold">SECURITY SETTINGS</h5>
                                <hr>
                                <form action="{{ route('account.updatePassword') }}" method="POST">
                                    @method('PUT')
                                    @csrf
                                    <div class="mb-3">
                                        <label for="current-password" class="form-label">Current Password</label>
                                        <input type="password" class="form-control" id="current-password"
                                            name="password" placeholder="Enter your current password">
                                    </div>
                                    <div class="mb-3">
                                        <label for="new-password" class="form-label">New Password</label>
                                        <input type="password" class="form-control" id="new-password"
                                            name="new_password" placeholder="Enter your new password">
                                    </div>
                                    <div class="mb-3">
                                        <label for="confirm-password" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" id="confirm-password"
                                            name="confirm_new_password" placeholder="Confirm your new password">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </form>
                            </div>
                            <div class="tab-pane fade p-2" id="v-pills-account" role="tabpanel"
                                aria-labelledby="v-pills-account-tab">
                                <h5 class="fw-bold">YOUR PROFILE INFORMATION</h5>
                                <hr>
                                <div class="form-group">
                                    <label class="d-block text-danger fw-bold">Delete Account</label>
                                    <p class="text-muted font-size-sm">Once you delete your account, there is no going
                                        back. Please be certain.</p>
                                </div>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-danger mt-4" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    Delete Account
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form class="modal-content" action="{{ route('account.destroy', $user->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this account?')">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Enter your password to
                                                    delete account</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="password" class="form-control" id="password"
                                                    name="password" placeholder="Enter your password">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Delete Account</button>
                                            </div>
                                            <form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End edit account Area -->
@endsection
