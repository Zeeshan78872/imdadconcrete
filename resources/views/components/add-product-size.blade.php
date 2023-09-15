<div class="col-md-1  bg-light compoenet"id="" style="display:{{ $display }};"></div>
<div class="col-md-4 bg-light pt-1 compoenet1" id="" style="display:{{ $display }};">
    <div class="mb-3">
        <label for="quantity_farms" class="form-label text-blod">Quantity / Farma<sup
                class="text-danger"><b>*</b></sup></label>
        <input type="number" class="form-control number-input @error('quantity_farms.' . $count) is-invalid @enderror"
            name="quantity_farms[]" value="{{ old('quantity_farms.' . $count) }}" id="quantity_farms" placeholder="">
        @error('quantity_farms.' . $count)
            <span class="invalid-feedback mt-2" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

    </div>
</div>
<div class="col-md-4 bg-light pt-1 compoenet2" id="" style="display:{{ $display }};">
    <div class="mb-3">
        <label for="total_Farms" class="form-label text-blod">Total Farmas<sup
                class="text-danger"><b>*</b></sup></label>
        <input type="number" class="form-control number-input @error('total_Farms.' . $count) is-invalid @enderror"
            name="total_Farms[]" value="{{ old('total_Farms.' . $count) }}" id="total_Farms" placeholder="">
        @error('total_Farms.' . $count)
            <span class="invalid-feedback mt-2" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
