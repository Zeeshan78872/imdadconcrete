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
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="productCategory" class="form-label text-blod">Product Category <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <select class="form-select form-select-md @error('category') is-invalid @enderror"
                                    id="productCategory" onchange="toggleproductTypeInput()" name="category">
                                    <option value="">Choose Product category</option>
                                    <option {{ old('category') == 'Tuff Tiles' ? 'selected' : '' }} value="Tuff Tiles">Tuff
                                        Tiles & Blocks</option>
                                    <option {{ old('category') == 'Chemical Tiles' ? 'selected' : '' }}
                                        value="Chemical Tiles">Chemical Concrete Pavers
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
                                <label for="name" class="form-label text-blod">Product Name<sup
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
                        <div class="col-md-1"></div>
                    </div>
                    @if (old('category') == 'Chemical Tiles')
                        @component('components.add-chemicalfield', ['display' => 'unset', 'productTypes' => getProductType()])
                        @endcomponent
                    @else
                        @component('components.add-chemicalfield', ['display' => 'none', 'productTypes' => getProductType()])
                        @endcomponent
                    @endif


                    <input type="hidden" id="fieldCount" name="fieldCount" value="{{ old('fieldCount', 0) }}">
                    @php
                        $fieldCount = old('fieldCount');
                        $old = 0;
                    @endphp
                    <div id="SizeField">

                        @for ($i = 0; $i < $fieldCount; $i++)
                            <div class="row justify-content-center  py-2 mb-2 product-div" id="field_{{ $i }}">
                                <div class="col-md-4 bg-light pt-1">
                                    <div class="mb-3">
                                        <label for="size{{ $i }}" class="form-label text-blod">Product Size<sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <input type="text"
                                            class="form-control number-input @error('size.' . $old) is-invalid @enderror"
                                            name="size[]" value="{{ old('size.' . $old) }}"
                                            onkeyup="setupnumValid('size{{ $i }}')"
                                            id="size{{ $i }}" placeholder="">
                                        @error('size.' . $old)
                                            <span class="invalid-feedback mt-2" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 bg-light pt-1">
                                    <div class="mb-3">
                                        <label for="sft-1" class="form-label text-blod">SFT Ratio<sup
                                                class="text-danger"><b>*</b></sup></label>
                                        <!-- -->
                                        <input type="text"
                                            class="form-control number-input @error('sft.' . $old) is-invalid @enderror"
                                            name="sft[]" value="{{ old('sft.0') }}" id="sft-1" placeholder=""
                                            onkeyup="setupnumValid('sft-1')">

                                        @error('sft.' . $old)
                                            <span class="invalid-feedback mt-2" role="alert">
                                                <strong>{{ $message }}</strong>
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
                                        <button class="btn btn-danger remove-button" type="button"
                                            onclick="removeField('field_{{ $i }}')"><i
                                                class="fa-solid fa-xmark"></i></button>
                                    </div>
                                @else
                                    <div
                                        class="col-md-1 bg-light pt-1 pb-1 d-flex align-items-center justify-content-center">
                                        <button class="btn btn-danger remove-button" type="button"
                                            onclick="removeField('field_{{ $i }}')"><i
                                                class="fa-solid fa-xmark"></i></button>
                                    </div>
                                @endif

                            </div>
                            @php
                                $old++;
                            @endphp
                        @endfor
                    </div>
                    <div class="text-center">
                        <button class="btn btn-primary" type="button" onclick="addField()"><i class="fa-solid fa-plus"></i>
                            Add More Size</button>
                        <button type="reset" class="btn btn-light text-primary btn-rest">Reset</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
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
        let fieldCountElement = document.getElementById('fieldCount');
        let fieldCount = parseInt(fieldCountElement.value, 10);

        function toggleproductTypeInput() {
            let productCategory = document.getElementById('productCategory');
            var components = document.querySelectorAll('.compoenet');
            var components2 = document.querySelectorAll('.compoenet2');
            var components1 = document.querySelectorAll('.compoenet1');

            var componentC1 = document.getElementById('compoenetC1');
            var componentC2 = document.getElementById('compoenetC2');
            var compoenetC3 = document.getElementById('compoenetC3');

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
                compoenetC3.style.display = 'unset';
            } else {

                componentC1.style.display = 'none';
                componentC2.style.display = 'none';
                compoenetC3.style.display = 'none';
            }

        }

        function addField() {
            let fieldCountElement = document.getElementById('fieldCount');
            let fieldCount = parseInt(fieldCountElement.value, 10);
            let productTypeInput = document.getElementById('productTypeInput').value;
            console.log(productTypeInput);
            const productField = document.getElementById('SizeField');

            // Create a new product row
            const newProductRow = document.createElement('div');
            newProductRow.classList.add('row', 'py-2', 'mb-2', 'product-div', 'justify-content-center');
            newProductRow.setAttribute("id", `field_${fieldCount}`);
            let content = `
                            <div class="col-md-4 bg-light pt-1">
                                <div class="mb-3">
                                    <label for="size${fieldCount}" class="form-label text-blod">Product Size<sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <input type="text" class="form-control number-input" onkeyup="setupnumValid('size${fieldCount}')"  name="size[]" value="" id="size${fieldCount}"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="col-md-4 bg-light pt-1">
                                <div class="mb-3">
                                    <label for="sft${fieldCount}" class="form-label text-blod">SFT Ratio<sup
                                            class="text-danger"><b>*</b></sup></label>
                                    <input type="text" class="form-control number-input" onkeyup="setupnumValid('sft${fieldCount}')"  name="sft[]" value="" id="sft${fieldCount}"
                                        placeholder="">
                                </div>
                            </div>
                            `;
            if (productTypeInput != 0) {
                content += `
                <div class="col-md-1  bg-light pt-1 compoenet" style="display:unset;" id=""></div>
                    <div class="col-md-4 bg-light pt-1 compoenet1" style="display:unset;" id="">
                        <div class="mb-3">
                            <label for="quantity_farms" class="form-label text-blod">Quantity / Farma<sup class="text-danger"><b>*</b></sup></label>
                            <input type="text" class="form-control number-input"  name="quantity_farms[]" value="" id="quantity_farms" placeholder=""
                                >
                        </div>
                    </div>
                    <div class="col-md-4 bg-light pt-1 compoenet2" style="display:unset;" id="">
                        <div class="mb-3">
                            <label for="total_Farms" class="form-label text-blod">Total Farmas<sup class="text-danger"><b>*</b></sup></label>
                            <input type="text" class="form-control number-input"  name="total_Farms[]" value="" id="total_Farms" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-1 bg-light pt-1 pb-1 d-flex align-items-center justify-content-center compoenet2" >
                                <button class="btn btn-danger remove-button" type="button" onclick="removeField('field_${fieldCount}')"><i class="fa-solid fa-xmark"></i></button>
                            </div>


                    `;
            } else {
                content += `
                <div class="col-md-1  bg-light pt-1 compoenet" style="display:none;" id=""></div>
                    <div class="col-md-4 bg-light pt-1 compoenet1" style="display:none;" id="">
                        <div class="mb-3">
                            <label for="quantity_farms" class="form-label text-blod">Quantity / Farma<sup class="text-danger"><b>*</b></sup></label>
                            <input type="text" class="form-control number-input"  name="quantity_farms[]" value="" id="quantity_farms" placeholder=""
                                >
                        </div>
                    </div>
                    <div class="col-md-4 bg-light pt-1 compoenet2" style="display:none;" id="">
                        <div class="mb-3">
                            <label for="total_Farms" class="form-label text-blod">Total Farmas<sup class="text-danger"><b>*</b></sup></label>
                            <input type="text" class="form-control number-input"  name="total_Farms[]" value="" id="total_Farms" placeholder="">
                        </div>
                    </div> <div class="col-md-1 bg-light pt-1 pb-1 d-flex align-items-center justify-content-center">
                                <button class="btn btn-danger remove-button" type="button" onclick="removeField('field_${fieldCount}')"><i class="fa-solid fa-xmark"></i></button>
                            </div> `;
            }

            newProductRow.innerHTML = content;
            productField.appendChild(newProductRow);
            fieldCount++;
            fieldCountElement.value = fieldCount;
            var inputElements = document.querySelectorAll(".number-input");
            inputElements.forEach(function(inputElement) {
                applyInputBehavior(inputElement);
            });
            getLastProductDiv();
        }
        if (fieldCount == 0) {
            window.addEventListener('load', addField);
        }
        getLastProductDiv();

        function removeField(fieldId) {
            let fieldCountElementt = document.getElementById('fieldCount');
            let fieldCountt = parseInt(fieldCountElementt.value);
            const productField = document.getElementById('SizeField');

            let fieldToRemove = document.getElementById(fieldId);
            productField.removeChild(fieldToRemove);
            getLastProductDiv();
            fieldCountElementt.value = fieldCountt - 1;
        }
    </script>
@endsection
