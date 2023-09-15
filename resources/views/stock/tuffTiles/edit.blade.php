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

        <div class="row mb-2">
            <div class="col-6 col-md-auto  top-left">
                <span>Edit Tuff Tiles & Block Stock</span>
            </div>
        </div>

        <div class="card stockCard shadow-2-strong bg-white  py-2 px-3">
            <div class="card-header bg-white text-center">
                <h4 class="page-title">Edit Tuff Tiles & Block Stock Details</h4>
            </div>
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('tuffTile.update', $stocks->id) }}">
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
                    </div>
                    <div id="already_field">
                        @foreach ($stocks->products as $index => $product)
                            @php
                                $count = $stocks->products->count();
                            @endphp
                            <input type="hidden" name="deletefield[]" value="" id="deletefield_{{ $product->id }}">
                            <div class="row bg-light py-2 mb-2 product-div" id="field_{{ $product->id }}">

                                <input type="hidden" name="stockproduct[]" value="{{ $product->id }}">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="plant_name" class="form-label text-blod">Plant Name <sup
                                                class="text-danger"><b>*</b></sup> </label>
                                        <select
                                            class="form-select form-select-md  @error('plant_name.' . $index) is-invalid @enderror"
                                            name="plant_name[]" id="plant_name">
                                            <option value="">Choose Plant Name</option>
                                            @foreach ($PlantName as $name)
                                                <option
                                                    {{ old('plant_name.' . $index, $product->plant_name) == $name ? 'selected' : '' }}
                                                    value="{{ $name }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        @error('plant_name.' . $index)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>Plant name is required</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="itemSelect_-1" class="form-label text-blod">Product Name <sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <select id="itemSelect_{{ $product->id }}"
                                            class="form-select form-select-md @error('product_id.' . $product->id) is-invalid @enderror"
                                            onchange="ItemChange({{ $product->id }})" name="product_id[]">
                                            <option value="">Choose Product Name</option>
                                            @foreach ($products as $productt)
                                                <option
                                                    {{ old('product_id.' . $index, $product->product_id) == $productt->id ? 'selected' : '' }}
                                                    value="{{ $productt->id }}">{{ $productt->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('product_id.' . $index)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>Product Name is required</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="showSize_-1" class="form-label text-blod">Size <sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <select id="showSize_{{ $product->id }}"
                                            class="form-select form-select-md @error('size.' . $index) is-invalid @enderror"
                                            onchange="SelectQuantity({{ $product->id }})" name="size[]">
                                            <option value="">Choose Size</option>
                                            @foreach ($sizes as $size)
                                                @if ($size->product_id == old('product_id.' . $index, $product->product_id))
                                                    <option
                                                        {{ old('size.' . $index, $product->size_id) == $size->id ? 'selected' : '' }}
                                                        value="{{ $size->id }}">{{ $size->size }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('size.' . $index)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>Size is required</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="cement_pack" class="form-label text-blod">Cement Packs <sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <input type="number"
                                            class="form-control number-input  @error('cement_pack.' . $index) is-invalid @enderror"
                                            name="cement_pack[]" id="cement_pack"
                                            value="{{ old('cement_pack.' . $index, $product->cement_packs) }}"
                                            placeholder="">
                                        @error('cement_pack.' . $index)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>Cement Packs required</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="pallet_no" class="form-label text-blod">No. of Pallets <sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <input type="number"
                                            class="form-control number-input @error('pallet_no.' . $index) is-invalid @enderror"
                                            name="pallet_no[]"
                                            value="{{ old('pallet_no.' . $index, $product->no_pallets) }}"
                                            id="pallet_no{{ $product->id }}"
                                            onchange="NewCalculateTiles({{ $product->id }})" placeholder="">
                                        <input type="hidden" id="sft_ratio{{ $product->id }}">
                                        @error('pallet_no.' . $index)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>No. of Pallets is required</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="tiles_pallet" class="form-label text-blod">Tiles / Pallet <sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <input type="number"
                                            class="form-control number-input    @error('tiles_pallet.' . $index) is-invalid @enderror"
                                            name="tiles_pallet[]"
                                            value="{{ old('tiles_pallet.' . $index, $product->tiles_pallets) }}"
                                            id="tiles{{ $product->id }}"
                                            onchange="NewCalculateTiles({{ $product->id }})" placeholder="">
                                        @error('tiles_pallet.' . $index)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>Tiles / Pallet is required</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="totla_tiles" class="form-label text-blod">Total Tiles in SFT <sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <input type="number"
                                            class="form-control number-input non-edit-able @error('totla_tiles.' . $index) is-invalid @enderror"
                                            name="totla_tiles[]"
                                            value="{{ old('totla_tiles.' . $index, $product->total_tiles_sft) }}" readonly
                                            id="total_tiles{{ $product->id }}" placeholder="">
                                        @error('totla_tiles.' . $index)
                                            <span class="invalid-feedback" role="alert">
                                                <strong> {{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                @if ($index + 1 == $count)
                                @else
                                @endif
                                <div class="col-md-1 d-flex align-items-center">
                                    <button class="btn btn-danger remove-button" type="button"
                                        onclick="removeAlreadyField({{ $product->id }})"><i
                                            class="fa-solid fa-xmark"></i></button>
                                </div>

                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="productCount" id="productCount" value="{{ old('productCount', 0) }}">
                    <div id="productField">
                        @php
                            $productCount = old('productCount');
                        @endphp
                        @for ($i = 0; $i < $productCount; $i++)
                            @php
                                $old = $i + 1;
                            @endphp
                            {{-- @foreach ($errors->get('plant_name.*') as $index => $fieldErrors) --}}
                            {{-- {{ $index }} --}}
                            <div class="row bg-light py-2 mb-2 product-div" id="field_{{ $i }}">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="" class="form-label text-blod">Plant Name<sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <select id=""
                                            class="form-select  form-select-md  @error('newplant_name.' . $i) is-invalid @enderror"
                                            name="newplant_name[]" id="">
                                            <option value="">Choose Plant Name</option>
                                            @foreach ($PlantName as $name)
                                                <option {{ old('newplant_name.' . $i) == $name ? 'selected' : '' }}
                                                    value="{{ $name }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        @error('newplant_name.' . $i)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>Plant Name is required</strong>
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
                                            class="form-select  form-select-md  @error('newproduct_id.' . $i) is-invalid @enderror"
                                            name="newproduct_id[]" id="">
                                            <option value="">Choose Product Name</option>
                                            @foreach ($products as $product)
                                                <option {{ old('newproduct_id.' . $i) == $product->id ? 'selected' : '' }}
                                                    value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('newproduct_id.' . $i)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>Product Name is required</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="showSize_{{ $i }}" class="form-label text-blod">Size <sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <select
                                            id="showSize_{{ $i }}"class="form-select  form-select-md  @error('newsize.' . $i) is-invalid @enderror"
                                            onchange="SelectQuantity(-1)" name="newsize[]" id="">
                                            <option value="">Choose Size</option>
                                            @if (old('newproduct_id.' . $i) && old('newproduct_id.' . $i) != null)
                                                @foreach ($sizes as $size)
                                                    @if ($size->product_id == old('newproduct_id.' . $i))
                                                        <option {{ old('newsize.' . $i) == $size->id ? 'selected' : '' }}
                                                            value="{{ $size->id }}">{{ $size->size }}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('newsize.' . $i)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>Size is required</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="cement_pack" class="form-label text-blod">Cement Packs <sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <input type="text"
                                            class="form-control @error('newcement_pack.' . $i) is-invalid @enderror "
                                            value="{{ old('newcement_pack.' . $i) }}" name="newcement_pack[]"
                                            id="cement_pack" placeholder="">
                                        @error('newcement_pack.' . $i)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>Cement Packs is required</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="pallet_no{{ $i }}" class="form-label text-blod">No. of
                                            Pallets <sup class="text-danger"><b>*</b></sup></label>
                                        <input type="text"
                                            class="form-control  @error('newpallet_no.' . $i) is-invalid @enderror "
                                            name="newpallet_no[]" id="pallet_no{{ $i }}"
                                            value="{{ old('newpallet_no.' . $i) }}"
                                            onchange="NewCalculateTiles({{ $i }})" placeholder="">
                                        @error('newpallet_no.' . $i)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>No. of Pallets is required</strong>
                                            </span>
                                        @enderror
                                        <input type="hidden" value="{{ old('sft_ratio.' . $i) }}" name="sft_ratio[]"
                                            id="sft_ratio{{ $i }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="tiles{{ $i }}" class="form-label text-blod">Tiles / Pallet
                                            <sup class="text-danger"><b>*</b></sup></label>
                                        <input type="text"
                                            class="form-control  @error('newtiles_pallet.' . $i) is-invalid @enderror"
                                            name="newtiles_pallet[]" id="tiles{{ $i }}"
                                            value="{{ old('newtiles_pallet.' . $i) }}"
                                            onchange="NewCalculateTiles({{ $i }})" placeholder="">
                                        @error('newtiles_pallet.' . $i)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>Tiles / Pallet is required</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="totla_tiles" class="form-label text-blod">Total Tiles in SFT <sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <input type="text" id="total_tiles{{ $i }}"
                                            class="form-control non-edit-able @error('newtotla_tiles.' . $i) is-invalid @enderror"
                                            name="newtotla_tiles[]" value="{{ old('newtotla_tiles.' . $i, 0) }}" readonly
                                            id="totla_tiles" placeholder="">
                                        @error('newtotla_tiles.' . $i)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-md-1 d-flex align-items-center">
                                    <button class="btn btn-danger remove-button" type="button"
                                        onclick="removeField('field_{{ $i }}')"><i
                                            class="fa-solid fa-xmark"></i></button>
                                </div>
                            </div>
                            {{-- @foreach ($fieldErrors as $error)
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $error }}</strong>
                                </span>
                            @endforeach
                        @endforeach --}}
                        @endfor

                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-primary" onclick="addNewProductSet()">
                            <span><i class="fa-solid fa-plus"></i></span> Add
                            More Product</button>
                        <button type="reset"
                            class="btn btn-light text-primary btn-rest rounded-0 mx-3 my-2">Reset</button>
                        <button type="submit" class="btn btn-primary rounded-0  my-2">Submit</button>
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
        getLastProductDiv();

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





        function addNewProductSet() {
            const productCountElement = document.getElementById('productCount');
            let productCount = parseInt(productCountElement.value);
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
                                    <select id="" class="form-select  form-select-md"  name="newplant_name[]" id="">
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
                                    <select id="itemSelect_${productCount}" onchange="ItemChange(${productCount})" class="form-select  form-select-md" name="newproduct_id[]" id="">
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
                                    <select id="showSize_${productCount}"class="form-select  form-select-md" onchange="SelectQuantity(${productCount})" name="newsize[]" id="">
                                        <option value="">Choose Size</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                            <div class="mb-3">
                                <label for="cement_pack" class="form-label text-blod">Cement Packs <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control number-input"
                                    name="newcement_pack[]"  id="cement_pack"  placeholder="">

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="pallet_no${productCount}" class="form-label text-blod">No. of Pallets <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control number-input"
                                    name="newpallet_no[]"  id="pallet_no${productCount}" onchange="NewCalculateTiles(${productCount})"  placeholder="">
                                    <input type="hidden" value="" id="sft_ratio${productCount}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="tiles${productCount}" class="form-label text-blod">Tiles / Pallet <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control number-input"
                                    name="newtiles_pallet[]"  id="tiles${productCount}" onchange="NewCalculateTiles(${productCount})"  placeholder="">

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="totla_tiles" class="form-label text-blod">Total Tiles in SFT <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" id="total_tiles${productCount}" class="form-control non-edit-able number-input"
                                    name="newtotla_tiles[]"  value="0" readonly  id="totla_tiles" placeholder="">

                            </div>
                        </div>
                            <div class="col-md-1 d-flex align-items-center">
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

        function removeField(fieldId) {
            const productField = document.getElementById('productField');
            const productCountElementt = document.getElementById('productCount');
            let productCountt = parseInt(productCountElementt.value);

            // productCountElement.value = parseInt(productCountElement.value) - 1;
            let fieldToRemove = document.getElementById(fieldId);
            productField.removeChild(fieldToRemove);
            getLastProductDiv();
            productCountElementt.value = productCountt - 1;

        }

        $(document).on('focus', 'input[name^="plant_name"]', function() {
            const errorTarget = $(this).closest('.input-set').find('.invalid-feedback').data('error-target');
            $(`[data-error-target="${errorTarget}"]`).remove();
        });


        function removeAlreadyField(fieldId) {
            const already_field = document.getElementById('already_field');
            const deletefield = document.getElementById('deletefield_' + fieldId);
            console.log(fieldId);
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
