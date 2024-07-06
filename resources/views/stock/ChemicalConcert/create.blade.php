@extends('layouts.app')

@section('style')
    <style>
        .card {
            margin-top: 133px;
        }

        @media (max-width: 767px) {
            .card {
                margin-top: 30px;
            }
        }

        .invalid-feedback {
            display: unset;
        }
    </style>
@endsection
@section('content')
    <div class="container mb-5">
        @component('components.success-model', [
            'title' => 'Stock Added Successfully',
            'desc' => 'A new stock entry has been added to the list',
            'closeText' => 'Close',
        ])
            <a href="{{ route('chemicalTiles.index') }}" class="btn btn-primary">View All Stock</a>
        @endcomponent
        <div class="row">
            <div class="col-6 col-md-auto  top-left">
                <span>Add Chemical Concrete Pavers Stock</span>
            </div>

            {{-- <div class="col-6 col-md-auto  text-md-end top-right top-right-content">
                <a href="#" class="a-link">Dashboard</a>
                <span class="ms-3">Add Chemical Concert Products Stock</span>
            </div> --}}
        </div>
        <div class="card stockCard shadow-2-strong bg-white  py-2 px-3">
            <div class="card-header bg-white text-center">
                <h4 class="page-title">Enter Chemical Concrete Pavers Stock Details</h4>
            </div>
            <div class="card-body">


                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('chemicalTiles.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="date" class="form-label">Date <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="date" class="form-control  @error('date') is-invalid @enderror"
                                    name="date" id="date" value="{{ date('Y-m-d') }}" placeholder="">
                                @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="cement_pack" class="form-label">Cement Packs <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control  @error('cement_pack') is-invalid @enderror"
                                    name="cement_pack" value="{{ old('cement_pack') }}" id="cement_pack" placeholder="">
                                @error('cement_pack')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- products -->
                    <div id='productForm'>

                        <div class="row bg-light py-2 mask-001">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="itemSelect" class="form-label">Product Name <sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <select id="itemSelect"
                                        class="form-select itemSelect form-select-md @error('product_id.0') is-invalid @enderror"
                                        name="product_id[]" id="">
                                        <option value="">Choose Product Name</option>
                                        @foreach ($products as $product)
                                            <option {{ old('product_id.0') == $product->id ? 'selected' : '' }}
                                                value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('product_id.0')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>This Product Name Field is required </strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="showSize_-1" class="form-label">Size <sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <select id="showSize_-1"
                                        class="form-select showSize form-select-md @error('size.0') is-invalid @enderror"
                                        onchange="SelectQuantity(-1)" name="size[]" id="">
                                        <option value="">Choose Size</option>
                                    </select>
                                    @error('size.0')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>This Size Field is required </strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="total_farma-1" class="form-label">Total Farms <sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <input type="number" class="form-control @error('total_farma.0') is-invalid @enderror"
                                        name="total_farma[]" onchange="TotalFarmaChange(-1)"
                                        value="{{ old('total_farma.0') }}" id="total_farma-1" aria-describedby="helpId"
                                        placeholder="">
                                    @error('total_farma.0')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>This Total Farms Field is required </strong>
                                        </span>
                                    @enderror
                                    <input type="hidden" class="quantity_farma" onchange="TotalFarmaChange(-1)"
                                        id="quantity_farma_-1" value="{{ old('quantity_farma.0') }}"
                                        name="quantity_farma[]">
                                    <input type="hidden" class="sft_ratio" onchange="TotalFarmaChange(-1)" id="sft_ratio-1"
                                        value="{{ old('sft_ratio.0') }}" name="sft_ratio[]">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="quantity_sft-1" class="form-label">Quantity in SFT <sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <input type="text"
                                        class="form-control bg-light @error('quantity_sft.0') is-invalid @enderror"
                                        readonly name="quantity_sft[]" id="quantity_sft-1" aria-describedby="helpId"
                                        value="{{ old('quantity_sft.0', 0) }}" placeholder="">
                                    @error('quantity_sft.0')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>This Quantity in SFT Field is required </strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 my-4 py-1">
                                <button type="button" class="btn btn-primary" onclick="addNewProductSet()"> <span><i
                                            class="fa-solid fa-plus"></i></span> Add
                                    More Product</button>
                            </div>
                        </div>
                        <input type="hidden" name="productCount" id="productCount"
                            value="{{ old('productCount', 0) }}">
                        @php
                            $productCount = old('productCount');
                        @endphp
                        <div id="productField">
                            @for ($i = 0; $i < $productCount; $i++)
                                @php
                                    $old = $i + 1;
                                @endphp
                                <div class="row bg-light py-2 my-3 " id="field_{{ $i }}">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="itemSelect_{{ $i }}" class="form-label">Product Name
                                                <sup class="text-danger"><b>*</b></sup></label>
                                            <select id="itemSelect_{{ $i }}"
                                                onchange="ItemChange({{ $i }})"
                                                class="form-select  form-select-md @error('product_id.'.$old) is-invalid @enderror"
                                                name="product_id[]" id="">
                                                <option value="">Choose Product Name</option>
                                                @foreach ($products as $product)
                                                    <option {{(old('product_id.'.$old)== $product->id)?'selected':''}} value="{{ $product->id }}">{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('product_id.'.$old)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>This Product Name Field is required </strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="showSize_{{ $i }}" class="form-label">Size <sup
                                                    class="text-danger"><b>*</b></sup></label>
                                            <select id="showSize_{{ $i }}"
                                                class="form-select @error('size.'.$old) is-invalid @enderror"
                                                onchange="SelectQuantity({{ $i }})" name="size[]">
                                                <option value="">Choose Size</option>
                                            </select>
                                            @error('size.'.$old)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>This Size Field is required </strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="total_farma{{ $i }}" class="form-label">Total Farms
                                                <sup class="text-danger"><b>*</b></sup></label>
                                            <input type="number"
                                                class="form-control @error('total_farma.'.$old) is-invalid @enderror"
                                                name="total_farma[]" onchange="TotalFarmaChange({{ $i }})"
                                                id="total_farma{{ $i }}" value="{{old('total_farma.'.$old)}}" aria-describedby="helpId"
                                                placeholder="">
                                            @error('total_farma.'.$old)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>This Total Farms Field is required </strong>
                                                </span>
                                            @enderror
                                            <input type="hidden" class="quantity_farma"
                                                id="quantity_farma_{{ $i }}"
                                                onchange="TotalFarmaChange({{ $i }})" value="{{old('quantity_farma.'.$old)}}"
                                                name="quantity_farma[]">
                                            <input type="hidden" class="sft_ratio"
                                                onchange="TotalFarmaChange({{ $i }})"
                                                id="sft_ratio{{ $i }}" value="{{old('sft_ratio.'.$old)}}" name="sft_ratio[]">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="quantity_sft{{ $i }}" class="form-label">Quantity in
                                                SFT
                                                <sup class="text-danger"><b>*</b></sup></label>
                                            <input type="text"
                                                class="form-control bg-light @error('quantity_sft.'.$old) is-invalid @enderror"
                                                name="quantity_sft[]" value="{{old('quantity_sft.'.$old,0)}}"
                                                id="quantity_sft{{ $i }}" aria-describedby="helpId"
                                                placeholder="">
                                            @error('quantity_sft.'.$old)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>This Quantity in SFT Field is required </strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-center justify-content-center">
                                        <button class="btn btn-danger" type="button"
                                            onclick="removeField('field_{{ $i }}')"><i
                                                class="fa-solid fa-xmark"></i></button>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="total_stock_sft" class="form-label">Total Stock in SFT <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control bg-light" readonly name="total_stock_sft"
                                    id="total_stock_sft" aria-describedby="helpId" value="{{old('total_stock_sft',0)}}" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4 my-4"><button type="reset"
                                class="btn btn-light text-primary btn-rest rounded-0 mx-1 my-2">Reset</button>
                            <button type="submit" class="btn btn-primary rounded-0 mx-1 my-2">Submit</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        const productCountElement = document.getElementById('productCount');
        let productCount = parseInt(productCountElement.value, 10);
        // console.log(productCount);

        function addNewProductSet() {
            const productField = document.getElementById('productField');

            // Create a new product row
            const newProductRow = document.createElement('div');
            newProductRow.classList.add('row', 'bg-light', 'py-2', 'my-3');
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
                                    <select id="showSize_${productCount}" class="form-select " onchange="SelectQuantity(${productCount})"  name="size[]">
                                        <option value="">Choose Size</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="total_farma${productCount}" class="form-label">Total Farms <sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <input type="number" class="form-control" name="total_farma[]" onchange="TotalFarmaChange(${productCount})"  id="total_farma${productCount}"
                                        aria-describedby="helpId" placeholder="">
                                        <input type="hidden" class="quantity_farma" name="quantity_farma[]" id="quantity_farma_${productCount}" onchange="TotalFarmaChange(${productCount})" value="" name="">
                                        <input type="hidden" class="sft_ratio" name="sft_ratio[]" onchange="TotalFarmaChange(${productCount})" id="sft_ratio${productCount}" value=""
                                        name="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="quantity_sft${productCount}" class="form-label">Quantity in SFT <sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <input type="text" class="form-control bg-light" name="quantity_sft[]"   value="0" id="quantity_sft${productCount}"
                                        aria-describedby="helpId" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-center justify-content-center">
                                <button class="btn btn-danger" type="button" onclick="removeField('field_${productCount}')"><i class="fa-solid fa-xmark"></i></button>
                            </div>`;
            productCount++;
            productCountElement.value = productCount;
            productField.appendChild(newProductRow);
        }

        function removeField(fieldId) {
            const productField = document.getElementById('productField');

            let fieldToRemove = document.getElementById(fieldId);
            productField.removeChild(fieldToRemove);
        }

        function SelectQuantity(Size) {
            const size_id = $('#showSize_' + Size).val();
            const url = window.location.origin + '/fetchQuantity/' + size_id;
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // console.log(response['quantity_farma']);
                    $('#quantity_farma_' + Size).val(response['quantity_farma']);
                    $('#sft_ratio' + Size).val(response['sft']);

                    TotalFarmaChange(Size);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        function TotalFarmaChange(count) {
            let total_farma = $('#total_farma' + count).val();
            let quantity_farma = $('#quantity_farma_' + count).val();
            let sft_ratio = $('#sft_ratio' + count).val();

            let quantity_sft = $('#quantity_sft' + count);
            let old_quantity_sft = parseInt(quantity_sft.val());

            let quantity_farma_val = quantity_farma ? parseInt(quantity_farma) : 1;
            let total_farma_val = total_farma ? parseInt(total_farma) : 1;
            let sft_ratio_val = sft_ratio ? parseInt(sft_ratio) : 1;

            // Calculate the total
            let total = (total_farma_val * quantity_farma_val) / sft_ratio_val;

            // Assign the calculated total to the 'quantity_sft' input field
            total = Math.round(total); // Round off to nearest integer
            if (total_farma !== null && total_farma.trim() !== '') {
                quantity_sft.val(total);
            }

            // Calculate the new total stock value
            let total_stock_sft = $('#total_stock_sft');
            let old_total_stock = parseInt(total_stock_sft.val()); // Parse as an integer
            let new_total_stock = 0;
            old_total_stock -= old_quantity_sft;
            new_total_stock = old_total_stock + total;

            // Update the 'total_stock_sft' input field
            if (total_farma !== null && total_farma.trim() !== '') {

                total_stock_sft.val(new_total_stock);
            }
        }

        function ItemChange(productCount) {
            const idToFetch = $('#itemSelect_' + productCount).val();
            const url = window.location.origin + '/fetchSize/' + idToFetch;
            $('#showSize_' + productCount).empty();
            $('#showSize_' + productCount).append('<option>Choose Size</option>')
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
        $(document).ready(function() {
            $('.itemSelect').on('change', function() {
                const idToFetch = $(this).val();
                const url = window.location.origin + '/fetchSize/' + idToFetch;
                $('.showSize').empty();
                $('.showSize').append('<option value="">Choose Size</option>')
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $.each(response, function(index, value) {
                            $('.showSize').append('<option value="' + value['id'] +
                                '">' + value['size'] + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
@endsection
