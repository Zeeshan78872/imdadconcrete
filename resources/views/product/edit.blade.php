@extends('layouts.app')

@section('style')
    <style>
        .card {
            margin-top: 161px;
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
        <div class="row">
            <div class="col-6 col-md-auto  top-left">
                <span>Edit Product</span>
            </div>


        </div>

        <div class="card stockCard shadow-2-strong bg-white  py-2 px-3">
            <div class="card-header bg-white text-center">
                <h4 class="page-title">EDIT PRODUCT DETAILS</h4>
            </div>
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('product.update', $products->id) }}">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="category" class="form-label">Product Category <sup
                                        class="text-danger"><b>*</b></sup></label>

                                <input type="text" readonly name="category"
                                    value="{{ $products->category == 'Chemical Tiles' ? 'Chemical Tiles' : 'Tuff Tiles' }}"
                                    class="form-control @error('category') is-invalid @enderror">
                                @error('category')
                                    <span class="invalid-feedback mt-2" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="name" class="form-label">Product Name<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $products->name) }}" name="name" value="" id="name"
                                    placeholder="">
                                @error('name')
                                    <span class="invalid-feedback mt-2" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                        </div>
                    </div>
                    @if ($products->product_type != null && $products->height_type != null)
                        <div class="row">
                            <div class="col-md-4  pt-1">
                                <div class="mb-3">
                                    <label for="product_type" class="form-label">Product Type<sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <select class="form-select form-select-md @error('product_type') is-invalid @enderror"
                                        name="product_type" id="product_type">
                                        <option value="">Choose Product Type</option>
                                        <option
                                            {{ old('product_type', $products->product_type) == 'Tuff Tile' ? 'selected' : '' }}
                                            value="Tuff Tile">Tuff Tile</option>
                                        <option
                                            {{ old('product_type', $products->product_type) == 'Patio & Outdoor Tile' ? 'selected' : '' }}
                                            value="Patio & Outdoor Tile"> Patio & Outdoor Tile</option>
                                        <option
                                            {{ old('product_type', $products->product_type) == 'Ramp Tile' ? 'selected' : '' }}
                                            value="Ramp Tile">Ramp Tile</option>
                                        <option
                                            {{ old('product_type', $products->product_type) == 'Wall Tile' ? 'selected' : '' }}
                                            value="Wall Tile">Wall Tile</option>
                                        <option
                                            {{ old('product_type', $products->product_type) == 'Water Pipe & Blocks' ? 'selected' : '' }}
                                            value="Water Pipe & Blocks">Water Pipe & Blocks</option>
                                        <option
                                            {{ old('product_type', $products->product_type) == 'Others' ? 'selected' : '' }}
                                            value="Others">
                                            Others</option>
                                    </select>
                                    @error('product_type')
                                        <span class="invalid-feedback mt-2" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 pt-1">
                                <div class="mb-3">
                                    <label for="height_type" class="form-label">Height Type<sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <select class="form-select form-select-md @error('height_type') is-invalid @enderror"
                                        name="height_type" id="height_type">
                                        <option value=""> Choose Height Type</option>
                                        <option
                                            {{ old('height_type', $products->height_type) == '0.5 Inch' ? 'selected' : '' }}
                                            value="0.5 Inch">0.5 Inch</option>
                                        <option
                                            {{ old('height_type', $products->height_type) == '1 Inch' ? 'selected' : '' }}
                                            value="1 Inch">1
                                            Inch</option>
                                        <option
                                            {{ old('height_type', $products->height_type) == '2 Inch' ? 'selected' : '' }}
                                            value="2 Inch">2
                                            Inch</option>
                                        <option
                                            {{ old('height_type', $products->height_type) == 'Others' ? 'selected' : '' }}
                                            value="Others">
                                            Others</option>
                                    </select>
                                    @error('height_type')
                                        <span class="invalid-feedback mt-2" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row  SizeRow  mb-2" id="sizes">
                        @php
                            $count = $products->sizes->count();
                        @endphp
                        @foreach ($products->sizes as $index => $size)
                            <input type="hidden" name="deleteSize[]" value="" id="deleteSize_{{ $size->id }}">
                            <div class="col-md-12  py-2 mb-2" id="size_{{ $size->id }}">
                                <div class="row  ">
                                    <div class="col-4 bg-light">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Product Size <sup
                                                    class="text-danger"><b>*</b></sup></label>
                                            <input type="number"
                                                class="form-control @error('size.' . $size->id . '.' . $index) is-invalid @enderror"
                                                value="{{ old('size.' . $size->id . '.' . $index, $size->size) }}"
                                                name="size[{{ $size->id }}][]" id="" placeholder="">
                                            @error('size.' . $size->id . '.' . $index)
                                                <span class="invalid-feedback mt-2" role="alert">
                                                    <strong>The product size field is required.</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-4 bg-light">
                                        <div class="mb-3">
                                            <label for="" class="form-label">SFT Ratio <sup
                                                    class="text-danger"><b>*</b></sup></label>
                                            <input type="number"
                                                class="form-control @error('sft.' . $size->id . '.' . $index) is-invalid @enderror"
                                                value="{{ old('sft.' . $size->id . '.' . $index, $size->sft) }}"
                                                name="sft[{{ $size->id }}][]" id="" placeholder="">
                                            @error('sft.' . $size->id . '.' . $index)
                                                <span class="invalid-feedback mt-2" role="alert">
                                                    <strong>The sft ratio field is required.</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    @if ($size->quantity_farma != null && $size->total_farma != null)
                                        <input type="hidden" id="chemical_edit" name="" value="1">
                                        <div class="col-md-3 bg-light"></div>
                                        <div class="col-md-4 bg-light pt-1">
                                            <div class="mb-3">
                                                <label for="quantity_farms" class="form-label">Quantity / Farma<sup
                                                        class="text-danger"><b>*</b></sup></label>
                                                <input type="number"
                                                    class="form-control @error('quantity_farms.' . $size->id . '.' . $index) is-invalid @enderror"
                                                    value="{{ old('quantity_farms.' . $size->id . '.' . $index, $size->quantity_farma) }}"
                                                    name="quantity_farms[{{ $size->id }}][]" value=""
                                                    id="quantity_farms" placeholder="">
                                                @error('quantity_farms.' . $size->id . '.' . $index)
                                                    <span class="invalid-feedback mt-2" role="alert">
                                                        <strong>The sft ratio field is required.</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4 bg-light pt-1">
                                            <div class="mb-3">
                                                <label for="total_Farms" class="form-label">Total Farmas<sup
                                                        class="text-danger"><b>*</b></sup></label>
                                                <input type="number"
                                                    class="form-control @error('total_Farms.' . $size->id . '.' . $index) is-invalid @enderror"
                                                    name="total_Farms[{{ $size->id }}][]"
                                                    value="{{ old('total_Farms.' . $size->id . '.' . $index, $size->total_farma) }}"
                                                    id="total_Farms" placeholder="">
                                                @error('total_Farms.' . $size->id . '.' . $index)
                                                    <span class="invalid-feedback mt-2" role="alert">
                                                        <strong>The sft ratio field is required.</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    @else
                                        <input type="hidden" id="chemical_edit" name="" value="0">
                                    @endif
                                    @if ($index + 1 == $count)
                                        <div class="col-3 bg-light  d-flex align-items-center justify-content-center">
                                            <button type="button" onclick="addField()" class="btn btn-primary mt-4">
                                                <i class="fa-solid fa-plus"></i> Add More Size
                                            </button>
                                        </div>
                                    @else
                                        <div class="col-1 bg-light d-flex align-items-center justify-content-center">
                                            <button type="button" onclick="deleteSize({{ $size->id }})"
                                                class="btn btn-danger mt-4">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>

                                        </div>
                                        @if ($size->quantity_farma != null && $size->total_farma != null)
                                            <div class="col-2 bg-light"></div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" id="fieldCount" name="fieldCount" value="{{ old('fieldCount', 0) }}">

                    <div id="SizeField">
                        @php
                            $fieldCount = old('fieldCount');
                        @endphp
                        @for ($i = 0; $i < $fieldCount; $i++)
                            @php
                                $old = $i + 1;
                            @endphp
                            <div class="row mb-2 py-2" id="field_{{ $i }}">
                                <div class="col-md-4 bg-light pt-1">
                                    <div class="mb-3">
                                        <label for="size" class="form-label">Product Size<sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <input type="number"
                                            class="form-control @error('newsize.' . $i) is-invalid @enderror"
                                            name="newsize[]" value="{{ old('newsize.' . $i) }}" id="size"
                                            placeholder="">
                                        @error('newsize.' . $i)
                                            <span class="invalid-feedback mt-2" role="alert">
                                                <strong>The size field is required.</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 bg-light pt-1">
                                    <div class="mb-3">
                                        <label for="sft" class="form-label">SFT Ratio<sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <input type="number"
                                            class="form-control @error('newsft.' . $i) is-invalid @enderror"
                                            name="newsft[]" value="{{ old('newsft.' . $i) }}" id="sft"
                                            placeholder="">
                                        @error('newsft.' . $i)
                                            <span class="invalid-feedback mt-2" role="alert">
                                                <strong>The sft ratio field is required.</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                @if (old('category') == 'Chemical Tiles')
                                    <div class="col-md-3 bg-light pt-1"></div>
                                    <div class="col-md-4 bg-light pt-1">
                                        <div class="mb-3">
                                            <label for="quantity_farms" class="form-label">Quantity / Farma<sup
                                                    class="text-danger"><b>*</b></sup></label>
                                            <input type="number"
                                                class="form-control @error('newquantity_farms.' . $i) is-invalid @enderror"
                                                name="newquantity_farms[]" value="{{ old('newquantity_farms.' . $i) }}"
                                                id="quantity_farms" placeholder="">
                                            @error('newquantity_farms.' . $i)
                                                <span class="invalid-feedback mt-2" role="alert">
                                                    <strong>The quantity / farma field is required.</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 bg-light pt-1">
                                        <div class="mb-3">
                                            <label for="total_Farms" class="form-label">Total Farmas<sup
                                                    class="text-danger"><b>*</b></sup></label>
                                            <input type="number"
                                                class="form-control @error('newtotal_Farms' . $i) is-invalid @enderror"
                                                name="newtotal_Farms[]" value="{{ old('newtotal_Farms.' . $i) }}"
                                                id="total_Farms" placeholder="">
                                            @error('newtotal_Farms.' . $i)
                                                <span class="invalid-feedback mt-2" role="alert">
                                                    <strong>The total farmas field is required.</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-1 bg-light pb-1 d-flex align-items-center justify-content-center">
                                        <button class="btn btn-danger" type="button"
                                            onclick="removeField('field_{{ $i }}')"><i
                                                class="fa-solid fa-xmark"></i></button>
                                    </div>
                                    <div class="col-md-2 bg-light pt-1"></div>
                                @else
                                    <div class="col-md-1 bg-light pb-1 d-flex align-items-center justify-content-center">
                                        <button class="btn btn-danger" type="button"
                                            onclick="removeField('field_{{ $i }}')"><i
                                                class="fa-solid fa-xmark"></i></button>
                                    </div>
                                @endif
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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        let fieldCountElement = document.getElementById('fieldCount');
        let fieldCount = parseInt(fieldCountElement.value, 10);
        // console.log(fieldCount);

        function addField() {
            const chemical_edit = document.getElementById('chemical_edit');
            console.log(chemical_edit.value);
            const productField = document.getElementById('SizeField');

            // Create a new product row
            const newProductRow = document.createElement('div');
            newProductRow.classList.add('row', 'py-2', 'mb-2');
            newProductRow.setAttribute("id", `field_${fieldCount}`);
            let content = `
                            <div class="col-md-4 bg-light pt-1">
                                <div class="mb-3">
                                    <label for="size" class="form-label">Product Size<sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <input type="number" class="form-control"  name="newsize[]" value="" id="size"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="col-md-4 bg-light pt-1">
                                <div class="mb-3">
                                    <label for="sft" class="form-label">SFT Ratio<sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <input type="number" class="form-control"  name="newsft[]" value="" id="sft"
                                        placeholder="">
                                </div>
                            </div>`;
            if (chemical_edit.value == 1) {
                content += `
                        <div class="col-md-3 bg-light pt-1"></div>
                            <div class="col-md-4 bg-light pt-1">
                                <div class="mb-3">
                                    <label for="quantity_farms" class="form-label">Quantity / Farma<sup class="text-danger"><b>*</b></sup></label>
                                    <input type="number" class="form-control"  name="newquantity_farms[]" value="" id="quantity_farms" placeholder=""
                                        >
                                </div>
                            </div>
                            <div class="col-md-4 bg-light pt-1">
                                <div class="mb-3">
                                    <label for="total_Farms" class="form-label">Total Farmas<sup class="text-danger"><b>*</b></sup></label>
                                    <input type="number" class="form-control"  name="newtotal_Farms[]" value="" id="total_Farms" placeholder=""
                                        >
                                </div>
                            </div>
                            <div class="col-md-1 bg-light pb-1 d-flex align-items-center justify-content-center">
                                <button class="btn btn-danger" type="button" onclick="removeField('field_${fieldCount}')"><i class="fa-solid fa-xmark"></i></button>
                            </div>
                            <div class="col-md-2 bg-light pt-1"></div>
                            `;
            } else {
                content += ` <div class="col-md-1 bg-light pb-1 d-flex align-items-center justify-content-center">
                                <button class="btn btn-danger" type="button" onclick="removeField('field_${fieldCount}')"><i class="fa-solid fa-xmark"></i></button>
                            </div> `;
            }

            newProductRow.innerHTML = content;
            productField.appendChild(newProductRow);
            fieldCount++;
            fieldCountElement.value = fieldCount;
        }

        function removeField(fieldId) {
            const productField = document.getElementById('SizeField');

            let fieldToRemove = document.getElementById(fieldId);
            productField.removeChild(fieldToRemove);
        }

        function deleteSize(size_id) {
            let deleteSize = document.getElementById('deleteSize_' + size_id)
            let parent_div = document.getElementById('sizes');
            let size_div = document.getElementById('size_' + size_id);
            parent_div.removeChild(size_div);
            deleteSize.value = size_id;
            console.log(deleteSize.value);

            // axios.defaults.headers.common['X-CSRF-TOKEN'] = '{{ csrf_token() }}';
            // axios.delete(`/deleteSize/${size_id}`)
            //     .then(response => {
            //         console.log(response.data.message);
            //     })
            //     .catch(error => {
            //         alert('An error occurred while deleting the record.');
            //         console.error(error);
            //     });
        }
    </script>
@endsection
