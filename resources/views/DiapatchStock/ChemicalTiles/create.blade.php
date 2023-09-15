@extends('layouts.app')

@section('style')
    <style>
        .card {
            margin-top: 95px;
        }

        .addMore-icon {
            border: 1px solid white;
            border-radius: 75%;
            padding: 2px 3px;
        }

        .btn-primary:hover .addMore-icon {
            border-color: #0f256e;
        }

        span#select2-itemSelect_-1-container {

            width: 100%;
            padding: 0.375rem 2.25rem 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: var(--bs-body-color);
            background-color: var(--bs-body-bg);
            background-image: var(--bs-form-select-bg-img), var(--bs-form-select-bg-icon, none);
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
            border: var(--bs-border-width) solid var(--bs-border-color);
            border-radius: var(--bs-border-radius);
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
    </style>
@endsection
@section('content')
    <div class="container mb-5">
        @component('components.success-model', [
            'title' => 'Dispatch Stock Added Successfully ',
            'desc' => 'A dispatched chemical concrete pavers stock record has been added to the list',
            'closeText' => 'Close',
        ])
            <a href="{{ route('DchemicalTiles.index') }}" class="btn btn-primary col my-1">View Bilti</a>
            <a href="{{ route('DchemicalTiles.index') }}" class="btn btn-primary col my-1">Print Bilti</a>
            <a href="{{ route('DchemicalTiles.index') }}" class="btn btn-primary col my-1">Download pdf</a>
            <a href="{{ route('DchemicalTiles.index') }}" class="btn btn-primary col my-1">View All Dispatched Records</a>
        @endcomponent

        <div class="row">
            <div class="col-12 col-md-auto  top-left">
                <span>Add Dispatched Chemical Concrete Pavers Stock Details (Create Bilti)</span>
            </div>
        </div>
        <div class="card stockCard shadow-2-strong bg-white  py-2 px-3">
            <div class="card-header bg-white text-center">
                <h4 class="page-title">Enter Bilti Details</h4>
            </div>
            <div class="card-body">


                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('DchemicalTiles.store') }}">
                    @csrf
                    <div class="row my-2">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="biltiNo" class="form-label text-blod">Bilti No. <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text"
                                    class="form-control non-edit-able @error('biltiNo') is-invalid @enderror" name="biltiNo"
                                    readonly
                                    value="{{ old('biltiNo', 'B' . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT)) }}"
                                    id="biltiNo" placeholder="">
                                @error('biltiNo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="date" class="form-label text-blod">Date <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror"
                                    name="date" value="{{ old('date', date('Y-m-d')) }}" id="date" placeholder="">
                                @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="searchableSelect" class="form-label text-blod">Customer Name <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <select id="searchableSelect"
                                    class="form-select form-control form-select-md @error('customer_id') is-invalid @enderror "
                                    name="customer_id">
                                    <option value="">Choose Customer</option>
                                    @foreach ($customers as $customer)
                                        <option {{ old('customer_id') == $customer->id ? 'selected' : '' }}
                                            value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <span class="invalid-feedback mt-2" role="alert">
                                        <strong> {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="searchableSelect" class="form-label text-blod">Contact Number 1 <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control @error('contactNo1') is-invalid @enderror "
                                    value="{{ old('contactNo1') }}" name="contactNo1">
                                @error('contactNo1')
                                    <span class="invalid-feedback mt-2" role="alert">
                                        <strong> {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="searchableSelect" class="form-label text-blod">Contact Number 2</label>
                                <input type="text" class="form-control @error('contactNo2') is-invalid @enderror "
                                    value="{{ old('contactNo2') }}" name="contactNo2">
                                @error('contactNo2')
                                    <span class="invalid-feedback mt-2" role="alert">
                                        <strong> {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="destination_city" class="form-label text-blod">Destination City or Area <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control @error('destination_city') is-invalid @enderror"
                                    name="destination_city" value="{{ old('destination_city') }}" id="destination_city"
                                    placeholder="">
                                @error('destination_city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="vehicle_type" class="form-label text-blod">Vehicle Type <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <select class="form-select form-select-md @error('vehicle_type') is-invalid @enderror"
                                    name="vehicle_type" id="vehicle_type">
                                    <option value="">Choose Vehicle Type</option>
                                    @foreach ($vehicle_types as $types)
                                        <option {{ old('vehicle_type') == $types ? 'selected' : '' }}
                                            value="{{ $types }}">{{ $types }}</option>
                                    @endforeach
                                </select>
                                @error('vehicle_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="vehicle_no" class="form-label text-blod">Vehicle Number <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control @error('vehicle_no') is-invalid @enderror"
                                    name="vehicle_no" value="{{ old('vehicle_no') }}" id="vehicle_no" placeholder="">
                                @error('vehicle_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label text-blod">Driver Name</label>
                                <input type="text" class="form-control @error('driverName') is-invalid @enderror "
                                    value="{{ old('driverName') }}" name="driverName">
                                @error('driverName')
                                    <span class="invalid-feedback mt-2" role="alert">
                                        <strong> {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="productCount" id="productCount" value="{{ old('productCount', 0) }}">
                    @php
                        $productCount = old('productCount');
                    @endphp
                    <div id="productField">
                        <div class="row my-2 bg-light py-2 product-div" id="field_-1">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="itemSelect_-1" class="form-label text-blod">Product Name <sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <select id="itemSelect_-1"
                                        class="form-select form-select-md @error('product_id.0') is-invalid @enderror"
                                        onchange="ItemChange(-1)" name="product_id[]" id="product_name">
                                        <option value="">Choose Product Name</option>
                                        @foreach ($products as $product)
                                            <option {{ old('product_id.0') == $product->id ? 'selected' : '' }}
                                                value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('product_id.0')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> Product Name is required.</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="showSize_-1" class="form-label text-blod">Size <sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <select id="showSize_-1"
                                        class="form-select form-select-md @error('size.0') is-invalid @enderror"
                                        name="size[]" id="size">
                                        <option value="">Choose Size</option>
                                        @foreach ($sizes as $size)
                                            @if ($size->product_id == old('product_id.0'))
                                                <option {{ old('size.0') == $size->id ? 'selected' : '' }}
                                                    value="{{ $size->id }}">{{ $size->size }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('size.0')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> Size is required.</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="sft_ratio-1" class="form-label text-blod">SFT Ratio <sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <input type="text"
                                        class="form-control number-input @error('sft_ratio.0') is-invalid @enderror"
                                        name="sft_ratio[]" value="{{ old('sft_ratio.0') }}"
                                        onchange="ChangeSstTtiles(-1)"
                                        id="sft_ratio-1"onkeyup="setupnumValid('sft_ratio-1')" placeholder="">
                                    @error('sft_ratio.0')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }} </strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="total_tiles-1" class="form-label text-blod">Total Tiles <sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <input type="number"
                                        class="form-control number-input @error('total_tiles.0') is-invalid @enderror"
                                        onchange="ChangeSstTtiles(-1)" value="{{ old('total_tiles.0') }}"
                                        name="total_tiles[]" id="total_tiles-1" placeholder="">
                                    @error('total_tiles.0')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> Total Tiles is required.</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="red_qty" class="form-label text-blod">Red color Qty </label>
                                    <input type="number"
                                        class="form-control number-input @error('red_qty.0') is-invalid @enderror"
                                        name="red_qty[]" id="red_qty" value="{{ old('red_qty.0') }}" placeholder="">
                                    @error('red_qty.0')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> red color qty is required.</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="grey_qty" class="form-label text-blod">Grey color Qty </label>
                                    <input type="number"
                                        class="form-control number-input @error('grey_qty.0') is-invalid @enderror"
                                        name="grey_qty[]" id="grey_qty" value="{{ old('grey_qty.0') }}"
                                        placeholder="">
                                    @error('grey_qty.0')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> grey color qty is required.</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="black_qty" class="form-label text-blod">Black color Qty</label>
                                    <input type="number"
                                        class="form-control number-input @error('black_qty.0') is-invalid  @enderror "value="{{ old('black_qty.0') }}"
                                        name="black_qty[]" id="black_qty" placeholder="">
                                    @error('black_qty.0')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> black color qty is required.</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="yellow_qty" class="form-label text-blod">Yellow color Qty</label>
                                    <input type="number"
                                        class="form-control number-input @error('yellow_qty.0') is-invalid  @enderror "value="{{ old('yellow_qty.0') }}"
                                        name="yellow_qty[]" id="yellow_qty" placeholder="">
                                    @error('yellow_qty.0')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> yellow color qty is required.</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="white_qty" class="form-label text-blod">White color Qty</label>
                                    <input type="number"
                                        class="form-control number-input @error('white_qty.0') is-invalid  @enderror"
                                        value="{{ old('white_qty.0') }}" name="white_qty[]" id="white_qty"
                                        placeholder="">
                                    @error('white_qty.0')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> white color qty is required.</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="tile_sft-1" class="form-label text-blod">Tiles in SFT <sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <input type="number"
                                        class="form-control non-edit-able number-input @error('tile_sft.0') is-invalid @enderror"
                                        name="tile_sft[]" readonly id="tile_sft-1" value="{{ old('tile_sft.0') }}"
                                        placeholder="">
                                    @error('tile_sft.0')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> Tiles in sft is required.</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="price_sft-1" class="form-label text-blod">Price per SFT <sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <input type="text"
                                        class="form-control number-input @error('price_sft.0') is-invalid @enderror"
                                        onchange="CalTotalPrice(-1)" onkeyup="setupnumValid('price_sft-1')"
                                        value="{{ old('price_sft.0', 0) }}" name="price_sft[]" id="price_sft-1"
                                        placeholder="">
                                    @error('price_sft.0')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> Price Per Sft is required.</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="price_total-1" class="form-label text-blod">Total Price <sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <input type="number"
                                        class="form-control number-input non-edit-able @error('price_total.0') is-invalid @enderror"
                                        readonly name="price_total[]" value="{{ old('price_total.0', 0) }}"
                                        id="price_total-1" placeholder="">
                                    @error('price_total.0')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> Total Price is required.</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 d-flex align-items-center">
                                <button class="btn btn-danger remove-button" type="button"
                                    onclick="removeField('field_-1')"><i class="fa-solid fa-xmark"></i></button>

                            </div>
                        </div>
                        @for ($i = 0; $i < $productCount; $i++)
                            @php
                                $old = $i + 1;
                            @endphp

                            <div class="row my-2 bg-light py-2 product-div" id="field_{{ $i }}">
                                <style>
                                    span#select2-itemSelect_{{ $i }}-container {
                                        width: 100%;
                                        padding: 0.375rem 2.25rem 0.375rem 0.75rem;
                                        font-size: 1rem;
                                        font-weight: 400;
                                        line-height: 1.5;
                                        color: var(--bs-body-color);
                                        background-color: var(--bs-body-bg);
                                        background-image: var(--bs-form-select-bg-img), var(--bs-form-select-bg-icon, none);
                                        background-repeat: no-repeat;
                                        background-position: right 0.75rem center;
                                        background-size: 16px 12px;
                                        border: var(--bs-border-width) solid var(--bs-border-color);
                                        border-radius: var(--bs-border-radius);
                                        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
                                        -webkit-appearance: none;
                                        -moz-appearance: none;
                                        appearance: none;
                                    }
                                </style>
                                <script>
                                    $('#itemSelect_{{ $i }}').select2({});
                                </script>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="itemSelect_{{ $i }}" class="form-label">Product Name <sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <select id="itemSelect_{{ $i }}"
                                            class="form-select form-select-md @error('product_id.' . $old) is-invalid @enderror"
                                            onchange="ItemChange({{ $i }})" name="product_id[]"
                                            id="product_name">
                                            <option value="">Choose Product Name</option>
                                            @foreach ($products as $product)
                                                <option {{ old('product_id.' . $old) == $product->id ? 'selected' : '' }}
                                                    value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('product_id.0')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> product name is required.</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="showSize_{{ $i }}" class="form-label text-blod">Size <sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <select id="showSize_{{ $i }}"
                                            class="form-select form-select-md @error('size.' . $old) is-invalid @enderror"
                                            name="size[]" id="size">
                                            <option value="">Choose Size</option>
                                            @foreach ($sizes as $size)
                                                @if ($size->product_id == old('product_id.' . $old))
                                                    <option {{ old('size.' . $old) == $size->id ? 'selected' : '' }}
                                                        value="{{ $size->id }}">{{ $size->size }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('size.' . $old)
                                            <span class="invalid-feedback" role="alert">
                                                <strong> Size is required.</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="sft_ratio{{ $i }}" class="form-label text-blod">SFT
                                            Ratio <sup class="text-danger"><b>*</b></sup></label>
                                        <input type="text"
                                            class="form-control number-input @error('sft_ratio.' . $old) is-invalid @enderror"
                                            name="sft_ratio[]" value="{{ old('sft_ratio.' . $old) }}"
                                            onchange="ChangeSstTtiles({{ $i }})"
                                            id="sft_ratio{{ $i }}"
                                            onkeyup="setupnumValid('sft_ratio{{ $i }}')" placeholder="">
                                        @error('sft_ratio.' . $old)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="total_tiles{{ $i }}" class="form-label text-blod">Total
                                            Tiles <sup class="text-danger"><b>*</b></sup></label>
                                        <input type="number"
                                            class="form-control number-input @error('total_tiles.' . $old) is-invalid @enderror"
                                            onchange="ChangeSstTtiles({{ $i }})"
                                            value="{{ old('total_tiles.' . $old) }}" name="total_tiles[]"
                                            id="total_tiles{{ $i }}" placeholder="">
                                        @error('total_tiles.' . $old)
                                            <span class="invalid-feedback" role="alert">
                                                <strong> Total Tiles is required.</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="red_qty" class="form-label text-blod">Red color Qty</label>
                                        <input type="number"
                                            class="form-control number-input @error('red_qty.' . $old) is-invalid @enderror"
                                            name="red_qty[]" id="red_qty" value="{{ old('red_qty.' . $old) }}"
                                            placeholder="">
                                        @error('red_qty.' . $old)
                                            <span class="invalid-feedback" role="alert">
                                                <strong> red color qty is required.</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="grey_qty" class="form-label text-blod">Grey color Qty</label>
                                        <input type="number"
                                            class="form-control number-input @error('grey_qty.' . $old) is-invalid @enderror"
                                            name="grey_qty[]" id="grey_qty" value="{{ old('grey_qty.' . $old) }}"
                                            placeholder="">
                                        @error('grey_qty.' . $old)
                                            <span class="invalid-feedback" role="alert">
                                                <strong> grey color qty is required.</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="black_qty" class="form-label text-blod">Black color Qty</label>
                                        <input type="number"
                                            class="form-control number-input @error('black_qty.' . $old) is-invalid @enderror"
                                            name="black_qty[]" id="black_qty" value="{{ old('black_qty.' . $old) }}"
                                            placeholder="">
                                        @error('black_qty.' . $old)
                                            <span class="invalid-feedback" role="alert">
                                                <strong> black color qty is required.</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="yellow_qty" class="form-label text-blod">Yellow color Qty</label>
                                        <input type="number"
                                            class="form-control number-input @error('yellow_qty.' . $old) is-invalid @enderror"
                                            name="yellow_qty[]" id="yellow_qty" value="{{ old('yellow_qty.' . $old) }}"
                                            placeholder="">
                                        @error('yellow_qty.' . $old)
                                            <span class="invalid-feedback" role="alert">
                                                <strong> yellow color qty is required.</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="white_qty" class="form-label text-blod">White color Qty</label>
                                        <input type="number"
                                            class="form-control number-input @error('white_qty.' . $old) is-invalid @enderror"
                                            name="white_qty[]" id="white_qty" value="{{ old('white_qty.' . $old) }}"
                                            placeholder="">
                                        @error('white_qty.' . $old)
                                            <span class="invalid-feedback" role="alert">
                                                <strong> white color qty is required.</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="tile_sft{{ $i }}" class="form-label text-blod">Tiles in
                                            SFT <sup class="text-danger"><b>*</b></sup></label>
                                        <input type="number"
                                            class="form-control number-input non-edit-able @error('tile_sft.' . $old) is-invalid @enderror"
                                            name="tile_sft[]" readonly id="tile_sft{{ $i }}"
                                            value="{{ old('tile_sft.' . $old) }}" placeholder="">
                                        @error('tile_sft.' . $old)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="price_sft{{ $i }}" class="form-label text-blod">Price per
                                            SFT <sup class="text-danger"><b>*</b></sup></label>
                                        <input type="text"
                                            class="form-control number-input @error('price_sft.' . $old) is-invalid @enderror"
                                            onchange="CalTotalPrice({{ $i }})"
                                            onkeyup="setupnumValid('price_sft{{ $i }}')"
                                            value="{{ old('price_sft.' . $old, 0) }}" name="price_sft[]"
                                            id="price_sft{{ $i }}" placeholder="">
                                        @error('price_sft.' . $old)
                                            <span class="invalid-feedback" role="alert">
                                                <strong> Price Per Sft is required.</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="price_total{{ $i }}" class="form-label text-blod">Total
                                            Price <sup class="text-danger"><b>*</b></sup></label>
                                        <input type="number"
                                            class="form-control non-edit-able number-input @error('price_total.' . $old) is-invalid @enderror"
                                            readonly name="price_total[]" value="{{ old('price_total.' . $old, 0) }}"
                                            id="price_total{{ $i }}" placeholder="">
                                        @error('price_total.' . $old)
                                            <span class="invalid-feedback" role="alert">
                                                <strong> Total Price is required.</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 d-flex align-items-center">
                                    <button class="btn btn-danger remove-button" type="button"
                                        onclick="removeField('field_{{ $i }}')"><i
                                            class="fa-solid fa-xmark"></i></button>
                                </div>
                            </div>
                        @endfor
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-primary" onclick="addNewProductSet()"><span
                                class="addMore-icon"><i class="fa-solid fa-plus"></i></span> Add More Product</button>
                        <button type="button" class="btn btn-light text-primary btn-rest mx-3">Reset</button>
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
        $(document).ready(function() {
            // Initialize Select2 after the dynamic fields are generated
            $('[id^="itemSelect_"]').select2();
        });

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

        function getLastProductDiv() {
            const productDivs = document.querySelectorAll('.product-div');
            const countDiv = productDivs.length;
            const firstProductDiv = document.querySelector('.remove-button:first-of-type');
            if (countDiv == 1) {
                firstProductDiv.style.display = 'none'
            } else {
                firstProductDiv.style.display = 'block'
            }
        }
        getLastProductDiv();
        $('#searchableSelect').select2({});
        $('#itemSelect_-1').select2({});


        function ChangeSstTtiles(count) {
            let sft_ratio = document.getElementById('sft_ratio' + count);
            let total_tiles = document.getElementById('total_tiles' + count);
            let tile_sft = document.getElementById('tile_sft' + count);

            if (total_tiles.value.trim() !== '' && sft_ratio.value.trim() !== '') {
                let Total_tile_sft = parseInt(total_tiles.value) / parseFloat(sft_ratio.value);
                Total_tile_sft = Math.round(Total_tile_sft); // Round off to nearest integer
                tile_sft.value = Total_tile_sft;
                console.log(Total_tile_sft);
                CalTotalPrice(count);
            }

        }

        function CalTotalPrice(count) {
            let price_sft = document.getElementById('price_sft' + count);
            let tile_sft = document.getElementById('tile_sft' + count);

            let price_total = document.getElementById('price_total' + count);

            let Total_price = parseInt(tile_sft.value) * parseFloat(price_sft.value);
            price_total.value = Math.round(Total_price);
        }


        //  To add multiple in form
        const productCountElement = document.getElementById('productCount');
        let productCount = parseInt(productCountElement.value, 10);

        function addNewProductSet() {
            const productCountElement = document.getElementById('productCount');
            let productCount = parseInt(productCountElement.value, 10);
            const productField = document.getElementById('productField');

            // Create a new product row
            const newProductRow = document.createElement('div');
            newProductRow.classList.add('row', 'my-2',
                'bg-light',
                'py-2', 'product-div');
            newProductRow.setAttribute("id", `field_${productCount}`);
            // Your original structure (without the button)
            newProductRow.innerHTML = `
            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="itemSelect_${productCount}" class="form-label text-blod">Product Name <sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <select id="itemSelect_${productCount}" onchange="ItemChange(${productCount})"  class="form-select  form-select-md" name="product_id[]" id="">
                                        <option value="">Choose Product Name</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="showSize_${productCount}" class="form-label text-blod">Size <sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <select id="showSize_${productCount}"class="form-select  form-select-md"  name="size[]" id="">
                                        <option selected>Choose Size</option>
                                    </select>
                                </div>
                            </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="sft_ratio${productCount}" class="form-label text-blod">SFT Ratio <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control number-input" name="sft_ratio[]" onchange="ChangeSstTtiles(${productCount})" id="sft_ratio${productCount}" onkeyup="setupnumValid('sft_ratio${productCount}')"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="total_tiles${productCount}" class="form-label text-blod">Total Tiles <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control number-input"  onchange="ChangeSstTtiles(${productCount})" name="total_tiles[]"
                                    id="total_tiles${productCount}" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="red_qty" class="form-label text-blod">Red color Qty</label>
                                <input type="number" class="form-control number-input" name="red_qty[]"
                                    id="total_tiles" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="grey_qty" class="form-label text-blod">Grey color Qty</label>
                                <input type="number" class="form-control number-input" name="grey_qty[]"
                                    id="total_tiles" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="black_qty" class="form-label text-blod">Black color Qty</label>
                                <input type="number" class="form-control number-input" name="black_qty[]" id="black_qty"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="yellow_qty" class="form-label text-blod">Yellow color Qty</label>
                                <input type="number" class="form-control number-input" name="yellow_qty[]" id="yellow_qty"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="white_qty" class="form-label text-blod">White color Qty</label>
                                <input type="number" class="form-control number-input" name="white_qty[]" id="white_qty"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="tile_sft${productCount}" class="form-label text-blod">Tiles in SFT <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control non-edit-able number-input" readonly name="tile_sft[]" id="tile_sft${productCount}"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="price_sft${productCount}" class="form-label text-blod">Price per SFT <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control number-input" onchange="CalTotalPrice(${productCount})" onkeyup="setupnumValid('price_sft${productCount}')" value="0"  name="price_sft[]" id="price_sft${productCount}"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="price_total${productCount}" class="form-label text-blod">Total Price <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control bg-light number-input" readonly  value="0" name="price_total[]"
                                    id="price_total${productCount}" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-3 d-flex align-items-center">
                            <button class="btn btn-danger remove-button" type="button" onclick="removeField('field_${productCount}')"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                            `;

            productField.appendChild(newProductRow);
            var inputElements = document.querySelectorAll(".number-input");
            inputElements.forEach(function(inputElement) {
                applyInputBehavior(inputElement);
            });
            $(`#itemSelect_${productCount}`).select2({});
            var spanId = 'select2-itemSelect_' + productCount + '-container';

            // Get the span element by its ID
            var spanElement = document.querySelector('#' + spanId);

            // Check if the element exists before applying styles
            if (spanElement) {
                // Set the style properties dynamically
                spanElement.style.width = '100%';
                spanElement.style.padding = '0.375rem 2.25rem 0.375rem 0.75rem';
                spanElement.style.fontSize = '1rem';
                spanElement.style.fontWeight = '400';
                spanElement.style.lineHeight = '1.5';
                spanElement.style.color = 'var(--bs-body-color)';
                spanElement.style.backgroundColor = 'var(--bs-body-bg)';
                spanElement.style.backgroundImage = 'var(--bs-form-select-bg-img), var(--bs-form-select-bg-icon, none)';
                spanElement.style.backgroundRepeat = 'no-repeat';
                spanElement.style.backgroundPosition = 'right 0.75rem center';
                spanElement.style.backgroundSize = '16px 12px';
                spanElement.style.border = 'var(--bs-border-width) solid var(--bs-border-color)';
                spanElement.style.borderRadius = 'var(--bs-border-radius)';
                spanElement.style.transition = 'border-color .15s ease-in-out, box-shadow .15s ease-in-out';
                spanElement.style.webkitAppearance = 'none';
                spanElement.style.mozAppearance = 'none';
                spanElement.style.appearance = 'none';
            }
            productCount++;
            productCountElement.value = productCount;
            getLastProductDiv();

        }

        function removeField(fieldId) {
            const productCountElementt = document.getElementById('productCount');
            let productCountt = parseInt(productCountElementt.value, 10);
            const productField = document.getElementById('productField');

            let fieldToRemove = document.getElementById(fieldId);
            productField.removeChild(fieldToRemove);
            getLastProductDiv();
            productCountElementt.value = productCountt - 1;
        }

        function ItemChange(productCount) {
            const idToFetch = $('#itemSelect_' + productCount).val();
            const url = window.location.origin + '/fetchSize/' + idToFetch;
            $('#showSize_' + productCount).empty();
            $('#showSize_' + productCount).append('<option value="">Choose Size</option>')
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $.each(response, function(index, value) {
                        $('#showSize_' + productCount).append('<option value="' + value['id'] +
                            '">' + value['size'] + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    </script>
@endsection
