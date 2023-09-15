@extends('layouts.app')

@section('style')
    <style>
        .card {
            margin-top: 90px !important
        }
    </style>
@endsection
@section('content')
    <div class="container ">
        @if (session('success'))
        @endif
        <div class="row">
            <div class="col-6 col-md-auto  top-left">
                <span>Edit A User</span>
            </div>

        </div>

        <div class="card stockCard shadow-2-strong bg-white  py-2 px-3">
            <div class="card-header bg-white text-center">
                <h4 class="page-title">Edit User Details</h4>
            </div>
            <div class="card-body p-4">
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('user.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="user_id" class="form-label text-blod">User ID <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text"
                                    class="form-control non-edit-able @error('user_id') is-invalid @enderror" readonly
                                    name="user_id" value="{{ $user->user_id }}" id="user_id" placeholder="">
                                @error('user_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="date" class="form-label text-blod">Full Name <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" id="name" value="{{ old('name', $user->name) }}" placeholder="">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="username" class="form-label text-blod">Username <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    name="username" id="username" value="{{ old('username', $user->username) }}"
                                    placeholder="">
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="role" class="form-label text-blod">Role<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <select class="form-select form-select-md @error('role') is-invalid @enderror"
                                    name="role" id="role">
                                    <option value="">Choose Role</option>
                                    @foreach ($role as $key => $value)
                                        <option {{ old('role', $user->role) ?? '' == $key ? 'selected' : '' }}
                                            value="{{ $key }}">{{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="password" class="col-form-label text-md-end text-blod">{{ __('New Password') }}
                                    <sup class="text-danger"><b>*</b></sup></label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    value="" autocomplete="new-password">

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
                                    class="col-form-label text-md-end text-blod">{{ __('Confirm New Password') }} <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>

                    </div>

                    <div class="text-center mt-3">
                        <button type="reset" class="btn btn-light text-primary btn-rest mx-3">Reset</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
