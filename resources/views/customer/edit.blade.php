@extends('layouts.app')

@section('style')
    <style>
        .card {
            margin-top: 161px !important;
        }
    </style>
@endsection
@section('content')
    <div class="container mb-5">
        <div class="row">
            <div class="col-6 col-md-auto  top-left">
                <span>Edit Customer Details</span>
            </div>
        </div>

        <div class="card stockCard shadow-2-strong bg-white mt-5 py-2 px-3">
            <div class="card-header bg-white text-center">
                <h4 class="page-title">EDIT CUSTOMER DETAILS</h4>
            </div>
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('customer.update', $customer->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="customer_id" class="form-label text-blod">Customer ID <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control non-edit-able" name="customer_id" readonly
                                    value="{{ $customer->customer_id }}" id="customer_id" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="customer_name" class="form-label text-blod">Customer Name <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                                    name="customer_name" id="customer_name" value="{{ $customer->customer_name }}"
                                    placeholder="">
                                @error('customer_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="company_name" class="form-label text-blod">Company Name <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control @error('company_name') is-invalid @enderror"
                                    name="company_name" id="company_name" value="{{ $customer->company_name }}"
                                    placeholder="">
                                @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="city_area" class="form-label text-blod">City / Area <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control @error('city_area') is-invalid @enderror"
                                    name="city_area" id="city_area" value="{{ $customer->city_area }}" placeholder="">
                                @error('city_area')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="phone_number_1" class="form-label text-blod">Phone Number 1 <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control @error('phone_number_1') is-invalid @enderror"
                                    name="phone_number_1" id="phone_number_1" value="{{ $customer->phone_number_1 }}"
                                    placeholder="">
                                @error('phone_number_1')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="phone_number_2" class="form-label text-blod">Phone Number 2 (optional)</label>
                                <input type="text" class="form-control" name="phone_number_2" id="phone_number_2"
                                    value="{{ $customer->phone_number_2 }}" placeholder="">

                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-light text-primary btn-rest mx-3">Reset</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
