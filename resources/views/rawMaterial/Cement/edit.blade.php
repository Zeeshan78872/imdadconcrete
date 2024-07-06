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
                <span>Edit Cement Stock</span>
            </div>


        </div>

        <div class="card stockCard shadow-2-strong bg-white  py-2 px-3">
            <div class="card-header bg-white text-center">
                <h4 class="page-title">Edit Incoming Cement Stock Details</h4>
            </div>
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('cement.update', $cements->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="date" class="form-label">Date <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror"
                                    value="{{ $cements->date }}" name="date" id="date" placeholder="">
                                @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="seller_name" class="form-label">Seller Name <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control @error('seller_name') is-invalid @enderror"
                                    name="seller_name" value="{{ $cements->seller_name }}" id="seller_name"
                                    aria-describedby="helpId" placeholder="">
                                @error('seller_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="cement_company" class="form-label">Cement Company <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control  @error('cement_company') is-invalid @enderror"
                                    name="cement_company" value="{{ $cements->cement_company }}" id="cement_company"
                                    aria-describedby="helpId" placeholder="">
                                @error('cement_company')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="quantity" class="form-label">Quantity of cement Packs<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror "
                                    name="quantity" value="{{ $cements->quantity }}" onchange="CalTotalPrice()" id="quantity"
                                    aria-describedby="helpId" placeholder="">
                                @error('quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="price_pack" class="form-label">Price For Single Pack <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control @error('price_pack') is-invalid @enderror "
                                    name="price_pack" value="{{ $cements->price_pack }}" onchange="CalTotalPrice()"
                                    id="price_pack" aria-describedby="helpId" placeholder="">
                                @error('price_pack')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="total_price" class="form-label">Total Price <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control @error('total_price') is-invalid @enderror"
                                    name="total_price" id="total_price" readonly value="{{ $cements->total_price }}"
                                    aria-describedby="helpId" placeholder="">
                                @error('total_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <button type="reset" class="btn btn-light text-primary btn-rest">Reset</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function CalTotalPrice() {
            let quantity = document.getElementById('quantity');
            let price_pack = document.getElementById('price_pack');

            let total_price = document.getElementById('total_price');

            let Total_price = parseInt(price_pack.value) * parseInt(quantity.value);
            total_price.value = Total_price;
        }

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
