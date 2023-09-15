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
            white-space: nowrap
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
            /* Set your desired color here */
        }

        span#select2-itemSelect-container,
        span#select2-select2customer_id-container {
            width: 100%;
            padding: 0.375rem 2.25rem 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: var(--bs-body-color);
            background-color: var(--bs-body-bg);
            background-image: var(--bs-form-select-bg-img), var(--bs-form-select-bg-icon, none);
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
            border: var(--bs-border-width) solid var(--bs-border-color);
            border-radius: var(--bs-border-radius);
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
    </style>
@endsection
@section('content')
    <div class="container mb-5">

        <div class="row">
            <div class="col-md-8   top-left-view">
                <span>Dispatched Chemical Concrete Pavers Stock Record Listings</span>
            </div>
            <div class="col-md-4  top-right-view d-flex align-items-center justify-content-end">
                <a href="{{ route('DchemicalTiles.create') }}" class="btn btn-primary float-right">Add Dispatch Stock</a>
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
                <form method="POST" action="{{ route('DchemicalTiles.filter') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="from_date" class="form-label filter-title">From Date</label>
                                <input type="date" class="form-control" name="from_date"
                                    value="{{ $filter['from_date'] ?? '' }}" id="from_date" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="to_date" class="form-label filter-title">To Date</label>
                                <input type="date" class="form-control" name="to_date"
                                    value="{{ $filter['to_date'] ?? '' }}" id="to_date" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="customer_id" class="form-label filter-title">Customer Name</label>
                                <select class="form-select form-select-md" name="customer_id" id="select2customer_id">
                                    <option value="">Choose Customer Name</option>
                                    @foreach ($customers as $customer)
                                        <option {{ ($filter['customer_id'] ?? '') == $customer->id ? 'selected' : '' }}
                                            value="{{ $customer->id }}">
                                            {{ $customer->customer_name, $filter['customer_id'] ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- <div class="col-md-3">
                            <div class="mb-3">
                                <label for="area" class="form-label">City / Area</label>

                                <input type="text" class="form-control" name="area" id="area"
                                    value="{{ $filter['area'] ?? '' }}">
                            </div>
                        </div> --}}
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="itemSelect" class="form-label filter-title">Product Name </label>
                                <select class="form-select form-select-md" name="product_id" id="itemSelect">
                                    <option value="">Choose Product Name</option>
                                    @foreach ($products as $product)
                                        <option {{ ($filter['product_id'] ?? '') == $product->id ? 'selected' : '' }}
                                            value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="size" class="form-label filter-title">Size </label>
                                <select id="showSize" class="form-select form-select-md" name="size" id="size">
                                    <option value="">Choose Size</option>
                                    @if (isset($filter['product_id']) && $filter['product_id'] !== null)
                                        @foreach ($sizes as $size)
                                            @if (($filter['product_id'] ?? '') == $size->product_id)
                                                <option {{ ($filter['size'] ?? '') == $size->id ? 'selected' : '' }}
                                                    value="{{ $size->id }}">{{ $size->size }}</option>
                                            @endif
                                        @endforeach
                                    @endif

                                </select>

                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="text-end mt-4">
                                <a href="{{ route('DchemicalTiles.index') }}"
                                    class="btn btn-light text-primary btn-rest">Reset</a>
                                <button type="submit" class="btn btn-primary">Apply Filter</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- ------------   View Tuff tiles          --------------- --}}

        <div class="card stockCard shadow-2-strong bg-white mt-5 py-2 px-3">
            <div class="card-header bg-white py-3">
                <h4 class="page-title">Dispatch Details</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="">
                        <thead class="">
                            <tr>
                                <th scope="col" rowspan="2" class="text-blod">B.No.</th>
                                <th scope="col" rowspan="2" class="text-blod">Date</th>
                                <th scope="col" rowspan="2" class="text-blod">Customer Name</th>
                                <th scope="col" rowspan="2" class="text-blod"> Contact No 1</th>
                                <th scope="col" rowspan="2" class="text-blod"> Contact No 2</th>
                                <th scope="col" rowspan="2" class="text-blod">Driver Name</th>
                                <th scope="col" rowspan="2" class="text-blod">City/Area</th>
                                <th scope="col" rowspan="2" class="text-blod">Product Name</th>
                                <th scope="col" rowspan="2" class="text-blod">Size</th>
                                <th scope="col" rowspan="2" class="text-blod">SFT Ratio</th>
                                <th scope="col" rowspan="2" class="text-blod">Total Tiles</th>
                                <th scope="col" colspan="5" class="text-blod text-center">Color's Quantity</th>
                                <th scope="col" rowspan="2" class="text-blod">Tiles in SFT</th>
                                <th scope="col" rowspan="2" class="text-blod">Price / SFT</th>
                                <th scope="col" rowspan="2" class="text-blod">Total Price</th>
                                <th scope="col" rowspan="2" class="text-blod">Vehicle Type</th>
                                <th scope="col" rowspan="2" class="text-blod">Vehicle No.</th>
                                <th scope="col" rowspan="2" class="text-blod">Action</th>
                            </tr>
                            <tr>
                                <th class="text-blod">Red</th>
                                <th class="text-blod">Gray</th>
                                <th class="text-blod">Black</th>
                                <th class="text-blod">Yellow</th>
                                <th class="text-blod">White</th>
                            </tr>

                        </thead class="table table-dark">
                        <tbody>
                            @foreach ($dispatches as $dispatch)
                                @php
                                    $count = $dispatch->products->count();
                                @endphp
                                {{-- @dump($dispatch->products->slice(1)) --}}
                                <tr>
                                    <td rowspan="{{ $count }}" class="align-middle">{{ $dispatch->bilti_no }}
                                    </td>
                                    <td rowspan="{{ $count }}" class="align-middle">{{ $dispatch->date }}</td>
                                    <td rowspan="{{ $count }}" class="align-middle">
                                        {{ $dispatch->customers?->customer_name }}
                                    </td>
                                    <td class="text-center">
                                        {{ $dispatch->contactNo1 == null ? '-' : $dispatch->contactNo1 }}</td>
                                    <td class="text-center">
                                        {{ $dispatch->contactNo2 == null ? '-' : $dispatch->contactNo2 }}</td>
                                    <td class="text-center">
                                        {{ $dispatch->driverName == null ? '-' : $dispatch->driverName }}</td>
                                    <td rowspan="{{ $count }}" class="align-middle long-text">
                                        {{ $dispatch->area }}</td>
                                    <td class="long-text">{{ $dispatch->products?->first()?->mainProduct->name }}</td>
                                    <td>{{ $dispatch->products?->first()?->mainSize->size }}</td>
                                    <td>{{ $dispatch->products?->first()?->sft_ratio }}</td>
                                    <td>{{ $dispatch->products?->first()?->total_tiles }}</td>
                                    <td>{{ $dispatch->products?->first()?->red_qty == null ? '-' : '' }}</td>
                                    <td>{{ $dispatch->products?->first()?->grey_qty == null ? '-' : '' }}</td>
                                    <td>{{ $dispatch->products?->first()?->black_qty == null ? '-' : '' }}</td>
                                    <td>{{ $dispatch->products?->first()?->yellow_qty == null ? '-' : '' }}</td>
                                    <td>{{ $dispatch->products?->first()?->white_qty == null ? '-' : '' }}</td>

                                    <td>{{ $dispatch->products?->first()?->total_tiles_sft }}</td>
                                    <td>{{ $dispatch->products?->first()?->price_sft }}</td>
                                    <td>{{ $dispatch->products?->first()?->total_price }}</td>
                                    <td rowspan="{{ $count }}" class="align-middle">{{ $dispatch->vehicle_type }}
                                    </td>
                                    <td rowspan="{{ $count }}" class="align-middle">
                                        {{ $dispatch->vehicle_number }}</td>
                                    <td rowspan="{{ $count }}" class="align-middle">
                                        {{-- view --}}
                                        <a href="" class="btn btn-primary btn-sm">View</a>
                                        {{-- print Bilti --}}
                                        <a href="" class="btn btn-info btn-sm">Print Bilti</a>
                                        <!-- edit -->
                                        <a class="btn  btn-sm btn-parrot-green text-white"
                                            href="{{ route('DchemicalTiles.edit', $dispatch->id) }}"><i
                                                class="fa-solid fa-pencil"></i></a>
                                        <!-- delete -->
                                        @php
                                            $model_id = 'modelDelete' . $dispatch->id;
                                        @endphp
                                        @component('components.delete-model', [
                                            'modelId' => $model_id,
                                            'Action' => route('DchemicalTiles.softDelete', $dispatch->id),
                                        ])
                                        @endcomponent

                                    </td>
                                </tr>
                                @if ($count > 1)
                                    @foreach ($dispatch->products->slice(1) as $product)
                                        <tr>
                                            <td class="long-text">{{ $product->mainProduct->name }}</td>
                                            <td>{{ $product->mainSize->size }}</td>
                                            <td>{{ $product->sft_ratio }}</td>
                                            <td>{{ $product->total_tiles }}</td>
                                            <td>{{ $product->red_qty == null ? '-' : '' }}</td>
                                            <td>{{ $product->grey_qty == null ? '-' : '' }}</td>
                                            <td>{{ $product->black_qty == null ? '-' : '' }}</td>
                                            <td>{{ $product->yellow_qty == null ? '-' : '' }}</td>
                                            <td>{{ $product->white_qty == null ? '-' : '' }}</td>
                                            <td>{{ $product->total_tiles_sft }}</td>
                                            <td>{{ $product->price_sft }}</td>
                                            <td>{{ $product->total_price }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>


        </div>

        {{-- ----------------     Dispatched Stock Summary       ---------------------- --}}
        <div class="row justify-content-center mt-5">

            {{-- Total Dispatched Stock Summary - Customer Wise --}}
            <div class="col-md-5">
                <div class="card  shadow-2-strong bg-white mt-2 ">
                    <div class="card-header bg-blue text-center text-white">
                        Total Dispatched Stock Summary - Customer Wise
                    </div>
                    <div class="table-responsive m-3">
                        <table class="table table-bordered" id="">
                            <thead class="">
                                <tr>
                                    <th scope="col" class="text-blod">Customer Name</th>
                                    <th scope="col" class="text-blod">Stocked Dispatched</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $grandCustomerTotal = 0;
                                @endphp
                                @foreach ($customersummery as $summery)
                                    <tr>
                                        <td>{{ $summery['customer_name'] }}</td>
                                        <td>{{ $summery['total_qty'] }}</td>
                                    </tr>
                                    @php
                                        $grandCustomerTotal += $summery['total_qty'];
                                    @endphp
                                @endforeach
                            </tbody>
                            <thead class="">
                                <tr>
                                    <th scope="col" class="text-end text-blod">Grand Total:</th>
                                    <th scope="col" style="font-weight: 300;">{{ $grandCustomerTotal }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            {{--          Total Dispatched Stock Summary - Based on Product name & size --}}
            <div class="col-md-7">
                <div class="card  shadow-2-strong bg-white mt-2 ">
                    <div class="card-header bg-blue text-center text-white">
                        Total Dispatched Stock Summary - Based on Product name & size
                    </div>
                    <div class="table-responsive m-3">
                        @php
                            $productTotals = [];
                            $GrandTotalProduct = 0;
                        @endphp

                        @foreach ($dispatches as $dispatch)
                            @foreach ($dispatch->products as $product)
                                @php
                                    $key = $product->mainProduct->name . $product->mainSize->size;
                                @endphp

                                @if (!isset($productTotals[$key]))
                                    @php
                                        $productTotals[$key] = [
                                            'name' => $product->mainProduct->name,
                                            'size' => $product->mainSize->size,
                                            'total' => 0,
                                        ];
                                    @endphp
                                @endif

                                @php
                                    $productTotals[$key]['total'] += $product->total_tiles_sft;
                                    $GrandTotalProduct += $product->total_tiles_sft;
                                @endphp
                            @endforeach
                        @endforeach

                        <table class="table table-bordered" id="">
                            <thead class="">
                                <tr>
                                    <th scope="col" class="text-blod">Product Name</th>
                                    <th scope="col" class="text-blod">Size</th>
                                    <th scope="col" class="text-blod">Total Tiles in SFT</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productTotals as $key => $productTotal)
                                    <tr>
                                        <td>{{ $productTotal['name'] }}</td>
                                        <td>{{ $productTotal['size'] }}</td>
                                        <td>{{ $productTotal['total'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <thead class="">
                                <tr>
                                    <th scope="col" class="text-end text-blod" colspan="2">Grand Total:</th>
                                    <th scope="col" style="font-weight: 300;">{{ $GrandTotalProduct }}</th>
                                </tr>
                            </thead>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#select2customer_id').select2({});
            $('#itemSelect').select2({});

            $('#itemSelect').on('change', function() {
                const idToFetch = $(this).val();
                const url = window.location.origin + '/fetchSize/' + idToFetch;
                $('#showSize').empty();
                $('#showSize').append('<option value="">Choose Size</option>')
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $.each(response, function(index, value) {
                            $('#showSize').append('<option value="' + value['id'] +
                                '">' + value['size'] + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
@endsection
