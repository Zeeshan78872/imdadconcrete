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
    </style>
@endsection
@section('content')
    <div class="container mb-5">
        @component('components.success-model', [
            'title' => 'Stock Added Successfully',
            'desc' => 'A new stock entry has been added to the list',
            'closeText' => 'Close',
        ])
            <a href="{{ route('tuffTile.index') }}" class="btn btn-primary">View All Stock</a>
        @endcomponent
        <div class="row mb-2">
            <div class="col-6 col-md-auto  top-left">
                <span>Add Tuff Tiles & Block Stock</span>
            </div>
        </div>
        <div class="card stockCard shadow-2-strong bg-white  py-2 px-3">
            <div class="card-header bg-white text-center">
                <h4 class="page-title">Enter Tuff Tiles & Block Stock Details</h4>
            </div>
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('tuffTile.store') }}">
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
                    </div>


                    <input type="hidden" name="productCount" id="productCount" value="{{ old('productCount', 0) }}">
                    <div id="productField">
                        @php
                            $productCount = old('productCount');
                            $old = 0;
                        @endphp
                        @for ($i = 0; $i < $productCount; $i++)
                            <div class="row bg-light py-2 mb-2 product-div" id="field_{{ $i }}">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="" class="form-label text-blod">Plant Name<sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <select id=""
                                            class="form-select  form-select-md   @error('product_id.' . $old) is-invalid @enderror"
                                            name="plant_name[]" id="">
                                            <option value="">Choose Plant Name</option>
                                            @foreach ($PlantName as $name)
                                                <option {{ old('plant_name.' . $old) == $name ? 'selected' : '' }}
                                                    value="{{ $name }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        @error('plant_name.' . $old)
                                            <span class="invalid-feedback" role="alert">
                                                <strong> Plant Name is required</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="itemSelect_{{ $i }}" class="form-label text-blod">Product
                                            Name <sup class="text-danger"><b>*</b></sup></label>
                                        <select id="itemSelect_{{ $i }}"
                                            onchange="ItemChange({{ $i }})"
                                            class="form-select  form-select-md   @error('product_id.' . $old) is-invalid @enderror"
                                            name="product_id[]" id="">
                                            <option value="">Choose Product Name</option>
                                            @foreach ($products as $product)
                                                <option {{ old('product_id.' . $old) == $product->id ? 'selected' : '' }}
                                                    value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('product_id.' . $old)
                                            <span class="invalid-feedback" role="alert">
                                                <strong> Product Name is required</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="showSize_{{ $i }}" class="form-label text-blod">Size <sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <select
                                            id="showSize_{{ $i }}"class="form-select  form-select-md   @error('size.' . $old) is-invalid @enderror"
                                            onchange="SelectQuantity(-1)" name="size[]" id="">
                                            <option value="">Choose Size</option>
                                            @if (old('product_id.' . $old) && old('product_id.' . $old) != null)
                                                @foreach ($sizes as $size)
                                                    @if ($size->product_id == old('product_id.' . $old))
                                                        <option {{ old('size.' . $old) == $size->id ? 'selected' : '' }}
                                                            value="{{ $size->id }}">{{ $size->size }}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('size.' . $old)
                                            <span class="invalid-feedback" role="alert">
                                                <strong> Size is required</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="cement_pack" class="form-label text-blod">Cement Packs <sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <input type="number"
                                            class="form-control number-input  @error('cement_pack.' . $old) is-invalid @enderror "
                                            value="{{ old('cement_pack.' . $old) }}" name="cement_pack[]" id="cement_pack"
                                            placeholder="">
                                        @error('cement_pack.' . $old)
                                            <span class="invalid-feedback" role="alert">
                                                <strong> Cement Packs is required</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="pallet_no{{ $i }}" class="form-label text-blod">No. of
                                            Pallets <sup class="text-danger"><b>*</b></sup></label>
                                        <input type="number"
                                            class="form-control number-input   @error('pallet_no.' . $old) is-invalid @enderror "
                                            name="pallet_no[]" id="pallet_no{{ $i }}"
                                            value="{{ old('pallet_no.' . $old) }}"
                                            onchange="NewCalculateTiles({{ $i }})" placeholder="">
                                        @error('pallet_no.' . $old)
                                            <span class="invalid-feedback" role="alert">
                                                <strong> No. of Pallets is required</strong>
                                            </span>
                                        @enderror
                                        <input type="hidden" value="{{ old('sft_ratio.' . $old) }}" name="sft_ratio[]"
                                            id="sft_ratio{{ $i }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="tiles{{ $i }}" class="form-label text-blod">Tiles / Pallet
                                            <sup class="text-danger"><b>*</b></sup></label>
                                        <input type="number"
                                            class="form-control number-input  @error('cement_pack.' . $old) is-invalid @enderror"
                                            name="tiles_pallet[]" id="tiles{{ $i }}"
                                            value="{{ old('tiles_pallet.' . $old) }}"
                                            onchange="NewCalculateTiles({{ $i }})" placeholder="">
                                        @error('tiles_pallet.' . $old)
                                            <span class="invalid-feedback" role="alert">
                                                <strong> Tiles / Pallet is required</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="totla_tiles" class="form-label text-blod">Total Tiles in SFT <sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <input type="number" id="total_tiles{{ $i }}"
                                            class="form-control number-input non-edit-able" name="totla_tiles[]"
                                            value="{{ old('totla_tiles.' . $old, 0) }}" readonly id="totla_tiles"
                                            placeholder="">

                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <button class="btn btn-danger remove-button" type="button"
                                        onclick="removeField('field_{{ $i }}')"><i
                                            class="fa-solid fa-xmark"></i></button>
                                </div>
                            </div>

                            @php
                                $old++;
                            @endphp
                        @endfor

                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-primary" onclick="addNewProductSet()"> <span><i
                                    class="fa-solid fa-plus"></i></span> Add
                            More Product</button>
                        <button type="reset"
                            class="btn btn-light text-primary btn-rest rounded-0 mx-3 my-2">Reset</button>
                        <button type="submit" class="btn btn-primary rounded-0 mx-1 my-2">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- Include jQuery or Axios or any other library to handle AJAX requests -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

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

        function CalculateTiles(count) {
            let no_pallet, tiles_pallet, total_tiles;
            if (count == -1) {
                no_pallet = document.getElementById('pallet_no');
                tiles_pallet = document.getElementById('tiles');
                sft_ratio = document.getElementById('sft_ratio-1');
                total_tiles = document.getElementById('total_tiles');
            } else {
                console.log('else');
                no_pallet = document.getElementById('pallet_no' + count);
                tiles_pallet = document.getElementById('tiles' + count);
                sft_ratio = document.getElementById('sft_ratio-1');

                total_tiles = document.getElementById('total_tiles' + count);
            }

            // Get values from input fields or treat them as 0 if null
            let no_pallet_value = no_pallet.value ? parseInt(no_pallet.value) : 1;
            let tiles_pallet_value = tiles_pallet.value ? parseInt(tiles_pallet.value) : 1;
            let sft_ratio_value = sft_ratio.value ? parseInt(sft_ratio.value) : 1;

            // Calculate the total
            let total = (no_pallet_value * tiles_pallet_value) / sft_ratio_value;

            // Assign the calculated total to the 'total_tiles' input field
            total = Math.round(total); // Round off to nearest integer
            total_tiles.value = total;

        }

        function NewCalculateTiles(count) {

            let no_pallet, tiles_pallet, total_tiles;
            no_pallet = document.getElementById('pallet_no' + count);
            tiles_pallet = document.getElementById('tiles' + count);
            sft_ratio = document.getElementById('sft_ratio' + count);

            total_tiles = document.getElementById('total_tiles' + count);


            // Get values from input fields or treat them as 0 if null
            let no_pallet_value = no_pallet.value ? parseInt(no_pallet.value) : 1;
            let tiles_pallet_value = tiles_pallet.value ? parseInt(tiles_pallet.value) : 1;
            let sft_ratio_value = sft_ratio.value ? parseInt(sft_ratio.value) : 1;

            // Calculate the total
            let total = (no_pallet_value * tiles_pallet_value) / sft_ratio_value;

            // Assign the calculated total to the 'total_tiles' input field
            total = Math.round(total); // Round off to nearest integer
            total_tiles.value = total;

        }


        const productCountElement = document.getElementById('productCount');
        let productCount = parseInt(productCountElement.value, 10);


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
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label text-blod">Plant Name <sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <select id="" class="form-select  form-select-md"  name="plant_name[]" id="">
                                        <option value="">Choose Plant Name</option>
                                        @foreach ($PlantName as $name)
                                        <option  value="{{ $name }}">{{ $name }}</option>
                                    @endforeach
                                    </select>
                                    @error('plant_name.*')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="itemSelect_${productCount}" class="form-label text-blod">Product Name <sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <select id="itemSelect_${productCount}" onchange="ItemChange(${productCount})" class="form-select  form-select-md" name="product_id[]" id="">
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
                                    <select id="showSize_${productCount}"class="form-select  form-select-md" onchange="SelectQuantity(${productCount})" name="size[]" id="">
                                        <option value="">Choose Size</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                            <div class="mb-3">
                                <label for="cement_pack" class="form-label text-blod">Cement Packs <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control number-input"
                                    name="cement_pack[]"  id="cement_pack"  placeholder="">

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="pallet_no${productCount}" class="form-label text-blod">No. of Pallets <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control number-input"
                                    name="pallet_no[]"  id="pallet_no${productCount}" onchange="NewCalculateTiles(${productCount})"  placeholder="">
                                    <input type="hidden" name="sft_ratio[]" value="" id="sft_ratio${productCount}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="tiles${productCount}" class="form-label text-blod">Tiles / Pallet <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control number-input "
                                    name="tiles_pallet[]"  id="tiles${productCount}" onchange="NewCalculateTiles(${productCount})"  placeholder="">

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="totla_tiles" class="form-label text-blod">Total Tiles in SFT <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" id="total_tiles${productCount}" class="form-control number-input non-edit-able "
                                    name="totla_tiles[]"  value="0" readonly  id="totla_tiles" placeholder="">

                            </div>
                        </div>
                            <div class="col-md-4 d-flex align-items-center">
                                <button class="btn btn-danger remove-button" type="button" onclick="removeField('field_${productCount}')"><i class="fa-solid fa-xmark"></i></button>
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
        if (productCount == 0) {
            window.addEventListener('load', addNewProductSet);
        }
        getLastProductDiv();

        $(document).on('focus', 'input[name^="plant_name"]', function() {
            const errorTarget = $(this).closest('.input-set').find('.invalid-feedback').data('error-target');
            $(`[data-error-target="${errorTarget}"]`).remove();
        });

        function removeField(fieldId) {
            const productCountElement = document.getElementById('productCount');
            let productCount = parseInt(productCountElement.value, 10);
            const productField = document.getElementById('productField');
            let fieldToRemove = document.getElementById(fieldId);
            productField.removeChild(fieldToRemove);
            getLastProductDiv();
            productCountElement.value = productCount - 1;

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
                    $('#sft_ratio' + Size).val(response['sft']);
                    if (Size == '-1') {
                        NewCalculateTiles(-1);
                    } else {
                        NewCalculateTiles(Size);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        function ItemChange(productCount) {
            const idToFetch = $('#itemSelect_' + productCount).val();
            const url = window.location.origin + '/fetchSize/' + idToFetch;
            $('#showSize_' + productCount).empty();
            $('#showSize_' + productCount).append('<option vlaue="">Choose Size</option>')
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
