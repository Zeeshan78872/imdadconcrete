@extends('layouts.app')

@section('style')
    <style>
        .card {
            margin-top: 161px !important
        }
    </style>
@endsection
@section('content')
    <div class="container mb-5">
        @if (session('success'))
            @component('components.success-model', [
                'title' => 'User Created Successfully',
                'desc' => 'A new user has been added into user listing',
                'closeText' => 'Close',
            ])
                <a href="" class="btn btn-primary">View Existing Users</a>
            @endcomponent
        @endif
        <div class="row">
            <div class="col-6 col-md-auto  top-left">
                <span>Add A User</span>
            </div>
            {{--
            <div class="col-6 col-md-auto  text-md-end top-right top-right-content">
                <a href="#" class="a-link">Dashboard</a>
                <span class="ms-3">Add User</span>
            </div> --}}
        </div>

        <div class="card stockCard shadow-2-strong bg-white  py-2 px-3">
            <div class="card-header bg-white text-center">
                <h4 class="page-title">Please Enter User Details</h4>
            </div>
            <div class="card-body p-4">


                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="POST" action="">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="user_id" class="form-label">User ID <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control bg-light"
                                    name="user_id"value="ID{{ str_pad(mt_rand(0, 999), 3, '0', STR_PAD_LEFT) }}"
                                    id="user_id" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="date" class="form-label">Full Name <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="username" class="form-label">Username <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control" name="username" id="username" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="role" class="form-label">Role <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <select class="form-select form-select-md" name="role" id="role">
                                    <option selected>Choose Role</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="password" class="col-form-label text-md-end">{{ __('Password') }} <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="password-confirm"
                                    class="col-form-label text-md-end">{{ __('Confirm Password') }} <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                    </div>

                    <div class="text-center mt-3">
                        <button type="button" class="btn btn-light text-primary btn-rest">Reset</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
