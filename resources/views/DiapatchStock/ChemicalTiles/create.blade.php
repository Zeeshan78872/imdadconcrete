@extends('layouts.app')

@section('style')
    <style>
        .card {
            margin-top: 70px;
        }



        .addMore-icon {
            border: 1px solid white;
            border-radius: 75%;
            padding: 2px 3px;
        }

        .btn-primary:hover .addMore-icon {
            border-color: #0f256e;
        }

        .top-left {
            line-height: 30px;
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
            <a href="{{ route('DchemicalTiles.index') }}" class="btn btn-primary">View All Dispatched Records</a>
        @endcomponent
        <div class="row">
            <div class="col-12 col-md-auto  top-left">
                <span>Add Dispatched Chemical Concrete Pavers Stock Details (Create Bilti)</span>
            </div>

            {{-- <div class="col-6 col-md-auto  text-md-end top-right top-right-content">
                <a href="#" class="a-link">Dashboard</a>
                <span class="ms-3">Add Tuff Tiles Dispatch Stock</span>
            </div> --}}
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
                                <label for="biltiNo" class="form-label">Bilti No.<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control bg-light @error('biltiNo') is-invalid @enderror"
                                    name="biltiNo" readonly
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
                                <label for="date" class="form-label">Date<sup class="text-danger"><b>*</b></sup></label>
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
                                <label for="searchableSelect" class="form-label">Customer Name<sup
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
                                        <strong>The customer name field is required .
                                        </strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="destination_city" class="form-label">Destination City or Area<sup
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
                                <label for="vehicle_type" class="form-label">Vehicle Type<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <select class="form-select form-select-md @error('vehicle_type') is-invalid @enderror"
                                    name="vehicle_type" id="vehicle_type">
                                    <option value="">Choose Vehicle Type</option>
                                    <option value="Pickup">Pickup</option>
                                    <option value="Masds">Masds</option>
                                    <option value="Truck">Truck</option>
                                    <option value="Trala">Trala</option>
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
                                <label for="vehicle_no" class="form-label">Vehicle Number<sup
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

                    </div>


                    <div class="row my-2 bg-light py-2">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="itemSelect_-1" class="form-label">Product Name <sup
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
                                        <strong>The product name field is required.</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="showSize_-1" class="form-label">Size <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <select id="showSize_-1"
                                    class="form-select form-select-md @error('size.0') is-invalid @enderror"
                                    name="size[]" id="size">
                                    <option value="">Choose Size</option>
                                </select>
                                @error('size.0')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>The size field is required.</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="sft_ratio-1" class="form-label">SFT Ratio<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control @error('sft_ratio.0') is-invalid @enderror"
                                    name="sft_ratio[]" value="{{ old('sft_ratio.0') }}" onchange="ChangeSstTtiles(-1)"
                                    id="sft_ratio-1" placeholder="">
                                @error('sft_ratio.0')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>The SFT ratio field is required.</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="total_tiles-1" class="form-label">Total Tiles<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control @error('total_tiles.0') is-invalid @enderror"
                                    onchange="ChangeSstTtiles(-1)" value="{{ old('total_tiles.0') }}"
                                    name="total_tiles[]" id="total_tiles-1" placeholder="">
                                @error('total_tiles.0')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>The total tiles field is required.</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="red_qty" class="form-label">Red color Qty<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control @error('red_qty.0') is-invalid @enderror"
                                    name="red_qty[]" id="red_qty" value="{{ old('red_qty.0') }}" placeholder="">
                                @error('red_qty.0')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>The red color qty field is required.</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="grey_qty" class="form-label">Grey color Qty<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control @error('grey_qty.0') is-invalid @enderror"
                                    name="grey_qty[]" id="grey_qty" value="{{ old('grey_qty.0') }}" placeholder="">
                                @error('grey_qty.0')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>The grey color qty field is required.</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="black_qty" class="form-label">Black color Qty<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control @error('black_qty.0') is-invalid value="{{ old('black_qty.0') }}" @enderror" name="black_qty[]" id="black_qty"
                                    placeholder="">
                                    @error('black_qty.0')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>The black color qty field is required.</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="yellow_qty" class="form-label">Yellow color Qty<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control @error('yellow_qty.0') is-invalid value="{{ old('yellow_qty.0') }}" @enderror" name="yellow_qty[]" id="yellow_qty"
                                    placeholder="">
                                    @error('yellow_qty.0')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>The yellow color qty field is required.</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="white_qty" class="form-label">White color Qty<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control @error('white_qty.0') is-invalid value="{{ old('white_qty.0') }}" @enderror" name="white_qty[]" id="white_qty"
                                    placeholder="">
                                    @error('white_qty.0')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>The white color qty field is required.</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="tile_sft-1" class="form-label">Tiles in SFT<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control @error('tile_sft.0') is-invalid @enderror"
                                    name="tile_sft[]" readonly id="tile_sft-1" value="{{ old('tile_sft.0') }}"
                                    placeholder="">
                                @error('tile_sft.0')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>The tiles in sft field is required.</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="price_sft-1" class="form-label">Price per SFT<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number"
                                    class="form-control number-input @error('price_sft.0') is-invalid @enderror"
                                    onchange="CalTotalPrice(-1)" name="price_sft[]" id="price_sft-1" placeholder="">
                                @error('price_sft.0')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>The price per sft field is required.</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="price_total-1" class="form-label">Total Price<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number"
                                    class="form-control number-input @error('price_total.0') is-invalid @enderror"
                                    readonly name="price_total[]" id="price_total-1" placeholder="">
                                @error('price_total.0')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>The total price field is required.</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3 d-flex align-items-center">
                            <button type="button" class="btn btn-primary" onclick="addNewProductSet()"><span
                                    class="addMore-icon"><i class="fa-solid fa-plus"></i></span> Add More Product</button>
                        </div>
                    </div>
                    <input type="hidden" name="productCount" id="productCount" value="{{ old('productCount', 0) }}">
                    @php
                        $productCount = old('productCount');
                    @endphp
                    <div id="productField">
                        @for ($i = 0; $i < $productCount; $i++)
                            @php
                                $old = $i + 1;
                            @endphp
                            <div class="row my-2 bg-light py-2" id="field_{{ $i }}">
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
                                                <strong>The product name field is required.</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="showSize_{{ $i }}" class="form-label">Size <sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <select id="showSize_{{ $i }}"
                                            class="form-select form-select-md @error('size.' . $old) is-invalid @enderror"
                                            name="size[]" id="size">
                                            <option value="">Choose Size</option>
                                        </select>
                                        @error('size.' . $old)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>The size field is required.</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="sft_ratio{{ $i }}" class="form-label">SFT Ratio<sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <input type="text"
                                            class="form-control @error('sft_ratio.' . $old) is-invalid @enderror"
                                            name="sft_ratio[]" value="{{ old('sft_ratio.' . $old) }}"
                                            onchange="ChangeSstTtiles({{ $i }})"
                                            id="sft_ratio{{ $i }}" placeholder="">
                                        @error('sft_ratio.' . $old)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>The SFT ratio field is required.</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="total_tiles{{ $i }}" class="form-label">Total Tiles<sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <input type="number"
                                            class="form-control @error('total_tiles.' . $old) is-invalid @enderror"
                                            onchange="ChangeSstTtiles({{ $i }})"
                                            value="{{ old('total_tiles.' . $old) }}" name="total_tiles[]"
                                            id="total_tiles{{ $i }}" placeholder="">
                                        @error('total_tiles.' . $old)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>The total tiles field is required.</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="red_qty" class="form-label">Red color Qty<sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <input type="number"
                                            class="form-control @error('red_qty.' . $old) is-invalid @enderror"
                                            name="red_qty[]" id="red_qty" value="{{ old('red_qty.' . $old) }}"
                                            placeholder="">
                                        @error('red_qty.' . $old)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>The red color qty field is required.</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="grey_qty" class="form-label">Grey color Qty<sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <input type="number"
                                            class="form-control @error('grey_qty.' . $old) is-invalid @enderror"
                                            name="grey_qty[]" id="grey_qty" value="{{ old('grey_qty.' . $old) }}"
                                            placeholder="">
                                        @error('grey_qty.' . $old)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>The grey color qty field is required.</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="black_qty" class="form-label">Black color Qty<sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <input type="number"
                                            class="form-control @error('black_qty.' . $old) is-invalid @enderror"
                                            name="black_qty[]" id="black_qty" value="{{ old('black_qty.' . $old) }}"
                                            placeholder="">
                                        @error('black_qty.' . $old)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>The black color qty field is required.</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="yellow_qty" class="form-label">Yellow color Qty<sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <input type="number"
                                            class="form-control @error('yellow_qty.' . $old) is-invalid @enderror"
                                            name="yellow_qty[]" id="yellow_qty" value="{{ old('yellow_qty.' . $old) }}"
                                            placeholder="">
                                        @error('yellow_qty.' . $old)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>The yellow color qty field is required.</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="white_qty" class="form-label">White color Qty<sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <input type="number"
                                            class="form-control @error('white_qty.' . $old) is-invalid @enderror"
                                            name="white_qty[]" id="white_qty" value="{{ old('white_qty.' . $old) }}"
                                            placeholder="">
                                        @error('white_qty.' . $old)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>The white color qty field is required.</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="tile_sft{{ $i }}" class="form-label">Tiles in SFT<sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <input type="text"
                                            class="form-control @error('tile_sft.' . $old) is-invalid @enderror"
                                            name="tile_sft[]" readonly id="tile_sft{{ $i }}"
                                            value="{{ old('tile_sft.' . $old) }}" placeholder="">
                                        @error('tile_sft.' . $old)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>The tiles in sft field is required.</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="price_sft{{ $i }}" class="form-label">Price per SFT<sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <input type="number"
                                            class="form-control number-input @error('price_sft.' . $old) is-invalid @enderror"
                                            onchange="CalTotalPrice({{ $i }})" name="price_sft[]"
                                            id="price_sft{{ $i }}" placeholder="">
                                        @error('price_sft.' . $old)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>The price per sft field is required.</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="price_total{{ $i }}" class="form-label">Total Price<sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <input type="number"
                                            class="form-control number-input @error('price_total.' . $old) is-invalid @enderror"
                                            readonly name="price_total[]" id="price_total{{ $i }}"
                                            placeholder="">
                                        @error('price_total.' . $old)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>The total price field is required.</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 d-flex align-items-center">
                                    <button class="btn btn-danger" type="button"
                                        onclick="removeField('field_{{ $i }}')"><i
                                            class="fa-solid fa-xmark"></i></button>
                                </div>
                        @endfor
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>

    <script>
        $('#searchableSelect').select2({});

        function ChangeSstTtiles(count) {
            let sft_ratio = document.getElementById('sft_ratio' + count);
            let total_tiles = document.getElementById('total_tiles' + count);
            let tile_sft = document.getElementById('tile_sft' + count);

            if (total_tiles.value.trim() !== '' && sft_ratio.value.trim() !== '') {
                let Total_tile_sft = parseInt(total_tiles.value) / parseInt(sft_ratio.value);
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

            let Total_price = parseInt(tile_sft.value) * parseInt(price_sft.value);
            price_total.value = Total_price;
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
        //  To add multiple field in form
        const productCountElement = document.getElementById('productCount');
        let productCount = parseInt(productCountElement.value, 10);

        function addNewProductSet() {
            const productField = document.getElementById('productField');

            // Create a new product row
            const newProductRow = document.createElement('div');
            newProductRow.classList.add('row', 'my-2',
                'bg-light',
                'py-2');
            newProductRow.setAttribute("id", `field_${productCount}`);
            // Your original structure (without the button)
            newProductRow.innerHTML = `
            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="itemSelect_${productCount}" class="form-label">Product Name <sup
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
                                    <label for="showSize_${productCount}" class="form-label">Size <sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <select id="showSize_${productCount}"class="form-select  form-select-md"  name="size[]" id="">
                                        <option selected>Choose Size</option>
                                    </select>
                                </div>
                            </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="sft_ratio${productCount}" class="form-label">SFT Ratio<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control" name="sft_ratio[]" onchange="ChangeSstTtiles(${productCount})" id="sft_ratio${productCount}"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="total_tiles${productCount}" class="form-label">Total Tiles<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control "  onchange="ChangeSstTtiles(${productCount})" name="total_tiles[]"
                                    id="total_tiles${productCount}" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="red_qty" class="form-label">Red color Qty<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control " name="red_qty[]"
                                    id="total_tiles" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="grey_qty" class="form-label">Grey color Qty<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control " name="grey_qty[]"
                                    id="total_tiles" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="black_qty" class="form-label">Black color Qty<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control " name="black_qty[]" id="black_qty"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="yellow_qty" class="form-label">Yellow color Qty<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control " name="yellow_qty[]" id="yellow_qty"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="white_qty" class="form-label">White color Qty<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control " name="white_qty[]" id="white_qty"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="tile_sft${productCount}" class="form-label">Tiles in SFT<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control " readonly name="tile_sft[]" id="tile_sft${productCount}"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="price_sft${productCount}" class="form-label">Price per SFT<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control number-input${productCount}" onchange="CalTotalPrice(${productCount})"  name="price_sft[]" id="price_sft${productCount}"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="price_total${productCount}" class="form-label">Total Price<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control number-input${productCount}" readonly name="price_total[]"
                                    id="price_total${productCount}" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-3 d-flex align-items-center">
                            <button class="btn btn-danger" type="button" onclick="removeField('field_${productCount}')"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                            `;

            productField.appendChild(newProductRow);
            var inputElements = document.querySelectorAll(".number-input" + productCount);
            inputElements.forEach(function(inputElement) {
                applyInputBehavior(inputElement);
            });
            productCount++;
            productCountElement.value = productCount;
        }

        function removeField(fieldId) {
            const productField = document.getElementById('productField');

            let fieldToRemove = document.getElementById(fieldId);
            productField.removeChild(fieldToRemove);
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
