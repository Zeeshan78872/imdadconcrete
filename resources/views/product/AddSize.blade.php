@extends('layouts.app')

@section('style')
    <style>
        .page-title {
            font-family: Nunito;
            font-size: 16px;
            font-weight: 500;
            line-height: 16px;
            letter-spacing: 0.2879999876022339px;

        }

        .card {
            border: none !important;
        }

        .stockCard {
            width: 86%;
            margin: 0 auto;
            /* Set left and right margins to auto to center the div */
            padding: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="container mb-5">
        <div class="row">
            <div class="col-6 col-md-auto  top-left">
                <span>Add Product Size</span>
            </div>

            {{-- <div class="col-6 col-md-auto  text-md-end top-right top-right-content">
                <a href="#" class="a-link">Dashboard</a>
                <span class="ms-3">Add Product Size</span>
            </div> --}}
        </div>

        <div class="card stockCard shadow-2-strong bg-white mt-5 py-2 px-3">
            <div class="card-header bg-white text-center">
                <h4 class="page-title">ENTER PRODUCT SIZE</h4>
            </div>
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('product.size.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="product_id" class="form-label">Product Name <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <select class="form-select form-select-md" name="product_id" id="">
                                    <option value="" selected>Choose Product Name</option>
                                    @foreach ($products as $product)
                                        <option {{ $product_id == $product->id ? 'selected' : '' }}
                                            value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="size" class="form-label">Product Size<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control" name="size" value="" id="size"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="sft" class="form-label">SFT Ratio<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control" name="sft" value="" id="sft"
                                    placeholder="">
                            </div>
                        </div>

                    </div>
                    <div class="text-center">
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
