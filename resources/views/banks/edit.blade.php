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
            'title' => 'Cement Stock Added Successfully',
            'desc' => 'A cement stock record has been added to the list',
            'closeText' => 'Close',
        ])
            <a href="{{ route('cement.index') }}" class="btn btn-primary">View Cement Stock Listings</a>
        @endcomponent
        <div class="row">
            <div class="col-6 col-md-auto  top-left">
                <span>Edit a Bank </span>
            </div>
        </div>
        <div class="card stockCard shadow-2-strong bg-white  py-2 px-3">
            <div class="card-header bg-white text-center">
                <h4 class="page-title">Edit Bank Details</h4>
            </div>
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('bank.update', $bank->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row justify-content-center">

                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="account_category" class="form-label text-blod">Account Category
                                    <sup class="text-danger"><b>*</b></sup>
                                </label>
                                <select class="form-select form-select-md @error('account_category') is-invalid @enderror"
                                    name="account_category" id="account_category">
                                    <option value="">Choose Account Category</option>
                                    @foreach ($AccountCategory as $category)
                                        <option {{ $bank->account_category == $category ? 'selected' : '' }}
                                            value="{{ $category }}">{{ $category }}</option>
                                    @endforeach
                                </select>
                                @error('account_category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="title_bank_name" class="form-label text-blod">Account Title - Bank Name
                                    <sup class="text-danger"><b>*</b></sup>
                                </label>
                                <input type="text" class="form-control @error('title_bank_name') is-invalid @enderror"
                                    name="title_bank_name" value="{{ $bank->title_bank_name }}" id="title_bank_name"
                                    aria-describedby="helpId" placeholder="">
                                @error('title_bank_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="account_number" class="form-label text-blod">Account Number / IBAN <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control  @error('account_number') is-invalid @enderror"
                                    name="account_number" value="{{ $bank->account_number }}" id="account_number"
                                    aria-describedby="helpId" placeholder="">
                                @error('account_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="city_branch_add" class="form-label text-blod">City - Branch Address
                                    (Optional)</label>
                                <input type="text" class="form-control" name="city_branch_add"
                                    value="{{ $bank->city_branch_add }}" id="city_branch_add" aria-describedby="helpId"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="account_type" class="form-label text-blod">Account Type (Optional)</label>
                                <input type="text" class="form-control" name="account_type"
                                    value="{{ $bank->account_type }}" id="account_type" aria-describedby="helpId"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="status" class="form-label text-blod">Status (Optional)
                                </label>
                                <select class="form-select form-select-md" name="status" id="status">
                                    <option value="">Choose Status</option>
                                    @foreach ($AccountStatus as $status)
                                        <option {{ $bank->status == $status ? 'selected' : '' }}
                                            value="{{ $status }}">{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="account_owner" class="form-label text-blod">Account Owners <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control  @error('account_owner') is-invalid @enderror"
                                    name="account_owner" value="{{ $bank->account_owner }}" id="account_owner"
                                    aria-describedby="helpId" placeholder="">
                                @error('account_owner')
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
    <script>
        function applyInputBehavior(inputElement) {
            // Set the default value to 0
            inputElement.value = 0;
            // Add an event listener to handle input changes
            inputElement.addEventListener("input", function() {
                // Get the entered value
                var enteredValue = parseFloat(inputElement.value);
                // Check if the entered value is less than 0
                if (isNaN(enteredValue) || enteredValue < 0) {
                    inputElement.value = 0; // Set the value to 0
                }
            });
        }
        var inputElements = document.querySelectorAll(".number-input");
        inputElements.forEach(function(inputElement) {
            applyInputBehavior(inputElement);
        });
    </script>
@endsection
