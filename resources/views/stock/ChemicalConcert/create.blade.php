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
                                <label for="date" class="form-label text-blod">Date <sup
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
                                <label for="cement_pack" class="form-label text-blod">Cement Packs <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number"
                                    class="form-control number-input  @error('cement_pack') is-invalid @enderror"
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
                        <input type="hidden" name="productCount" id="productCount" value="{{ old('productCount', 0) }}">
                        @php
                            $productCount = old('productCount');
                            $old = 0;
                        @endphp
                        <div id="productField">
                            @for ($i = 0; $i < $productCount; $i++)
                                <div class="row bg-light py-2 my-3 product-div" id="field_{{ $i }}">
                                    <div class="col-md-4  pt-1">
                                        <div class="mb-3">
                                            <label for="product_type_{{ $i }}"
                                                class="form-label text-blod">Product Type<sup
                                                    class="text-danger"><b>*</b></sup></label>
                                            <select
                                                class="form-select form-select-md @error('product_type.' . $old) is-invalid @enderror"
                                                name="product_type[]" id="product_type_{{ $i }}"
                                                onchange="getProductName({{ $i }})">
                                                <option value="">Choose Product Type</option>
                                                @foreach ($productTypes as $type)
                                                    <option {{ old('product_type.' . $old) == $type ? 'selected' : '' }}
                                                        value="{{ $type }}">
                                                        {{ $type }}</option>
                                                @endforeach
                                            </select>
                                            @error('product_type.' . $old)
                                                <span class="invalid-feedback mt-2" role="alert">
                                                    <strong>Product Type is required.</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="itemSelect_{{ $i }}"
                                                class="form-label text-blod">Product
                                                Name
                                                <sup class="text-danger"><b>*</b></sup></label>
                                            <select id="itemSelect_{{ $i }}"
                                                onchange="ItemChange({{ $i }})"
                                                class="form-select  form-select-md @error('product_id.' . $old) is-invalid @enderror"
                                                name="product_id[]" id="">
                                                <option value="">Choose Product Name</option>
                                                @if (old('product_type.' . $old))
                                                    @foreach ($products as $product)
                                                        @if ($product->product_type == old('product_type.' . $old))
                                                            <option
                                                                {{ old('product_id.' . $old) == $product->id ? 'selected' : '' }}
                                                                value="{{ $product->id }}">{{ $product->name }}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('product_id.' . $old)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>Product Name is required </strong>
                                                </span>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="showSize_{{ $i }}" class="form-label text-blod">Size
                                                <sup class="text-danger"><b>*</b></sup></label>
                                            <select id="showSize_{{ $i }}"
                                                class="form-select @error('size.' . $old) is-invalid @enderror"
                                                onchange="SelectQuantity({{ $i }})" name="size[]">
                                                <option value="">Choose Size</option>
                                                @if (old('product_id.' . $old))
                                                    @foreach ($sizes as $size)
                                                        @if ($size->product_id == old('product_id.' . $old))
                                                            <option
                                                                {{ old('size.' . $old) == $size->id ? 'selected' : '' }}
                                                                value="{{ $size->id }}">{{ $size->size }}</option>
                                                        @endif
                                                    @endforeach
                                                @endif

                                            </select>
                                            @error('size.' . $old)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>Size is required </strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="total_farma{{ $i }}" class="form-label text-blod">Total
                                                Farms
                                                <sup class="text-danger"><b>*</b></sup></label>
                                            <input type="number"
                                                class="form-control number-input @error('total_farma.' . $old) is-invalid @enderror"
                                                name="total_farma[]" onchange="TotalFarmaChange({{ $i }})"
                                                id="total_farma{{ $i }}"
                                                value="{{ old('total_farma.' . $old) }}" aria-describedby="helpId"
                                                placeholder="">
                                            @error('total_farma.' . $old)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>Total Farms is required </strong>
                                                </span>
                                            @enderror
                                            <input type="hidden" class="quantity_farma"
                                                id="quantity_farma_{{ $i }}"
                                                onchange="TotalFarmaChange({{ $i }})"
                                                value="{{ old('quantity_farma.' . $old) }}" name="quantity_farma[]">
                                            <input type="hidden" class="sft_ratio"
                                                onchange="TotalFarmaChange({{ $i }})"
                                                id="sft_ratio{{ $i }}" value="{{ old('sft_ratio.' . $old) }}"
                                                name="sft_ratio[]">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="quantity_sft{{ $i }}"
                                                class="form-label text-blod">Quantity in
                                                SFT
                                                <sup class="text-danger"><b>*</b></sup></label>
                                            <input type="text"
                                                class="form-control non-edit-able @error('quantity_sft.' . $old) is-invalid @enderror"
                                                name="quantity_sft[]" readonly
                                                value="{{ old('quantity_sft.' . $old, 0) }}"
                                                id="quantity_sft{{ $i }}" aria-describedby="helpId"
                                                placeholder="">
                                            @error('quantity_sft.' . $old)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>Quantity in SFT is required </strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-1 d-flex align-items-center justify-content-center">
                                        <button class="btn btn-danger remove-button" type="button"
                                            onclick="removeField('field_{{ $i }}',{{ $i }})"><i
                                                class="fa-solid fa-xmark"></i></button>
                                    </div>
                                </div>
                                @php
                                    $old++;
                                @endphp
                            @endfor
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="total_stock_sft" class="form-label text-blod">Total Stock in SFT <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control number-input non-edit-able" readonly
                                    name="total_stock_sft" id="total_stock_sft" aria-describedby="helpId"
                                    value="{{ old('total_stock_sft', 0) }}" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-12 my-4">
                            <button type="button" class="btn btn-primary" onclick="addNewProductSet()"> <span><i
                                        class="fa-solid fa-plus"></i></span> Add
                                More Product</button><button type="reset"
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
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
                            <div class="col-md-4  pt-1">
                                <div class="mb-3">
                                    <label for="product_type_${productCount}" class="form-label text-blod">Product Type<sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <select class="form-select form-select-md @error('product_type') is-invalid @enderror" name="product_type[]"
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
                                    <label for="" class="form-label text-blod">Product Name <sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <select id="itemSelect_${productCount}" onchange="ItemChange(${productCount})"  class="form-select  form-select-md" name="product_id[]" id="">
                                        <option value="">Choose Product Name</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="showSize_${productCount}" class="form-label text-blod">Size <sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <select id="showSize_${productCount}" class="form-select " onchange="SelectQuantity(${productCount})"  name="size[]">
                                        <option value="">Choose Size</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="total_farma${productCount}" class="form-label text-blod">Total Farms <sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <input type="number" class="form-control number-input" name="total_farma[]" onchange="TotalFarmaChange(${productCount})"  id="total_farma${productCount}"
                                        aria-describedby="helpId" placeholder="">
                                        <input type="hidden" class="quantity_farma" name="quantity_farma[]" id="quantity_farma_${productCount}" onchange="TotalFarmaChange(${productCount})" value="" name="">
                                        <input type="hidden" class="sft_ratio" name="sft_ratio[]" onchange="TotalFarmaChange(${productCount})" id="sft_ratio${productCount}" value=""
                                        name="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="quantity_sft${productCount}" class="form-label text-blod">Quantity in SFT <sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <input type="number" readonly class="form-control number-input non-edit-able" name="quantity_sft[]"   value="0" id="quantity_sft${productCount}"
                                        aria-describedby="helpId" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-1 d-flex align-items-center justify-content-center">
                                <button class="btn btn-danger remove-button" type="button" onclick="removeField('field_${productCount}','quantity_sft${productCount}')"><i class="fa-solid fa-xmark"></i></button>
                            </div>`;
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
            productField.appendChild(newProductRow);
            var inputElements = document.querySelectorAll(".number-input");
            inputElements.forEach(function(inputElement) {
                applyInputBehavior(inputElement);
            });


            getLastProductDiv();
        }
        const productCountElement = document.getElementById('productCount');
        let productCount = parseInt(productCountElement.value, 10);
        if (productCount == 0) {
            window.addEventListener('load', addNewProductSet);
        }
        getLastProductDiv();

        // getLastProductDiv();
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
            const productCountElementt = document.getElementById('productCount');
            let productCountt = parseInt(productCountElementt.value, 10);
            const productField = document.getElementById('productField');
            removeftomTotalQty(count);

            let fieldToRemove = document.getElementById(fieldId);
            productField.removeChild(fieldToRemove);
            getLastProductDiv();
            productCountElementt.value = productCountt - 1;
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
            console.log(quantity_farma);
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
        // fetch size
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
