@extends('layouts.app')

@section('style')
    <style>
        .card {
            width: 100%;
        }

        .inner-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table thead th {
            background-color: rgba(238, 242, 247, 1);
            font-family: Nunito;
            font-size: 15px;
            line-height: 22px;
            letter-spacing: 0em;
            text-align: left;
            white-space: nowrap;
        }

        .table tbody td {
            font-family: Nunito;
            font-size: 14px;
            font-weight: 400;
            line-height: 22px;
            letter-spacing: 0em;
            text-align: left;
            white-space: nowrap;
        }

        table.table-bordered tbody {
            background-color: #ffffff !important;
        }
    </style>
@endsection
@section('content')
    <div class="container mb-5">

        <div class="row">
            <div class="col-md-6   top-left-view">
                <span>Gravel and Sand Stock Listing</span>
            </div>
            <div class="col-md-6  top-right-view d-flex align-items-center justify-content-end">
                <a href="{{ route('gravelSand.create') }}" class="btn btn-primary">Add Incoming Stock</a>
            </div>
        </div>

        <!-------------------- Apply Filter ---------------------->

        <div class="card stockCard shadow-2-strong bg-white mt-5 ">
            <div class="card-header bg-white py-3">
                <h4 class="page-title">FILTERS</h4>
            </div>
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('gravelSand.filter') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="from_date" class="form-label filter-title">From Date</label>
                                <input type="date" class="form-control" value="{{ $filter['from_date'] ?? '' }}"
                                    name="from_date" id="from_date" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="to_date" class="form-label filter-title">To Date</label>
                                <input type="date" class="form-control" value="{{ $filter['to_date'] ?? '' }}"
                                    name="to_date" id="to_date" placeholder="">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="material_type" class="form-label filter-title">Material Type</label>
                                <select class="form-select form-select-md" name="material_type" id="material_type">
                                    <option value="">Choose Material Type </option>
                                    @foreach ($materialTypes as $type)
                                        <option {{ ($filter['material_type'] ?? '') == $type ? 'selected' : '' }}
                                            value="{{ $type }}">
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="seller_name" class="form-label filter-title">Seller Name</label>
                                <select class="form-select form-select-md" name="seller_name" id="seller_name">
                                    <option value="">Choose Seller Name</option>
                                    @foreach ($sellerNames as $name)
                                        <option {{ ($filter['seller_name'] ?? '') == $name ? 'selected' : '' }}
                                            value="{{ $name }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="text-end mt-4">
                                <a href="{{ route('gravelSand.index') }}"
                                    class="btn btn-light text-primary btn-rest mx-3">Reset</a>
                                <button type="submit" class="btn btn-primary">Apply Filter</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <!-------------------- View gravel sand  ---------------------->

        <div class="card stockCard shadow-2-strong bg-white mt-5 py-2 px-3">
            <div class="card-body">
                <h4 class="page-title mb-3">GRAVEL AND SAND STOCK LISTING</h4>
                <div class="table-responsive">
                    <table class="table table-bordered" id="">
                        <thead class="">
                            <tr>
                                <th scope="col" class="text-blod">S.NO</th>
                                <th scope="col" class="text-blod">Date</th>
                                <th scope="col" class="text-blod">Vehicle No.</th>
                                <th scope="col" class="text-blod">Bilti No.</th>
                                <th scope="col" class="text-blod">Material Type</th>
                                <th scope="col" class="text-blod">Lenght</th>
                                <th scope="col" class="text-blod">Width</th>
                                <th scope="col" class="text-blod">Height</th>
                                <th scope="col" class="text-blod">Seller Name</th>
                                <th scope="col" class="text-blod">Total Measurements in SFT</th>
                                <th scope="col" class="text-blod">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sr = 1;
                            @endphp
                            @foreach ($gravleSands as $gravleSand)
                                <tr>
                                    <td>{{ $sr }}</td>
                                    <td>{{ $gravleSand->date }}</td>
                                    <td>{{ $gravleSand->vehicle_no }}</td>
                                    <td>{{ $gravleSand->bilti_no }}</td>
                                    <td>{{ $gravleSand->material_type }}</td>
                                    <td>{{ $gravleSand->length }}</td>
                                    <td>{{ $gravleSand->width }}</td>
                                    <td>{{ $gravleSand->height }}</td>
                                    <td>{{ $gravleSand->seller_name }}</td>
                                    <td>{{ $gravleSand->total_measeurement }}</td>
                                    <td>
                                        <!-- edit -->
                                        <a class="btn  btn-sm btn-parrot-green text-white"
                                            href="{{ route('gravelSand.edit', $gravleSand->id) }}"><i
                                                class="fa-solid fa-pencil"></i></a>
                                        <!-- delete -->
                                        <!-- Modal Body -->
                                        @php
                                            $model_id = 'deletemodel' . $gravleSand->id;
                                        @endphp
                                        @component('components.delete-model', [
                                            'Action' => route('gravelSand.destroy', $gravleSand->id),
                                            'modelId' => $model_id,
                                        ])
                                        @endcomponent

                                    </td>
                                </tr>
                                @php
                                    $sr++;
                                @endphp
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
        <!-------------------- Calculate summery ---------------------->

        <div class="card stockCard shadow-2-strong bg-white mt-5 ">
            <div class="card-header bg-white py-3 text-center">
                <h4 class="page-title">Calculate Material Rate</h4>
            </div>
            <div class="card-body">

                {{-- <form method="POST" action="{{ route('gravelSand.filter') }}"> --}}
                {{-- @csrf --}}
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="calmaterial_type" class="form-label filter-title">Material Type <sup
                                    class="text-danger"><b>*</b></sup></label>
                            <select class="form-select form-select-md" name="material_type" id="calmaterial_type">
                                <option value="">Choose Material Type </option>
                                @foreach ($materialTypes as $type)
                                    <option value="{{ $type }}">
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="material_rate" class="form-label filter-title">Enter Material Rate <sup
                                    class="text-danger"><b>*</b></sup></label>
                            <input type="text" class="form-control" name="material_rate" id="material_rate">
                        </div>
                    </div>
                    {{-- <div class="row justify-content-center"> --}}
                    <div class="col-md-12">
                        <div class="text-center mt-4">
                            <button type="button" class="btn btn-primary ">Download Record Pdf </button>
                            <button type="button" class="btn btn-primary mx-3">Print Record Pdf </button>
                            <button type="button" onclick="CalculateMaterialPrice()"
                                class="btn btn-primary">Calculate</button>
                        </div>
                    </div>
                    {{-- </div> --}}


                </div>
                {{-- </form> --}}
            </div>
        </div>
        {{-- Summery --}}
        <div class="card  shadow-2-strong bg-white mt-5 ">
            <div class="card-header bg-blue text-center text-white">
                Summery
            </div>
            <div class="table-responsive m-3">
                <table class="table table-bordered" id="">
                    <thead class="">
                        <tr>
                            <th scope="col">Material Type</th>
                            <th scope="col">Total Vehicle</th>
                            <th scope="col">Total Quantity in SFT</th>
                            <th scope="col">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $grand_total_vehicles = 0;
                            $grand_total_quantitys = 0;
                        @endphp
                        @foreach ($summery as $key => $value)
                            @php
                                $grand_total_vehicles += $value->total_vehicles;
                                $grand_total_quantitys += $value->total_quantity;
                            @endphp
                            <tr>
                                <td>{{ $value->material_type }}</td>
                                <td>{{ $value->total_vehicles }}</td>
                                <td id="{{ $value->material_type }}_qty">{{ $value->total_quantity }}</td>
                                <td id="{{ $value->material_type }}_prc">0</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <thead class="">
                        <tr>
                            <th scope="col" class="text-end">Grand Total:</th>
                            <th scope="col" style="font-weight: 300;">{{ $grand_total_vehicles }}</th>
                            <th scope="col" style="font-weight: 300;">{{ $grand_total_quantitys }}</th>
                            <th id="GrandPrice" scope="col" style="font-weight: 300;">0</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>
@endsection
@section('script')
    <script>
        let GrandPrice = document.getElementById('GrandPrice');
        GrandPrice.textContent = 0;
        let totalGrandPrice = 0;

        function CalculateMaterialPrice() {
            let material_type = document.getElementById('calmaterial_type');
            let material_value = material_type.value;

            let material_rate = document.getElementById('material_rate');
            let rate_value = parseFloat(material_rate.value);
            // fetch qty value
            let qty = document.getElementById(material_value + '_qty');
            let price = document.getElementById(material_value + '_prc');
            if (parseFloat(price.textContent) != 0) {
                totalGrandPrice -= parseFloat(price.textContent);
            }
            let totalPrice = rate_value * parseFloat(qty.textContent);
            price.textContent = totalPrice.toFixed(2);

            totalGrandPrice += totalPrice;
            GrandPrice.textContent = totalGrandPrice.toFixed(2);
            let material_array = ``;
            console.log(qty.textContent);
        }

        function toggleRowSelection(selectAllCheckbox) {
            var rowCheckboxes = document.getElementsByClassName('rowCheckbox');
            for (var i = 0; i < rowCheckboxes.length; i++) {
                rowCheckboxes[i].checked = selectAllCheckbox.checked;
            }
        }

        function checkSelectAllCheckbox() {
            var selectAllCheckbox = document.getElementById('selectAllCheckbox');
            var rowCheckboxes = document.getElementsByClassName('rowCheckbox');
            var allRowCheckboxesChecked = true;
            for (var i = 0; i < rowCheckboxes.length; i++) {
                if (!rowCheckboxes[i].checked) {
                    allRowCheckboxesChecked = false;
                    break;
                }
            }
            selectAllCheckbox.checked = allRowCheckboxesChecked;
        }
    </script>
@endsection
