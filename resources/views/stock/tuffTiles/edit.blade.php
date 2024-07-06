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
                <form method="POST" action="{{ route('tuffTile.update',$stocks->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="date" class="form-label">Date <sup
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
                    <div class="row bg-light py-2 mb-2">
                        <div class="row">
                            @foreach ($stocks->products as $index => $product )
                             @php
                                 $count =  $stocks->products->count();
                             @endphp
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="plant_name" class="form-label">Plant Name <sup
                                                    class="text-danger"><b>*</b></sup> </label>
                                            <select
                                                class="form-select form-select-md  @error('plant_name.0') is-invalid @enderror"
                                                name="plant_name[]" id="plant_name">
                                                <option value="">Choose Plant Name</option>
                                                @foreach ($PlantName as $name)
                                                    <option {{ old('plant_name.0' ,$product->plant_name) == $name ? 'selected' : '' }}
                                                        value="{{ $name }}">{{ $name }}</option>
                                                @endforeach
                                            </select>
                                            @error('plant_name.0')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>This plant name field is required</strong>
                                                </span>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="itemSelect_-1" class="form-label">Product Name <sup
                                                    class="text-danger"><b>*</b></sup></label>
                                            <select id="itemSelect_-1"
                                                class="form-select form-select-md @error('product_id.0') is-invalid @enderror"
                                                onchange="ItemChange(-1)" name="product_id[]">
                                                <option value="">Choose Product Name</option>
                                                @foreach ($products as $productt)
                                                    <option {{ old('product_id.0',$product->product_id) == $productt->id ? 'selected' : '' }}
                                                        value="{{ $productt->id }}">{{ $productt->name }}</option>
                                                @endforeach
                                            </select>

                                            @error('product_id.0')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>This Product Name field is required</strong>
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
                                                onchange="SelectQuantity(-1)" name="size[]">
                                                <option value="">Choose Size</option>
                                            </select>
                                            @error('size.0')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>This Size field is required</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="cement_pack" class="form-label">Cement Packs <sup
                                                    class="text-danger"><b>*</b></sup></label>
                                            <input type="number"
                                                class="form-control  @error('cement_pack.0') is-invalid @enderror"
                                                name="cement_pack[]" id="cement_pack" value="{{ old('cement_pack.0',$product->cement_packs) }}"
                                                placeholder="">
                                            @error('cement_pack.0')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>This Cement Packs field required</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="pallet_no" class="form-label">No. of Pallets <sup
                                                    class="text-danger"><b>*</b></sup></label>
                                            <input type="number"
                                                class="form-control @error('pallet_no.0') is-invalid @enderror"
                                                name="pallet_no[]" value="{{ old('pallet_no.0',$product->no_pallets) }}" id="pallet_no-1" onchange="NewCalculateTiles(-1)"
                                                placeholder="">
                                            <input type="hidden"  id="sft_ratio-1">
                                            @error('pallet_no.0')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>This No. of Pallets field is required</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="tiles_pallet" class="form-label">Tiles / Pallet <sup
                                                    class="text-danger"><b>*</b></sup></label>
                                            <input type="number"
                                                class="form-control @error('tiles_pallet.0') is-invalid @enderror"
                                                name="tiles_pallet[]" value="{{ old('tiles_pallet.0',$product->tiles_pallets) }}" id="tiles-1"
                                                onchange="NewCalculateTiles(-1)" placeholder="">
                                            @error('tiles_pallet.0')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>This Tiles / Pallet field is required</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="totla_tiles" class="form-label">Total Tiles in SFT <sup
                                                    class="text-danger"><b>*</b></sup></label>
                                            <input type="number"
                                                class="form-control bg-light @error('totla_tiles.0') is-invalid @enderror"
                                                name="totla_tiles[]" value="{{ old('totla_tiles.0', $product->product) }}" readonly
                                                id="total_tiles-1" placeholder="">
                                            @error('totla_tiles.0')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong> This Total Tiles in SFT field is required</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 my-4 py-1">
                                        <button type="button" class="btn btn-primary" onclick="addNewProductSet()">
                                            <span><i class="fa-solid fa-plus"></i></span> Add
                                            More Product</button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <input type="hidden" name="productCount" id="productCount" value="{{ old('productCount', 0) }}">
                    <div id="productField">
                        @php
                            $productCount = old('productCount');
                            echo $productCount;
                        @endphp
                        @for ($i = 0; $i < $productCount; $i++)
                            @php
                                $old = $i + 1;
                            @endphp
                            {{-- @foreach ($errors->get('plant_name.*') as $index => $fieldErrors) --}}
                            {{-- {{ $index }} --}}
                            <div class="row bg-light py-2 mb-2" id="field_{{ $i }}">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Plant Name<sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <select id=""
                                            class="form-select  form-select-md  @error('product_id.' . $i) is-invalid @enderror"
                                            name="plant_name[]" id="">
                                            <option value="">Choose Plant Name</option>
                                            @foreach ($PlantName as $name)
                                                <option {{ old('plant_name.' . $i) == $name ? 'selected' : '' }}
                                                    value="{{ $name }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        @error('plant_name.' . $i)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>This Plant Name is required</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="itemSelect_{{ $i }}" class="form-label">Product Name <sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <select id="itemSelect_{{ $i }}"
                                            onchange="ItemChange({{ $i }})"
                                            class="form-select  form-select-md  @error('product_id.' . $i) is-invalid @enderror"
                                            name="product_id[]" id="">
                                            <option value="">Choose Product Name</option>
                                            @foreach ($products as $product)
                                                <option {{ old('product_id.' . $i) == $product->id ? 'selected' : '' }}
                                                    value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('product_id.' . $i)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>This Product Name field is required</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="showSize_{{ $i }}" class="form-label">Size <sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <select
                                            id="showSize_{{ $i }}"class="form-select  form-select-md  @error('size.' . $i) is-invalid @enderror"
                                            onchange="SelectQuantity(-1)" name="size[]" id="">
                                            <option value="">Choose Size</option>
                                        </select>
                                        @error('size.' . $i)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>This Size field is required</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="cement_pack" class="form-label">Cement Packs <sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <input type="text"
                                            class="form-control @error('cement_pack.' . $i) is-invalid @enderror "
                                            value="{{ old('cement_pack.' . $i) }}" name="cement_pack[]"
                                            id="cement_pack" placeholder="">
                                        @error('cement_pack.' . $i)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>This Cement Packs field is required</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="pallet_no{{ $i }}" class="form-label">No. of Pallets <sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <input type="text"
                                            class="form-control  @error('pallet_no.' . $i) is-invalid @enderror "
                                            name="pallet_no[]" id="pallet_no{{ $i }}"
                                            value="{{ old('pallet_no.' . $i) }}"
                                            onchange="NewCalculateTiles({{ $i }})" placeholder="">
                                        @error('pallet_no.' . $i)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>This No. of Pallets field is required</strong>
                                            </span>
                                        @enderror
                                        <input type="hidden" value="{{ old('sft_ratio.' . $i) }}" name="sft_ratio[]"
                                            id="sft_ratio{{ $i }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="tiles{{ $i }}" class="form-label">Tiles / Pallet <sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <input type="text"
                                            class="form-control  @error('cement_pack.' . $i) is-invalid @enderror"
                                            name="tiles_pallet[]" id="tiles{{ $i }}"
                                            value="{{ old('tiles_pallet.' . $i) }}"
                                            onchange="NewCalculateTiles({{ $i }})" placeholder="">
                                        @error('tiles_pallet.' . $i)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>This Tiles / Pallet field is required</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="totla_tiles" class="form-label">Total Tiles in SFT <sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <input type="text" id="total_tiles{{ $i }}" class="form-control"
                                            name="totla_tiles[]" value="{{ old('totla_tiles.' . $i, 0) }}" readonly
                                            id="totla_tiles" placeholder="">

                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <button class="btn btn-danger" type="button"
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
                        <button type="reset"
                            class="btn btn-light text-primary btn-rest rounded-0 mx-1 my-2">Reset</button>
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
            const productField = document.getElementById('productField');

            // Create a new product row
            const newProductRow = document.createElement('div');
            newProductRow.classList.add('row', 'bg-light', 'py-2', 'my-3');
            newProductRow.setAttribute("id", `field_${productCount}`);

            // Your original structure (without the button)
            newProductRow.innerHTML = `
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Product Name <sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <select id="" class="form-select  form-select-md"  name="plant_name[]" id="">
                                        <option value="">Choose Product Name</option>
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
                                    <label for="itemSelect_${productCount}" class="form-label">Product Name <sup
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
                                    <label for="showSize_${productCount}" class="form-label">Size <sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <select id="showSize_${productCount}"class="form-select  form-select-md" onchange="SelectQuantity(${productCount})" name="size[]" id="">
                                        <option selected>Choose Size</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                            <div class="mb-3">
                                <label for="cement_pack" class="form-label">Cement Packs <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control "
                                    name="cement_pack[]"  id="cement_pack"  placeholder="">

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="pallet_no${productCount}" class="form-label">No. of Pallets <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control "
                                    name="pallet_no[]"  id="pallet_no${productCount}" onchange="NewCalculateTiles(${productCount})"  placeholder="">
                                    <input type="hidden" value="" id="sft_ratio${productCount}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="tiles${productCount}" class="form-label">Tiles / Pallet <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control "
                                    name="tiles_pallet[]"  id="tiles${productCount}" onchange="NewCalculateTiles(${productCount})"  placeholder="">

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="totla_tiles" class="form-label">Total Tiles in SFT <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" id="total_tiles${productCount}" class="form-control"
                                    name="totla_tiles[]"  value="0" readonly  id="totla_tiles" placeholder="">

                            </div>
                        </div>
                            <div class="col-md-4 d-flex align-items-center">
                                <button class="btn btn-danger" type="button" onclick="removeField('field_${productCount}')"><i class="fa-solid fa-xmark"></i></button>
                            </div>`;
            productCount++;
            productCountElement.value = productCount;
            productField.appendChild(newProductRow);
        }
        $(document).on('focus', 'input[name^="plant_name"]', function() {
            const errorTarget = $(this).closest('.input-set').find('.invalid-feedback').data('error-target');
            $(`[data-error-target="${errorTarget}"]`).remove();
        });

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
        // $(document).ready(function() {
        //     $('#itemSelect_-1').on('change', function() {
        //         const idToFetch = $(this).val();
        //         const url = window.location.origin + '/fetchSize/' + idToFetch;
        //         $('#showSize_-1').empty();
        //         $('#showSize_-1').append('<option>Choose Size</option>')
        //         $.ajax({
        //             url: url,
        //             type: 'GET',
        //             dataType: 'json',
        //             success: function(response) {
        //                 $.each(response, function(index, value) {
        //                     $('#showSize_-1').append('<option value="' + value['id'] +
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
