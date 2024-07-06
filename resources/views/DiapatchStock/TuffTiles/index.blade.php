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

        th {}

        .table thead th {
            background-color: rgba(238, 242, 247, 1);
            font-family: Nunito;
            font-size: 15px;
            font-weight: 600;
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
    </style>
@endsection
@section('content')
    <div class="container mb-5">
        <div class="inner-container">
            <span>Dispatched Tuff Tiles & Blocks Record Listings</span>
            <a href="{{ route('DtuffTile.create') }}" class="btn btn-primary float-right">Add Dispatch Stock</a>
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
                <form method="POST" action="{{ route('DtuffTile.filter') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="from_date" class="form-label">From Date</label>
                                <input type="date" class="form-control" name="from_date"
                                    value="{{ $filter['from_date'] ?? '' }}" id="from_date" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="to_date" class="form-label">To Date</label>
                                <input type="date" class="form-control" name="to_date"
                                    value="{{ $filter['to_date'] ?? '' }}" id="to_date" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="customer_id" class="form-label">Customer Name</label>
                                <select class="form-select form-select-md" name="customer_id" id="customer_id">
                                    <option value="">Choose Customer Name</option>
                                    @foreach ($Dispatch as $customer)
                                        <option
                                            {{ ($filter['customer_id'] ?? '') == $customer->customer_id ? 'selected' : '' }}
                                            value="{{ $customer->customer_id }}">
                                            {{ $customer->customers?->customer_name, $filter['customer_id'] ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="area" class="form-label">City / Area</label>

                                <input type="text" class="form-control" name="area" id="area"
                                    value="{{ $filter['area'] ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="product_id" class="form-label">Product Name </label>
                                <select id="itemSelect" class="form-select form-select-md" name="product_id"
                                    id="product_id">
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
                                <label for="size" class="form-label">Size </label>
                                <select id="showSize" class="form-select form-select-md" name="size" id="size">
                                    <option value="">Choose Size</option>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-end mt-4">
                                <a href="{{ route('DtuffTile.index') }}"
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
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="">
                        <thead class="">
                            <tr>
                                <th scope="col" rowspan="2">B.No.</th>
                                <th scope="col" rowspan="2">Date</th>
                                <th scope="col" rowspan="2">Customer Name</th>
                                <th scope="col" rowspan="2">City/Area</th>
                                <th scope="col" rowspan="2">Product Name</th>
                                <th scope="col" rowspan="2">Size</th>
                                <th scope="col" rowspan="2">SFT Ratio</th>
                                <th scope="col" rowspan="2">Total Tiles</th>
                                <th scope="col" colspan="2">Color's Quantity</th>
                                <th scope="col" rowspan="2">Tiles in SFT</th>
                                <th scope="col" rowspan="2">Price / SFT</th>
                                <th scope="col" rowspan="2">Total Price</th>
                                <th scope="col" rowspan="2">Vehicle Type</th>
                                <th scope="col" rowspan="2">Vehicle No.</th>
                                <th scope="col" rowspan="2">Action</th>
                            </tr>
                            <tr>
                                <th>Red</th>
                                <th>Gray</th>
                            </tr>

                        </thead class="table table-dark">
                        <tbody>
                            @foreach ($dispatches as $dispatch)
                                @php
                                    $count = $dispatch->products->count();
                                @endphp
                                <tr>
                                    <td rowspan="{{ $count }}" class="align-middle">{{ $dispatch->bilti_no }}
                                    </td>
                                    <td rowspan="{{ $count }}" class="align-middle">{{ $dispatch->date }}</td>
                                    <td rowspan="{{ $count }}" class="align-middle">
                                        {{ $dispatch->customers?->customer_name }}
                                    </td>
                                    <td rowspan="{{ $count }}" class="align-middle">{{ $dispatch->area }}</td>
                                    <td>{{ $dispatch->products?->first()?->mainProduct->name }}</td>
                                    <td>{{ $dispatch->products?->first()?->mainSize->size }}</td>
                                    <td>{{ $dispatch->products?->first()?->sft_ratio }}</td>
                                    <td>{{ $dispatch->products?->first()?->total_tiles }}</td>
                                    <td>{{ $dispatch->products?->first()?->red_qty }}</td>
                                    <td>{{ $dispatch->products?->first()?->grey_qty }}</td>
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
                                        <a class="btn  btn-sm btn-parrot-green text-white" href=""><i
                                                class="fa-solid fa-pencil"></i></a>
                                        <!-- delete -->
                                        @component('components.delete-model', ['modelId' => '', 'Action' => route('DtuffTile.destroy', $dispatch->id)])
                                        @endcomponent

                                    </td>
                                </tr>
                                @if ($count > 1)
                                    @foreach ($dispatch->products->slice(1) as $product)
                                    @endforeach
                                    <tr>
                                        <td>{{ $product->mainProduct->name }}</td>
                                        <td>{{ $product->mainSize->size }}</td>
                                        <td>{{ $product->sft_ratio }}</td>
                                        <td>{{ $product->total_tiles }}</td>
                                        <td>{{ $product->red_qty }}</td>
                                        <td>{{ $product->grey_qty }}</td>
                                        <td>{{ $product->total_tiles_sft }}</td>
                                        <td>{{ $product->price_sft }}</td>
                                        <td>{{ $product->total_price }}</td>
                                    </tr>
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
                                    <th scope="col">Customer Name</th>
                                    <th scope="col">Stocked Dispatched</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($CustomerSummery as $summery)
                                    <tr>
                                        <td>{{ $summery['customer_name'] }}</td>
                                        <td>{{ $summery['TotalStocked'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <thead class="">
                                <tr>
                                    <th scope="col" class="text-end">Grand Total:</th>
                                    <th scope="col">{{ $OverallStock }}</th>
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
                        <table class="table table-bordered" id="">
                            <thead class="">
                                <tr>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Size</th>
                                    <th scope="col">Total Tiles in SFT </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $GrandTotalProduct = 0;
                                @endphp
                                @foreach ($dispatches as $dispatch)
                                    @foreach ($dispatch->products as $product)
                                        @php
                                            $GrandTotalProduct += $product->total_tiles_sft;
                                        @endphp
                                        <tr>
                                            <td>{{ $product->mainProduct->name }}</td>
                                            <td>{{ $product->mainSize->size }}</td>
                                            <td>{{ $product->total_tiles_sft }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                            <thead class="">
                                <tr>
                                    <th scope="col" class="text-end" colspan="2">Grand Total:</th>
                                    <th scope="col">{{ $GrandTotalProduct }}</th>
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
    <script>
        $(document).ready(function() {
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
