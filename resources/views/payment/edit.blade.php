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
                <span>Edit Payment Details</span>
            </div>

            {{-- <div class="col-6 col-md-auto  text-md-end top-right top-right-content">
                <a href="#" class="a-link">Dashboard</a>
                <span class="ms-3">Add Payment Details</span>
            </div> --}}
        </div>

        <div class="card stockCard shadow-2-strong bg-white  py-2 px-3">
            <div class="card-header bg-white text-center">
                <h4 class="page-title">EDIT PAYMENT DETAILS</h4>
            </div>
            <div class="card-body">


                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('payment.update', $payments->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="payment_id" class="form-label">Payment ID <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control bg-light" name="payment_id" id="payment_id"
                                    aria-describedby="helpId" value="{{ $payments->payment_id }}" readonly placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="date" class="form-label">Date <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror"
                                    name="date" id="date" value="{{ $payments->date }}" placeholder="">
                                @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="customer_name" class="form-label">Customer Name <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <select class="form-select form-select-md @error('customer_name') is-invalid @enderror"
                                    name="customer_name" reduired id="category">
                                    <option value="">Choose Customer</option>
                                    @foreach ($customerNames as $name)
                                        <option {{ $payments->customer_name == $name->customer_name ? 'selected' : '' }}
                                            value="{{ $name->customer_name }}">{{ $name->customer_name }}</option>
                                    @endforeach

                                </select>
                                @error('customer_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="company_name" class="form-label">Company Name (optional)</label>
                                <input type="text" class="form-control" value="{{ $payments->company_name }}"
                                    name="company_name" id="company_name" aria-describedby="helpId" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="deposit_bank_name" class="form-label">Deposit Bank Name <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <select class="form-select form-select-md @error('deposit_bank_name') is-invalid @enderror"
                                    name="deposit_bank_name" reduired id="category">
                                    <option value="">Choose Bank Name</option>
                                    @foreach ($DepositBank as $name)
                                        <option {{ $payments->deposit_bank_name == $name ? 'selected' : '' }}
                                            value="{{ $name }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                                @error('deposit_bank_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="amount_reveived" class="form-label">Amount Received <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control @error('amount_reveived') is-invalid @enderror"
                                    name="amount_reveived" value="{{ $payments->amount_reveived }}" id="amount_reveived"
                                    aria-describedby="helpId" placeholder="">
                                @error('amount_reveived')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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
