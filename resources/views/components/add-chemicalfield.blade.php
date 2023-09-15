<div class="row justify-content-center">
    <div class="col-md-4  pt-1" id="compoenetC1" style="display:{{ $display }};">
        <div class="mb-3">
            <label for="product_type" class="form-label text-blod">Product Type<sup
                    class="text-danger"><b>*</b></sup></label>
            <select class="form-select form-select-md @error('product_type') is-invalid @enderror" name="product_type"
                id="product_type">
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
    <div class="col-md-4 pt-1" id="compoenetC2" style="display:{{ $display }};">
        <div class="mb-3">
            <label for="height_type" class="form-label text-blod">Height Type<sup
                    class="text-danger"><b>*</b></sup></label>
            <select class="form-select form-select-md @error('height_type') is-invalid @enderror" name="height_type"
                id="height_type">
                <option value=""> Choose Height Type</option>
                <option {{ old('height_type') == '0.5 Inch' ? 'selected' : '' }} value="0.5 Inch">0.5 Inch</option>
                <option {{ old('height_type') == '1 Inch' ? 'selected' : '' }} value="1 Inch">1 Inch</option>
                <option {{ old('height_type') == '2 Inch' ? 'selected' : '' }} value="2 Inch">2 Inch</option>
                <option {{ old('height_type') == 'Others' ? 'selected' : '' }} value="Others">Others</option>
            </select>
            @error('height_type')
                <span class="invalid-feedback mt-2" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-1" id="compoenetC3" style="display:{{ $display }};"></div>

</div>
