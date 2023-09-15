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
            <div class="col-12 col-md-auto  top-left">
                <span>Add Incoming Cement Stock</span>
            </div>


        </div>

        <div class="card stockCard shadow-2-strong bg-white  py-2 px-3">
            <div class="card-header bg-white text-center">
                <h4 class="page-title">Enter Incoming Cement Stock Details</h4>
            </div>
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('cement.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="date" class="form-label text-blod">Date <sup
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
                                <label for="seller_name" class="form-label text-blod">Seller Name <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control @error('seller_name') is-invalid @enderror"
                                    name="seller_name" value="{{ old('seller_name') }}" id="seller_name"
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
                                <label for="cement_company" class="form-label text-blod">Cement Company <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control  @error('cement_company') is-invalid @enderror"
                                    name="cement_company" value="{{ old('cement_company') }}" id="cement_company"
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
                                <label for="quantity" class="form-label text-blod">Quantity of cement Packs<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number"
                                    class="form-control number-input @error('quantity') is-invalid @enderror "
                                    name="quantity" value="{{ old('quantity') }}" onchange="CalTotalPrice()" id="quantity"
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
                                <label for="price_pack" class="form-label text-blod">Price For Single Pack <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number"
                                    class="form-control number-input @error('price_pack') is-invalid @enderror "
                                    name="price_pack" value="{{ old('price_pack', 0) }}" onchange="CalTotalPrice()"
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
                                <label for="total_price" class="form-label text-blod">Total Price <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number"
                                    class="form-control number-input non-edit-able @error('total_price') is-invalid @enderror"
                                    name="total_price" id="total_price" readonly value="{{ old('total_price', 0) }}"
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
        function CalTotalPrice() {
            let quantity = document.getElementById('quantity');
            let price_pack = document.getElementById('price_pack');

            let total_price = document.getElementById('total_price');

            let Total_price = parseInt(price_pack.value) * parseInt(quantity.value);
            total_price.value = Total_price;
        }
    </script>
@endsection
