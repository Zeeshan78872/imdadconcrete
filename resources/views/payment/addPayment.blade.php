@extends('layouts.app')

@section('style')
    <style>
        .card {
            margin-top: 95px !important;
        }
    </style>
@endsection
@section('content')
    <div class="container mb-5">
        @component('components.success-model', [
            'title' => 'Payment Record Added Successfully',
            'desc' => 'A received payment record has been added to the list',
            'closeText' => 'Close',
        ])
            <a href="{{ route('payment.index') }}" class="btn btn-primary">View All Received Payments</a>
        @endcomponent
        <div class="row">
            <div class="col-6 col-md-auto  top-left">
                <span>Add A Payment Record</span>
            </div>
        </div>
        <div class="card stockCard shadow-2-strong bg-white  py-2 px-3">
            <div class="card-header bg-white text-center">
                <h4 class="page-title">ENTER A PAYMENT RECORDS</h4>
            </div>
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('payment.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="payment_id" class="form-label text-blod">Payment ID <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control non-edit-able" name="payment_id" id="payment_id"
                                    aria-describedby="helpId"
                                    value="{{ old('payment_id', 'C' . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT)) }}"
                                    readonly placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="date" class="form-label text-blod">Date <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror"
                                    name="date" id="date" value="{{ old('date') }}" placeholder="">
                                @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="customer_id" class="form-label text-blod">Customer Name <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <select class="form-select form-select-md @error('customer_id') is-invalid @enderror"
                                    name="customer_id" id="searchableSelect">
                                    <option>Choose Customer</option>
                                    @foreach ($customerNames as $name)
                                        <option {{ old('customer_id') == $name->id ? 'selected' : '' }}
                                            value="{{ $name->id }}">{{ $name->customer_name }}</option>
                                    @endforeach

                                </select>
                                @error('customer_id')
                                    <span class="invalid-feedback mt-3" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="company_name" class="form-label text-blod">Company Name (optional)</label>
                                <input type="text" class="form-control" name="company_name" id="company_name"
                                    aria-describedby="helpId" value="{{ old('company_name') }}" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="deposit_bank_name" class="form-label text-blod">Deposit Bank Account <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <select class="form-select form-select-md  @error('deposit_bank_name') is-invalid @enderror"
                                    name="deposit_bank_name" id="category">
                                    <option>Choose Bank Account</option>
                                    @foreach ($DepositBank as $bank)
                                        <option {{ old('deposit_bank_name') == $bank->title_bank_name ? 'selected' : '' }}
                                            value="{{ $bank->title_bank_name }}">
                                            {{ $bank->title_bank_name }}</option>
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
                                <label for="amount_reveived" class="form-label text-blod">Amount Received <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number"
                                    class="form-control number-input @error('amount_reveived') is-invalid @enderror"
                                    name="amount_reveived" value="{{ old('amount_reveived') }}" id="amount_reveived"
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
                        <button type="reset" class="btn btn-light text-primary btn-rest mx-3">Reset</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
    <script>
        $('#searchableSelect').select2({});
    </script>
@endsection
