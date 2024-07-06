<div class="row">
    <div class="col-md-4  pt-1" id="compoenetC1" style="display:{{ $display }};">
        <div class="mb-3">
            <label for="product_type" class="form-label">Product Type<sup class="text-danger"><b>*</b></sup></label>
            <select class="form-select form-select-md @error('product_type') is-invalid @enderror" name="product_type"
                id="product_type">
                <option value="">Choose Product Type</option>
                <option {{ old('product_type') == 'Tuff Tile' ? 'selected' : '' }} value="Tuff Tile">Tuff Tile</option>
                <option {{ old('product_type') == 'Patio & Outdoor Tile' ? 'selected' : '' }}
                    value="Patio & Outdoor Tile"> Patio & Outdoor Tile</option>
                <option {{ old('product_type') == 'Ramp Tile' ? 'selected' : '' }} value="Ramp Tile">Ramp Tile</option>
                <option {{ old('product_type') == 'Wall Tile' ? 'selected' : '' }} value="Wall Tile">Wall Tile</option>
                <option {{ old('product_type') == 'Water Pipe & Blocks' ? 'selected' : '' }}
                    value="Water Pipe & Blocks">
                    Water Pipe & Blocks</option>
                <option {{ old('product_type') == 'Others' ? 'selected' : '' }} value="Others">Others</option>
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
            <label for="height_type" class="form-label">Height Type<sup class="text-danger"><b>*</b></sup></label>
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
</div>
