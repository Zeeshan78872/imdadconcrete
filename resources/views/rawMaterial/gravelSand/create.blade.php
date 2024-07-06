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
        @component('components.success-model', [
            'title' => 'Gravel or Sand Stock Added Successfully',
            'desc' => 'A new gravel or sand stock record has been added to the list',
            'closeText' => 'Close',
        ])
            <a href="{{ route('gravelSand.index') }}" class="btn btn-primary">View Gravel and sand Stock Listings</a>
        @endcomponent
        <div class="row">
            <div class="col-6 col-md-auto  top-left">
                <span>Add a Incoming Gravel and Sand Record</span>
            </div>


        </div>

        <div class="card stockCard shadow-2-strong bg-white  py-2 px-3">
            <div class="card-header bg-white text-center">
                <h4 class="page-title">Enter gravel or sand stock Details</h4>
            </div>
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('gravelSand.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="date" class="form-label">Date <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror"
                                    value="{{ date('Y-m-d') }}" name="date" id="date" placeholder="">
                                @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="vehicle_no" class="form-label">Vehicle No <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control @error('vehicle_no') is-invalid @enderror"
                                    name="vehicle_no" value="{{ old('vehicle_no') }}" id="vehicle_no"
                                    aria-describedby="helpId" placeholder="">
                                @error('vehicle_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="bilti_no" class="form-label">Bilti No <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control @error('bilti_no') is-invalid @enderror"
                                    name="bilti_no" value="{{ old('bilti_no') }}" id="bilti_no" aria-describedby="helpId"
                                    placeholder="">
                                @error('bilti_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="material_type" class="form-label">Material Type <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <select class="form-select form-select-md @error('material_type') is-invalid @enderror" name="material_type" id="material_type">
                                    <option value="">Choose Material Type </option>
                                    @foreach ($materialTypes as $type)
                                        <option {{(old('material_type') ==$type)?'seelected':'' }} value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                    {{-- <option value="Sand">Sand</option>
                                    <option value="Gravel">Gravel</option> --}}
                                </select>
                                @error('material_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="length" class="form-label">Lenght <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control  @error('length') is-invalid @enderror"
                                    onchange="CalTotalPrice()" name="length" value="{{ old('length', 0) }}" id="length"
                                    aria-describedby="helpId" placeholder="">
                                @error('length')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="width" class="form-label">Width <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control  @error('width') is-invalid @enderror"
                                    onchange="CalTotalPrice()" name="width" value="{{ old('width', 0) }}" id="width"
                                    aria-describedby="helpId" placeholder="">
                                @error('width')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="height" class="form-label">Height <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control @error('height') is-invalid @enderror "
                                    onchange="CalTotalPrice()" name="height" value="{{ old('height', 0) }}"
                                    onchange="CalTotalPrice()" id="height" aria-describedby="helpId" placeholder="">
                                @error('height')
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
                                <select class="form-select form-select-md @error('seller_name') is-invalid @enderror" name="seller_name" id="seller_name">
                                    <option value="">Choose Seller Name</option>
                                    @foreach ($sellerNames as $name)
                                        <option {{(old('seller_name') == $name)?'selected':''}} value="{{ $name }}">{{ $name }}</option>
                                    @endforeach
                                    {{-- <option value="rasheed">rasheed</option>
                                    <option value="iqbal">iqbal</option> --}}
                                </select>
                                @error('seller_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="total_measeurement" class="form-label">Total Measurement in SFT <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text"
                                    class="form-control @error('total_measeurement') is-invalid @enderror"
                                    name="total_measeurement" id="total_measeurement" readonly
                                    value="{{ old('total_measeurement', 0) }}" aria-describedby="helpId" placeholder="">
                                @error('total_measeurement')
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
            let height = document.getElementById('height');
            let width = document.getElementById('width');
            let length = document.getElementById('length');

            let total_measeurement = document.getElementById('total_measeurement');

            let Total_price = parseInt(height.value) * parseInt(width.value) * parseInt(length.value);
            total_measeurement.value = Total_price;
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
