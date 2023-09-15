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
            'title' => 'Gravel or Sand Stock Added Successfully',
            'desc' => 'A new gravel or sand stock record has been added to the list',
            'closeText' => 'Close',
        ])
            <a href="{{ route('gravelSand.index') }}" class="btn btn-primary">View Gravel and sand Stock Listings</a>
        @endcomponent
        <div class="row">
            <div class="col-6 col-md-auto  top-left">
                <span>Edit Gravel and Sand Record</span>
            </div>
        </div>
        <div class="card stockCard shadow-2-strong bg-white  py-2 px-3">
            <div class="card-header bg-white text-center">
                <h4 class="page-title">Edit gravel or sand stock Details</h4>
            </div>
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('gravelSand.update', $gravelSand->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="date" class="form-label text-blod">Date <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror"
                                    value="{{ $gravelSand->date }}" name="date" id="date" placeholder="">
                                @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="vehicle_no" class="form-label text-blod">Vehicle No <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control @error('vehicle_no') is-invalid @enderror"
                                    name="vehicle_no" value="{{ $gravelSand->vehicle_no }}" id="vehicle_no"
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
                                <label for="bilti_no" class="form-label text-blod">Bilti No <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control @error('bilti_no') is-invalid @enderror"
                                    name="bilti_no" value="{{ $gravelSand->bilti_no }}" id="bilti_no"
                                    aria-describedby="helpId" placeholder="">
                                @error('bilti_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="material_type" class="form-label text-blod">Material Type <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <select class="form-select form-select-md @error('material_type') is-invalid @enderror"
                                    name="material_type" id="material_type">
                                    <option value="">Choose Material Type </option>
                                    @foreach ($materialTypes as $type)
                                        <option {{ $gravelSand->material_type == $type ? 'selected' : '' }}
                                            value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
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
                                <label for="length" class="form-label text-blod">Length in SFT <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text"
                                    class="form-control number-input  @error('length') is-invalid @enderror"
                                    onchange="CalTotalPrice()" onkeyup="setupnumValid('length')" name="length"
                                    value="{{ $gravelSand->length }}" id="length" aria-describedby="helpId"
                                    placeholder="">
                                @error('length')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="width" class="form-label text-blod">Width in SFT <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control number-input @error('width') is-invalid @enderror"
                                    onchange="CalTotalPrice()" onkeyup="setupnumValid('width')" name="width"
                                    value="{{ $gravelSand->width }}" id="width" aria-describedby="helpId"
                                    placeholder="">
                                @error('width')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="height" class="form-label text-blod">Height in SFT <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text"
                                    class="form-control number-input @error('height') is-invalid @enderror "
                                    onchange="CalTotalPrice()" onkeyup="setupnumValid('height')" name="height"
                                    value="{{ $gravelSand->height }}" id="height" aria-describedby="helpId"
                                    placeholder="">
                                @error('height')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="seller_name" class="form-label text-blod">Seller Name <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <select class="form-select form-select-md @error('seller_name') is-invalid @enderror"
                                    name="seller_name" id="seller_name">
                                    <option value="">Choose Seller Name</option>
                                    @foreach ($sellerNames as $name)
                                        <option {{ $gravelSand->seller_name == $name ? 'selected' : '' }}
                                            value="{{ $name }}">
                                            {{ $name }}</option>
                                    @endforeach
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
                                <label for="total_measeurement" class="form-label text-blod">Total Measurement in SFT <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number"
                                    class="form-control number-input non-edit-able @error('total_measeurement') is-invalid @enderror"
                                    name="total_measeurement" id="total_measeurement" readonly
                                    value="{{ $gravelSand->total_measeurement }}" aria-describedby="helpId"
                                    placeholder="">
                                @error('total_measeurement')
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
        function setupnumValid(containerId) {
            const inputContainer = document.getElementById(containerId);
            inputContainer.addEventListener('input', function(event) {
                const target = event.target;
                if (target.tagName === 'INPUT' && target.type === 'text') {
                    const inputValue = target.value;
                    const cleanValue = inputValue.replace(/[^0-9.]/g, '');
                    target.value = cleanValue;
                }
            });
        }

        function CalTotalPrice() {
            let height = document.getElementById('height');
            let width = document.getElementById('width');
            let length = document.getElementById('length');

            let total_measeurement = document.getElementById('total_measeurement');

            let Total_price = parseFloat(height.value) * parseFloat(width.value) * parseFloat(length.value);
            total_measeurement.value = Total_price;
        }
    </script>
@endsection
