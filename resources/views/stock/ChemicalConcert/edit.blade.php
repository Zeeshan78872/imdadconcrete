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

        <div class="row">
            <div class="col-6 col-md-auto  top-left">
                <span>Edit Chemical Concrete Pavers Stock</span>
            </div>

            {{-- <div class="col-6 col-md-auto  text-md-end top-right top-right-content">
                <a href="#" class="a-link">Dashboard</a>
                <span class="ms-3">Add Chemical Concert Products Stock</span>
            </div> --}}
        </div>
        <div class="card stockCard shadow-2-strong bg-white  py-2 px-3">
            <div class="card-header bg-white text-center">
                <h4 class="page-title">Edit Chemical Concrete Pavers Stock Details</h4>
            </div>
            <div class="card-body">


                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('chemicalTiles.update', $stocks->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="date" class="form-label text-blod">Date <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="date" class="form-control  @error('date') is-invalid @enderror"
                                    name="date" id="date" value="{{ old('date', $stocks->date) }}" placeholder="">
                                @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="cement_pack" class="form-label text-blod">Cement Packs <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number"
                                    class="form-control number-input @error('cement_pack') is-invalid @enderror"
                                    name="cement_pack" value="{{ old('cement_pack', $stocks->cement_packs) }}"
                                    id="cement_pack" placeholder="">
                                @error('cement_pack')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- products -->
                    <div id='already_field'>
                        @foreach ($stocks->products as $index => $product)
                            @php
                                $count = $stocks->products->count();
                            @endphp
                            <input type="hidden" name="deletefield[]" value="" id="deletefield_{{ $product->id }}">
                            <div class="row bg-light py-2 mask-001 my-2 product-div" id="field_{{ $product->id }}">
                                <input type="hidden" name="stockproduct[]" value="{{ $product->id }}">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="product_type_{{ $product->id }}" class="form-label text-blod">Product
                                            Type<sup class="text-danger"><b>*</b></sup></label>
                                        <select
                                            class="form-select form-select-md @error('product_type') is-invalid @enderror"
                                            name="product_type[]" id="product_type_{{ $product->id }}"
                                            onchange="getProductName({{ $product->id }})">
                                            <option value="">Choose Product Type</option>
                                            @foreach ($productTypes as $type)
                                                <option
                                                    {{ old('product_type.' . $index, $product->product_type) == $type ? 'selected' : '' }}
                                                    value="{{ $type }}">
                                                    {{ $type }}</option>
                                            @endforeach
                                        </select>
                                        @error('product_type')
                                            <span class="invalid-feedback mt-2" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="itemSelect" class="form-label text-blod">Product Name <sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <select id="itemSelect_{{ $product->id }}"
                                            onchange="ItemChange({{ $product->id }})"
                                            class="form-select itemSelect form-select-md @error('product_id.' . $index) is-invalid @enderror"
                                            name="product_id[]">
                                            <option value="">Choose Product Name</option>
                                            @foreach ($products as $productname)
                                                <option
                                                    {{ old('product_id.' . $index, $product->product_id) == $productname->id ? 'selected' : '' }}
                                                    value="{{ $productname->id }}">{{ $productname->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('product_id.' . $index)
                                            <span class="invalid-feedback" role="alert">
                                                <strong> Product Name is required </strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="showSize_-1" class="form-label text-blod">Size <sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <select id="showSize_{{ $product->id }}"
                                            class="form-select showSize form-select-md @error('size.' . $index) is-invalid @enderror"
                                            onchange="SelectQuantity({{ $product->id }})" name="size[]" id="">
                                            <option value="">Choose Size</option>
                                            @foreach ($sizes as $size)
                                                @if ($size->product_id == old('product_id.' . $index, $product->product_id))
                                                    <option
                                                        {{ old('size.' . $index, $product->size_id) == $size->id ? 'selected' : '' }}
                                                        value="{{ $size->id }}">{{ $size->size }}</option>
                                                    @if (old('size.' . $index, $product->size_id) == $size->id)
                                                        @php
                                                            $qty_farma = $size->quantity_farma;
                                                            $sft_ratio = $size->sft;
                                                        @endphp
                                                    @endif
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('size.' . $index)
                                            <span class="invalid-feedback" role="alert">
                                                <strong> Size is required </strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="total_farma{{ $product->id }}" class="form-label text-blod">Total
                                            Farms <sup class="text-danger"><b>*</b></sup></label>
                                        <input type="number"
                                            class="form-control number-input @error('total_farma.' . $index) is-invalid @enderror"
                                            name="total_farma[]" onchange="TotalFarmaChange({{ $product->id }})"
                                            value="{{ old('total_farma.' . $index, $product->total_farma) }}"
                                            id="total_farma{{ $product->id }}" aria-describedby="helpId" placeholder="">
                                        @error('total_farma.' . $index)
                                            <span class="invalid-feedback" role="alert">
                                                <strong> Total Farms is required </strong>
                                            </span>
                                        @enderror
                                        <input type="hidden" class="quantity_farma"
                                            onchange="TotalFarmaChange({{ $product->id }})"
                                            id="quantity_farma_{{ $product->id }}"
                                            value="{{ old('quantity_farma.' . $index, $qty_farma ?? '') }}"
                                            name="quantity_farma[]">
                                        <input type="hidden" class="sft_ratio"
                                            onchange="TotalFarmaChange({{ $product->id }})"
                                            id="sft_ratio{{ $product->id }}"
                                            value="{{ old('sft_ratio.' . $index, $sft_ratio ?? '') }}"
                                            name="sft_ratio[]">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="quantity_sft{{ $product->id }}"
                                            class="form-label text-blod">Quantity in SFT
                                            <sup class="text-danger"><b>*</b></sup></label>
                                        <input type="text"
                                            class="form-control bg-light @error('quantity_sft.' . $index) is-invalid @enderror"
                                            readonly name="quantity_sft[]" id="quantity_sft{{ $product->id }}"
                                            aria-describedby="helpId"
                                            value="{{ old('quantity_sft.' . $index, $product->quentity_sft) }}"
                                            placeholder="">
                                        @error('quantity_sft.' . $index)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                @if ($index + 1 == $count)
                                @else
                                @endif
                                <div class="col-md-1 d-flex align-items-center justify-content-center">
                                    <button class="btn btn-danger remove-button" type="button"
                                        onclick="removeAlreadyField({{ $product->id }},'quantity_sft{{ $product->id }}')"><i
                                            class="fa-solid fa-xmark"></i></button>
                                </div>
                            </div>
                        @endforeach
                        <input type="hidden" name="productCount" id="productCount"
                            value="{{ old('productCount', 0) }}">
                        @php
                            $productCount = old('productCount');
                        @endphp
                        <div id="productField">
                            @for ($i = 0; $i < $productCount; $i++)
                                @php
                                    // $old = $i + 1;
                                @endphp
                                <div class="row bg-light py-2 my-3 product-div" id="field_{{ $i }}">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="product_type_{{ $i }}"
                                                class="form-label text-blod">Product
                                                Type<sup class="text-danger"><b>*</b></sup></label>
                                            <select
                                                class="form-select form-select-md @error('newproduct_type.' . $i) is-invalid @enderror"
                                                name="newproduct_type[]" id="product_type_{{ $i }}"
                                                onchange="getProductName({{ $i }})">
                                                <option value="">Choose Product Type</option>
                                                @foreach ($productTypes as $type)
                                                    <option
                                                        {{ old('newproduct_type.' . $i, $product->product_type) == $type ? 'selected' : '' }}
                                                        value="{{ $type }}">
                                                        {{ $type }}</option>
                                                @endforeach
                                            </select>
                                            @error('newproduct_type.' . $i)
                                                <span class="invalid-feedback mt-2" role="alert">
                                                    <strong>Product Type is required.</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="itemSelect_{{ $i }}"
                                                class="form-label text-blod">Product Name
                                                <sup class="text-danger"><b>*</b></sup></label>
                                            <select id="itemSelect_{{ $i }}"
                                                onchange="ItemChange({{ $i }})"
                                                class="form-select  form-select-md @error('newproduct_id.' . $i) is-invalid @enderror"
                                                name="newproduct_id[]" id="">
                                                <option value="">Choose Product Name</option>


                                                @if (old('newproduct_type.' . $i))
                                                    @foreach ($products as $product)
                                                        @if ($product->product_type == old('newproduct_type.' . $old))
                                                            <option
                                                                {{ old('newproduct_id.' . $i) == $product->id ? 'selected' : '' }}
                                                                value="{{ $product->id }}">{{ $product->name }}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('newproduct_id.' . $i)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong> Product Name is required </strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="showSize_{{ $i }}" class="form-label text-blod">Size
                                                <sup class="text-danger"><b>*</b></sup></label>
                                            <select id="showSize_{{ $i }}"
                                                class="form-select @error('newsize.' . $i) is-invalid @enderror"
                                                onchange="SelectQuantity({{ $i }})" name="newsize[]">
                                                <option value="">Choose Size</option>
                                                @if (old('newproduct_id.' . $i))
                                                    @foreach ($sizes as $size)
                                                        @if ($size->product_id == old('newproduct_id.' . $i))
                                                            <option
                                                                {{ old('newsize.' . $i) == $size->id ? 'selected' : '' }}
                                                                value="{{ $size->id }}">{{ $size->size }}</option>
                                                            @if (old('newsize.' . $i) == $size->id)
                                                                @php
                                                                    $qty_farma = $size->quantity_farma;
                                                                    $sft_ratio = $size->sft;
                                                                @endphp
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endif

                                            </select>
                                            @error('newsize.' . $i)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong> Size is required </strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="total_farma{{ $i }}"
                                                class="form-label text-blod">Total Farms
                                                <sup class="text-danger"><b>*</b></sup></label>
                                            <input type="number"
                                                class="form-control number-input @error('newtotal_farma.' . $i) is-invalid @enderror"
                                                name="newtotal_farma[]" onchange="TotalFarmaChange({{ $i }})"
                                                id="total_farma{{ $i }}"
                                                value="{{ old('newtotal_farma.' . $i) }}" aria-describedby="helpId"
                                                placeholder="">
                                            @error('newtotal_farma.' . $i)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong> Total Farms is required </strong>
                                                </span>
                                            @enderror
                                            <input type="hidden" class="quantity_farma"
                                                id="quantity_farma_{{ $i }}"
                                                onchange="TotalFarmaChange({{ $i }})"
                                                value="{{ old('newquantity_farma.' . $i) }}" name="newquantity_farma[]">
                                            <input type="hidden" class="sft_ratio"
                                                onchange="TotalFarmaChange({{ $i }})"
                                                id="sft_ratio{{ $i }}"
                                                value="{{ old('newsft_ratio.' . $i) }}" name="newsft_ratio[]">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="quantity_sft{{ $i }}"
                                                class="form-label text-blod">Quantity in
                                                SFT
                                                <sup class="text-danger"><b>*</b></sup></label>
                                            <input type="text"
                                                class="form-control bg-light @error('newquantity_sft.' . $i) is-invalid @enderror"
                                                name="newquantity_sft[]" value="{{ old('newquantity_sft.' . $i, 0) }}"
                                                id="quantity_sft{{ $i }}" aria-describedby="helpId"
                                                placeholder="">
                                            @error('newquantity_sft.' . $i)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }} </strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-1 d-flex align-items-center justify-content-center">
                                        <button class="btn btn-danger remove-button" type="button"
                                            onclick="removeField('field_{{ $i }}','quantity_sft{{ $i }}')"><i
                                                class="fa-solid fa-xmark"></i></button>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="total_stock_sft" class="form-label text-blod">Total Stock in SFT <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control bg-light" readonly name="total_stock_sft"
                                    id="total_stock_sft" aria-describedby="helpId"
                                    value="{{ old('total_stock_sft', $stocks->total_stock) }}" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-12 my-4">
                            <button type="button" class="btn btn-primary" onclick="addNewProductSet()">
                                <span><i class="fa-solid fa-plus"></i></span> Add
                                More Product</button>
                            <button type="reset"
                                class="btn btn-light text-primary btn-rest rounded-0 mx-3 my-2">Reset</button>
                            <button type="submit" class="btn btn-primary rounded-0  my-2">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
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

        // console.log(productCount);

        function addNewProductSet() {
            const productCountElement = document.getElementById('productCount');
            let productCount = parseInt(productCountElement.value, 10);
            const productField = document.getElementById('productField');

            // Create a new product row
            const newProductRow = document.createElement('div');
            newProductRow.classList.add('row', 'bg-light', 'py-2', 'my-3', 'product-div');
            newProductRow.setAttribute("id", `field_${productCount}`);

            // Your original structure (without the button)
            newProductRow.innerHTML = `
            <div class="col-md-4 ">
                                <div class="mb-3">
                                    <label for="product_type_${productCount}" class="form-label text-blod">Product Type<sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <select class="form-select form-select-md @error('product_type') is-invalid @enderror" name="newproduct_type[]"
                                        id="product_type_${productCount}"  onchange="getProductName(${productCount})" >
                                        <option value="">Choose Product Type</option>
                                        @foreach ($productTypes as $type)
                                            <option {{ old('product_type') == $type ? 'selected' : '' }} value="{{ $type }}">
                                                {{ $type }}</option>
                                        @endforeach
                                    </select>
                                    @error('product_type')
                                        <span class="invalid-feedback mt-2" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="itemSelect_${productCount}" class="form-label text-blod">Product Name <sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <select id="itemSelect_${productCount}" onchange="ItemChange(${productCount})"  class="form-select  form-select-md" name="newproduct_id[]" id="">
                                        <option value="">Choose Product Name</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="showSize_${productCount}" class="form-label text-blod">Size <sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <select id="showSize_${productCount}" class="form-select " onchange="SelectQuantity(${productCount})"  name="newsize[]">
                                        <option value="">Choose Size</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="total_farma${productCount}" class="form-label text-blod">Total Farms <sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <input type="number" class="form-control number-input"  name="newtotal_farma[]" onchange="TotalFarmaChange(${productCount})"  id="total_farma${productCount}"
                                        aria-describedby="helpId" placeholder="">
                                        <input type="hidden" class="quantity_farma" name="newquantity_farma[]" id="quantity_farma_${productCount}" onchange="TotalFarmaChange(${productCount})" value="" name="">
                                        <input type="hidden" class="sft_ratio" name="newsft_ratio[]" onchange="TotalFarmaChange(${productCount})" id="sft_ratio${productCount}" value=""
                                        name="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="quantity_sft${productCount}" class="form-label text-blod">Quantity in SFT <sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <input type="number" class="form-control number-input bg-light" name="newquantity_sft[]"   value="0" id="quantity_sft${productCount}"
                                        aria-describedby="helpId" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-1 d-flex align-items-center justify-content-center">
                                <button class="btn btn-danger remove-button" type="button" onclick="removeField('field_${productCount}','quantity_sft${productCount}')"><i class="fa-solid fa-xmark"></i></button>
                            </div>`;
            productCount++;
            productCountElement.value = productCount;
            productField.appendChild(newProductRow);
            var inputElements = document.querySelectorAll(".number-input");
            inputElements.forEach(function(inputElement) {
                applyInputBehavior(inputElement);
            });
            getLastProductDiv();
        }

        function removeftomTotalQty(count) {
            console.log(count);
            let total_stock_sft = $('#total_stock_sft');
            let quantity_sft = document.getElementById(count).value;
            console.log(quantity_sft);
            if (quantity_sft) {
                let old_quantity_sft = quantity_sft;
                old_quantity_sft = parseInt(old_quantity_sft);

                let old_total_stock = parseInt(total_stock_sft.val());
                console.log(old_total_stock);
                console.log(quantity_sft);

                total_stock_sft.val(old_total_stock - old_quantity_sft);
                console.log(old_total_stock - old_quantity_sft);
            } else {
                console.log("Element not found for count: " + count);
            }
        }

        function removeField(fieldId, count) {
            removeftomTotalQty(count);

            const productCountElementt = document.getElementById('productCount');
            let productCountt = parseInt(productCountElementt.value, 10);
            const productCountElement = document.getElementById('productCount');
            productCountElement.value = parseInt(productCountElement.value) - 1;
            const productField = document.getElementById('productField');
            let fieldToRemove = document.getElementById(fieldId);
            productField.removeChild(fieldToRemove);
            getLastProductDiv();
            productCountElementt.value = productCountt - 1;

        }



        function removeAlreadyField(fieldId, count) {
            const already_field = document.getElementById('already_field');
            const deletefield = document.getElementById('deletefield_' + fieldId);
            console.log(fieldId);
            removeftomTotalQty(count);
            if (deletefield) {
                deletefield.value = fieldId;
                console.log(deletefield.value);

                let fieldToRemove = document.getElementById('field_' + fieldId);
                if (fieldToRemove) {
                    already_field.removeChild(fieldToRemove);
                }
            }
            getLastProductDiv();
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
        // fetch product name
        function getProductName(productCount) {
            const typeToFetch = $('#product_type_' + productCount).val();
            const url = window.location.origin + '/fetchproductName/' + typeToFetch;
            $('#itemSelect_' + productCount).empty();
            $('#itemSelect_' + productCount).append('<option>Choose Product Name</option>')
            $('#showSize_' + productCount).empty();
            $('#showSize_' + productCount).append('<option value="">Choose Size</option>')
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $.each(response, function(index, value) {
                        $('#itemSelect_' + productCount).append('<option value="' + value['id'] +
                            '">' + value['name'] + '</option>');
                    });
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
            if (quantity_farma !== null && quantity_farma.trim() !== '') {

                let quantity_farma_val = quantity_farma ? parseInt(quantity_farma) : 1;
                let total_farma_val = total_farma ? parseInt(total_farma) : 1;
                let sft_ratio_val = sft_ratio ? parseInt(sft_ratio) : 1;

                // Calculate the total
                let total = (total_farma_val * quantity_farma_val) / sft_ratio_val;

                // Assign the calculated total to the 'quantity_sft' input field
                total = Math.round(total); // Round off to nearest integer
                if (total_farma !== null && total_farma.trim() !== '' && quantity_farma !== null && quantity_farma.trim !==
                    '') {
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
        // $(document).ready(function() {
        //     $('.itemSelect').on('change', function() {
        //         const idToFetch = $(this).val();
        //         const url = window.location.origin + '/fetchSize/' + idToFetch;
        //         $('.showSize').empty();
        //         $('.showSize').append('<option value="">Choose Size</option>')
        //         $.ajax({
        //             url: url,
        //             type: 'GET',
        //             dataType: 'json',
        //             success: function(response) {
        //                 $.each(response, function(index, value) {
        //                     $('.showSize').append('<option value="' + value['id'] +
        //                         '">' + value['size'] + '</option>');
        //                 });
        //             },
        //             error: function(xhr, status, error) {
        //                 console.error(error);
        //             }
        //         });
        //     });
        // });
    </script>
@endsection
