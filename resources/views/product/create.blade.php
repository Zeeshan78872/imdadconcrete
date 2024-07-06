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
        {{-- success model  --}}
        @component('components.success-model', [
            'title' => 'Product Added Successfully ',
            'desc' => 'A new Product has been added to the list',
            'closeText' => 'Close',
        ])
            <a href="{{ route('product.index') }}" class="btn btn-primary">View All Existing Product</a>
        @endcomponent
        <div class="row">
            <div class="col-6 col-md-auto  top-left">
                <span>Add A Product</span>
            </div>
        </div>
        <div class="card stockCard shadow-2-strong bg-white py-2 px-3">
            <div class="card-header bg-white text-center">
                <h4 class="page-title">Add Product Details</h4>
            </div>
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('product.store') }}">
                    @csrf
                    <div class="row ">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="productCategory" class="form-label">Product Category <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <select class="form-select form-select-md @error('category') is-invalid @enderror"
                                    id="productCategory" onchange="toggleproductTypeInput()" name="category">
                                    <option value="">Choose Product category</option>
                                    <option {{ old('category') == 'Tuff Tiles' ? 'selected' : '' }} value="Tuff Tiles">Tuff
                                        Tiles</option>
                                    <option {{ old('category') == 'Chemical Tiles' ? 'selected' : '' }}
                                        value="Chemical Tiles">Chemical Tiles
                                    </option>
                                </select>
                                @error('category')
                                    <span class="invalid-feedback mt-2" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input type="hidden" value="0" name="" id="productTypeInput">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="name" class="form-label">Product Name<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" id="name" placeholder="">
                                @error('name')
                                    <span class="invalid-feedback mt-2" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @if (old('category') == 'Chemical Tiles')
                        @component('components.add-chemicalfield', ['display' => 'unset'])
                        @endcomponent
                    @else
                        @component('components.add-chemicalfield', ['display' => 'none'])
                        @endcomponent
                    @endif

                    <div class="row   py-2 mb-2">
                        <div class="col-md-4 bg-light pt-1">
                            <div class="mb-3">
                                <label for="size" class="form-label">Product Size<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control @error('size.0') is-invalid @enderror"
                                    name="size[]" value="{{ old('size.0') }}" id="size" placeholder="">
                                @error('size.0')
                                    <span class="invalid-feedback mt-2" role="alert">
                                        <strong>The product size field is required.</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 bg-light pt-1">
                            <div class="mb-3">
                                <label for="sft" class="form-label">SFT Ratio<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="number" class="form-control @error('sft.0') is-invalid @enderror"
                                    name="sft[]" value="{{ old('sft.0') }}" id="sft" placeholder="">
                                @error('sft.0')
                                    <span class="invalid-feedback mt-2" role="alert">
                                        <strong>The SFT ratio field is required.</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @if (old('category') == 'Chemical Tiles')
                            @component('components.add-product-size', ['display' => 'unset', 'count' => '0'])
                            @endcomponent
                        @else
                            @component('components.add-product-size', ['display' => 'none', 'count' => '0'])
                            @endcomponent
                        @endif

                        <div class="col-md-3 bg-light pt-1 pb-1 d-flex align-items-center justify-content-center  pt-2">
                            <button class="btn btn-primary" type="button" onclick="addField()"><i
                                    class="fa-solid fa-plus"></i> Add More Size</button>
                        </div>
                    </div>
                    <input type="hidden" id="fieldCount" name="fieldCount" value="{{ old('fieldCount', 0) }}">
                    @php
                        $fieldCount = old('fieldCount');
                    @endphp
                    <div id="SizeField">
                        @for ($i = 0; $i < $fieldCount; $i++)
                            @php
                                $old = $i + 1;
                            @endphp
                            <div class="row  py-2 mb-2" id="field_{{ $i }}">
                                <div class="col-md-4 bg-light pt-1">
                                    <div class="mb-3">
                                        <label for="size" class="form-label">Product Size<sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <input type="number"
                                            class="form-control @error('size.' . $old) is-invalid @enderror" name="size[]"
                                            value="{{ old('size.' . $old) }}" id="size" placeholder="">
                                        @error('size.' . $old)
                                            <span class="invalid-feedback mt-2" role="alert">
                                                <strong>The product size field is required.</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 bg-light pt-1">
                                    <div class="mb-3">
                                        <label for="sft" class="form-label">SFT Ratio<sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <input type="number"
                                            class="form-control @error('sft.' . $old) is-invalid @enderror" name="sft[]"
                                            value="{{ old('sft.0') }}" id="sft" placeholder="">
                                        @error('sft.' . $old)
                                            <span class="invalid-feedback mt-2" role="alert">
                                                <strong>The SFT ratio field is required.</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                @if (old('category') == 'Chemical Tiles')
                                    @component('components.add-product-size', ['display' => 'unset', 'count' => $old])
                                    @endcomponent
                                @else
                                    @component('components.add-product-size', ['display' => 'none', 'count' => $old])
                                    @endcomponent
                                @endif
                                @if (old('category') == 'Chemical Tiles')
                                    <div
                                        class="col-md-1 bg-light pt-1 pb-1 d-flex align-items-center justify-content-center compoenet2">
                                        <button class="btn btn-danger" type="button"
                                            onclick="removeField('field_{{ $i }}')"><i
                                                class="fa-solid fa-xmark"></i></button>
                                    </div>
                                    <div class="col-md-2 bg-light "></div>
                                @else
                                    <div
                                        class="col-md-1 bg-light pt-1 pb-1 d-flex align-items-center justify-content-center">
                                        <button class="btn btn-danger" type="button"
                                            onclick="removeField('field_{{ $i }}')"><i
                                                class="fa-solid fa-xmark"></i></button>
                                    </div>
                                @endif

                            </div>
                        @endfor
                    </div>
                    <div class="text-center">
                        <a href="" class="btn btn-light text-primary btn-rest">Reset</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        let fieldCountElement = document.getElementById('fieldCount');
        let fieldCount = parseInt(fieldCountElement.value, 10);
        console.log(fieldCount);

        function toggleproductTypeInput() {
            let productCategory = document.getElementById('productCategory');
            // let productTypeInput = document.getElementById('productTypeInput');
            // var component = document.getElementById('compoenet');
            // var component2 = document.getElementById('compoenet2');
            // var component1 = document.getElementById('compoenet1');

            var components = document.querySelectorAll('.compoenet');
            var components2 = document.querySelectorAll('.compoenet2');
            var components1 = document.querySelectorAll('.compoenet1');

            var componentC1 = document.getElementById('compoenetC1');
            var componentC2 = document.getElementById('compoenetC2');

            if (productCategory.value === 'Chemical Tiles') {
                productTypeInput.value = '1';
            } else {
                productTypeInput.value = '0';
                // while (productCategory.firstChild) {
                //     productCategory.removeChild(productCategory.firstChild);
                // }
            }
            if (productCategory.value === 'Chemical Tiles') {
                productTypeInput.value = '1';
                components.forEach(function(component) {
                    component.style.display = 'unset';
                });
                components1.forEach(function(component1) {
                    component1.style.display = 'unset';
                });
                components2.forEach(function(component2) {
                    component2.style.display = 'unset';
                });
            } else {
                productTypeInput.value = '0';
                components.forEach(function(component) {
                    component.style.display = 'none';
                });
                components1.forEach(function(component1) {
                    component1.style.display = 'none';
                });
                components2.forEach(function(component2) {
                    component2.style.display = 'none';
                });
            }
            if (productCategory.value === 'Chemical Tiles') {

                componentC1.style.display = 'unset';
                componentC2.style.display = 'unset';
            } else {

                componentC1.style.display = 'none';
                componentC2.style.display = 'none';
            }

        }

        function addField() {
            let productTypeInput = document.getElementById('productTypeInput').value;
            console.log(productTypeInput);
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
                                    <input type="number" class="form-control"  name="size[]" value="" id="size"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="col-md-4 bg-light pt-1">
                                <div class="mb-3">
                                    <label for="sft" class="form-label">SFT Ratio<sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <input type="number" class="form-control"  name="sft[]" value="" id="sft"
                                        placeholder="">
                                </div>
                            </div>`;
            if (productTypeInput != 0) {
                content += `
                <div class="col-md-3 bg-light pt-1 compoenet" id=""></div>
                    <div class="col-md-4 bg-light pt-1 compoenet1" id="">
                        <div class="mb-3">
                            <label for="quantity_farms" class="form-label">Quantity / Farma<sup class="text-danger"><b>*</b></sup></label>
                            <input type="number" class="form-control"  name="quantity_farms[]" value="" id="quantity_farms" placeholder=""
                                >
                        </div>
                    </div>
                    <div class="col-md-4 bg-light pt-1 compoenet2" id="">
                        <div class="mb-3">
                            <label for="total_Farms" class="form-label">Total Farmas<sup class="text-danger"><b>*</b></sup></label>
                            <input type="number" class="form-control"  name="total_Farms[]" value="" id="total_Farms" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-1 bg-light pt-1 pb-1 d-flex align-items-center justify-content-center compoenet2" >
                                <button class="btn btn-danger" type="button" onclick="removeField('field_${fieldCount}')"><i class="fa-solid fa-xmark"></i></button>
                            </div>
                            <div class="col-md-2 bg-light "></div>

                    `;
            } else {
                content += ` <div class="col-md-1 bg-light pt-1 pb-1 d-flex align-items-center justify-content-center">
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
    </script>
@endsection
