@extends('layouts.app')

@section('style')
    <style>
        .page-title {
            font-family: Nunito;
            font-size: 16px;
            font-weight: 500;
            line-height: 16px;
            letter-spacing: 0.2879999876022339px;
        }

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

        .bg-color td,
        .bg-color th {
            background: linear-gradient(to bottom, #fff, #f1f1f1b5);
        }

        .nav-tabs .nav-link.active {
            background-color: #0f256e !important;
            color: #ffffff !important;
            border-radius: unset;
        }

        .nav.nav-tabs {
            background-color: rgba(222, 226, 230, 1);
        }

        .nav-tabs .nav-link {
            color: #000;
        }

        .tab-title {
            font-family: Nunito;
            font-size: 17px;
            font-weight: 500;
            line-height: 16px;
            letter-spacing: 0.2879999876022339px;
            text-align: left;

        }

        .customer-table th {
            font-family: Nunito;
            font-size: 16px;
            font-weight: 400;
            line-height: 22px;
            letter-spacing: 0em;
            text-align: left;
            border-color: rgba(222, 226, 230, 1) !important;
        }

        .customer-table td {
            font-family: Nunito;
            font-size: 15px;
            font-weight: 600;
            line-height: 22px;
            letter-spacing: 0em;
            text-align: left;
            border-color: rgba(222, 226, 230, 1) !important;
        }


        .card-header:not(.collapsed) .rotate-icon {
            transform: rotate(180deg);
        }

        .btn .fa-solid {
            float: right;
            transition: transform 0.2s;
        }

        /* Style the icon to rotate when the collapsible is active */
        .collapse.show .icon {
            transform: rotate(180deg);
            transition: transform 0.3s ease;
        }
    </style>
    <!-- Add the jQuery library -->
@endsection
@section('content')
    <div class="container mb-5">
        <div class="row">
            <div class="col-md-6   top-left-view">
                <span>{{ $customer->customer_name }} ({{ $customer->company_name }})</span>
            </div>
        </div>
        {{-- filter apply --}}
        <div class="card stockCard shadow-2-strong bg-white mt-3 ">
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
                                <label for="product_id" class="form-label filter-title">Product Category </label>
                                <select id="itemSelect" class="form-select form-select-md" name="product_id"
                                    id="product_id">
                                    <option value="">Choose Category</option>
                                    {{-- @foreach ($products as $product)
                                        <option {{ ($filter['product_id'] ?? '') == $product->id ? 'selected' : '' }}
                                            value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="product_id" class="form-label filter-title">Product Name </label>
                                <select id="itemSelect" class="form-select form-select-md" name="product_id"
                                    id="product_id">
                                    <option value="">Choose Product Name</option>
                                    {{-- @foreach ($products as $product)
                                        <option {{ ($filter['product_id'] ?? '') == $product->id ? 'selected' : '' }}
                                            value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="size" class="form-label filter-title">Size </label>
                                <select id="showSize" class="form-select form-select-md" name="size" id="size">
                                    <option value="">Choose Size</option>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="size" class="form-label filter-title">City / Area </label>
                                <input type="text" class="form-control" name="" id=""
                                    aria-describedby="helpId" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="size" class="form-label filter-title">Bank Name</label>
                                <select id="showSize" class="form-select form-select-md" name="size" id="size">
                                    <option value="">Choose Bank Name</option>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-end mt-4">
                                <a href="{{ route('DtuffTile.index') }}"
                                    class="btn btn-light text-primary btn-rest mx-3">Reset</a>
                                <button type="submit" class="btn btn-primary">Apply Filter</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="card stockCard shadow-2-strong bg-white mt-5 ">
            <div class="card-body">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <button class="nav-link  active" id="nav-customerDetail-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-customerDetail" type="button" role="tab" aria-controls="nav-home"
                            aria-selected="true">Customer Detail</button>
                        <button class="nav-link" id="nav-dispatchDetail-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-dispatchDetail" type="button" role="tab"
                            aria-controls="nav-profile" aria-selected="false">Dispatch Detail</button>
                        <button class="nav-link" id="nav-payment-tab" data-bs-toggle="tab" data-bs-target="#nav-payment"
                            type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Payment
                            History</button>
                        <button class="nav-link" id="nav-materialDispatch-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-materialDispatch" type="button" role="tab"
                            aria-controls="nav-profile" aria-selected="false">Final Material Dispatch & Payment
                            Report</button>

                        <button class="nav-link" id="nav-bilti-tab" data-bs-toggle="tab" data-bs-target="#nav-bilti"
                            type="button" role="tab" aria-controls="nav-bilti" aria-selected="false">Bilti</button>
                        <button class="nav-link" id="nav-invoice-tab" data-bs-toggle="tab" data-bs-target="#nav-invoice"
                            type="button" role="tab" aria-controls="nav-profile"
                            aria-selected="false">Invoice</button>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                    {{-- CUSTOMERS DETAIL --}}
                    <div class="tab-pane fade show active pt-3" id="nav-customerDetail" role="tabpanel"
                        aria-labelledby="nav-customerDetail-tab">
                        <span class="tab-title mx-3">CUSTOMERS DETAIL</span>
                        <div class="table-responsive">
                            <table class="table table-bordered mt-2">
                                <tr class="customer-table">
                                    <th scope="col" class=" bg-light">Customer ID</th>
                                    <td scope="col">{{ $customer->customer_id }}</td>
                                    <th scope="col" class=" bg-light">Customer Name</th>
                                    <td scope="col">{{ $customer->customer_name }}</td>
                                </tr>
                                <tr class="customer-table">
                                    <th scope="col" class=" bg-light">Company Name</th>
                                    <td scope="col">{{ $customer->company_name }}</td>
                                    <th scope="col" class=" bg-light">City or Area</th>
                                    <td scope="col">{{ $customer->city_area }}</td>
                                </tr>
                                <tr class="customer-table">
                                    <th scope="col" class=" bg-light">Phone Number 1</th>
                                    <td scope="col">{{ $customer->phone_number_1 }}</td>
                                    <th scope="col" class=" bg-light">Phone Number 2</th>
                                    <td scope="col">{{ $customer->phone_number_2 }}</td>
                                </tr>
                            </table>
                        </div>

                    </div>
                    {{-- Dispatch Detail --}}
                    <div class="tab-pane fade pt-3" id="nav-dispatchDetail" role="tabpanel"
                        aria-labelledby="nav-dispatchDetail-tab">
                        <span class="tab-title mx-3">Dispatch Detail </span>
                        <div id="accordion">
                            {{-- tuff tiles  --}}
                            <div class="my-2">
                                <div class="">
                                    <a class="btn btn-primary d-flex justify-content-between align-items-center"
                                        style="width: -webkit-fill-available;" data-bs-toggle="collapse"
                                        href="#collapseOne">
                                        Tuff Tiles <i class="fa-solid fa-angle-down"></i>
                                    </a>
                                </div>
                                <div id="collapseOne" class="collapse show" data-bs-parent="#accordion">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="">
                                                <thead class="">
                                                    <tr>
                                                        <th scope="col" rowspan="2" class="text-blod">B.No.</th>
                                                        <th scope="col" rowspan="2" class="text-blod">Date</th>

                                                        <th scope="col" rowspan="2" class="text-blod"> Contact No 1
                                                        </th>
                                                        <th scope="col" rowspan="2" class="text-blod"> Contact No 2
                                                        </th>
                                                        <th scope="col" rowspan="2" class="text-blod">Driver Name
                                                        </th>
                                                        <th scope="col" rowspan="2" class="text-blod">City/Area
                                                        </th>
                                                        <th scope="col" rowspan="2" class="text-blod">Product Name
                                                        </th>
                                                        <th scope="col" rowspan="2" class="text-blod">Size</th>
                                                        <th scope="col" rowspan="2" class="text-blod">SFT Ratio
                                                        </th>
                                                        <th scope="col" rowspan="2" class="text-blod">Total Tiles
                                                        </th>
                                                        <th scope="col" colspan="2" class="text-blod">Color's
                                                            Quantity</th>
                                                        <th scope="col" rowspan="2" class="text-blod">Tiles in SFT
                                                        </th>
                                                        <th scope="col" rowspan="2" class="text-blod">Price / SFT
                                                        </th>
                                                        <th scope="col" rowspan="2" class="text-blod">Total Price
                                                        </th>
                                                        <th scope="col" rowspan="2" class="text-blod">Vehicle Type
                                                        </th>
                                                        <th scope="col" rowspan="2" class="text-blod">Vehicle No.
                                                        </th>
                                                        <th scope="col" rowspan="2" class="text-blod">Action</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-blod">Red</th>
                                                        <th class="text-blod">Gray</th>
                                                    </tr>

                                                </thead class="table table-dark">
                                                <tbody>
                                                    @foreach ($dispatch_Tufftiles as $dispatch)
                                                        @php
                                                            $count = $dispatch->products->count();
                                                        @endphp
                                                        <tr>
                                                            <td rowspan="{{ $count }}" class="align-middle">
                                                                {{ $dispatch->bilti_no }}
                                                            </td>
                                                            <td rowspan="{{ $count }}" class="align-middle">
                                                                {{ $dispatch->date }}</td>


                                                            <td class="text-center align-middle"
                                                                rowspan="{{ $count }}">
                                                                {{ $dispatch->contactNo1 == null ? '-' : $dispatch->contactNo1 }}
                                                            </td>
                                                            <td class="text-center align-middle"
                                                                rowspan="{{ $count }}">
                                                                {{ $dispatch->contactNo2 == null ? '-' : $dispatch->contactNo2 }}
                                                            </td>
                                                            <td class="text-center align-middle"
                                                                rowspan="{{ $count }}">
                                                                {{ $dispatch->driverName == null ? '-' : $dispatch->driverName }}
                                                            </td>
                                                            <td class="long-text align-middle"
                                                                rowspan="{{ $count }}">
                                                                {{ $dispatch->area }}</td>
                                                            <td class="long-text">
                                                                {{ $dispatch->products?->first()?->mainProduct->name }}
                                                            </td>
                                                            <td>{{ $dispatch->products?->first()?->mainSize->size }}</td>
                                                            <td>{{ $dispatch->products?->first()?->sft_ratio }}</td>
                                                            <td>{{ $dispatch->products?->first()?->total_tiles }}</td>
                                                            <td>{{ $dispatch->products?->first()?->red_qty == null ? '-' : $dispatch->products?->first()?->red_qty }}
                                                            </td>
                                                            <td>{{ $dispatch->products?->first()?->grey_qty == null ? '-' : $dispatch->products?->first()?->grey_qty }}
                                                            </td>
                                                            <td>{{ $dispatch->products?->first()?->total_tiles_sft }}</td>
                                                            <td>{{ $dispatch->products?->first()?->price_sft }}</td>
                                                            <td>{{ $dispatch->products?->first()?->total_price }}</td>
                                                            <td rowspan="{{ $count }}" class="align-middle">
                                                                {{ $dispatch->vehicle_type }}
                                                            </td>
                                                            <td rowspan="{{ $count }}" class="align-middle">
                                                                {{ $dispatch->vehicle_number }}</td>
                                                            <td rowspan="{{ $count }}" class="align-middle">
                                                                {{-- view --}}
                                                                <a href="" class="btn btn-primary btn-sm">View</a>
                                                                {{-- print Bilti --}}
                                                                <a href="" class="btn btn-info btn-sm">Print
                                                                    Bilti</a>
                                                                <!-- edit -->
                                                                <a class="btn  btn-sm btn-parrot-green text-white"
                                                                    href="{{ route('DtuffTile.edit', $dispatch->id) }}"><i
                                                                        class="fa-solid fa-pencil"></i></a>
                                                                <!-- delete -->
                                                                @php
                                                                    $model_Id = 'modelDelete' . $dispatch->id;
                                                                @endphp

                                                                @component('components.soft-delete-model', [
                                                                    'modelId' => $model_Id,
                                                                    'Action' => route('DtuffTile.softDelete', $dispatch->id),
                                                                ])
                                                                @endcomponent

                                                            </td>
                                                        </tr>
                                                        @if ($count > 1)
                                                            @foreach ($dispatch->products->slice(1) as $product)
                                                                <tr>
                                                                    <td class="long-text">
                                                                        {{ $product->mainProduct->name }}
                                                                    </td>
                                                                    <td>{{ $product->mainSize->size }}</td>
                                                                    <td>{{ $product->sft_ratio }}</td>
                                                                    <td>{{ $product->total_tiles }}</td>
                                                                    <td>{{ $product->red_qty == null ? '-' : $product->red_qty }}
                                                                    </td>
                                                                    <td>{{ $product->grey_qty == null ? '-' : $product->grey_qty }}
                                                                    </td>
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
                            </div>
                            {{-- chemical tiles --}}
                            <div class="">
                                <div class="">
                                    <a class="collapsed btn btn-primary d-flex justify-content-between align-items-center"
                                        style="width: -webkit-fill-available;" data-bs-toggle="collapse"
                                        href="#collapseTwo">
                                        <span>Chemical Tiles</span> <i class=" fa-solid fa-angle-down"></i>
                                    </a>
                                </div>
                                <div id="collapseTwo" class="collapse" data-bs-parent="#accordion">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="">
                                                <thead class="">
                                                    <tr>
                                                        <th scope="col" rowspan="2" class="text-blod">B.No.</th>
                                                        <th scope="col" rowspan="2" class="text-blod">Date</th>
                                                        <th scope="col" rowspan="2" class="text-blod"> Contact No 1
                                                        </th>
                                                        <th scope="col" rowspan="2" class="text-blod"> Contact No 2
                                                        </th>
                                                        <th scope="col" rowspan="2" class="text-blod">Driver Name
                                                        </th>
                                                        <th scope="col" rowspan="2" class="text-blod">City/Area
                                                        </th>
                                                        <th scope="col" rowspan="2" class="text-blod">Product Name
                                                        </th>
                                                        <th scope="col" rowspan="2" class="text-blod">Size</th>
                                                        <th scope="col" rowspan="2" class="text-blod">SFT Ratio
                                                        </th>
                                                        <th scope="col" rowspan="2" class="text-blod">Total Tiles
                                                        </th>
                                                        <th scope="col" colspan="5" class="text-blod text-center">
                                                            Color's Quantity</th>
                                                        <th scope="col" rowspan="2" class="text-blod">Tiles in SFT
                                                        </th>
                                                        <th scope="col" rowspan="2" class="text-blod">Price / SFT
                                                        </th>
                                                        <th scope="col" rowspan="2" class="text-blod">Total Price
                                                        </th>
                                                        <th scope="col" rowspan="2" class="text-blod">Vehicle Type
                                                        </th>
                                                        <th scope="col" rowspan="2" class="text-blod">Vehicle No.
                                                        </th>
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
                                                    @foreach ($dispatch_Chemicletiles as $dispatch)
                                                        @php
                                                            $count = $dispatch->products->count();
                                                        @endphp
                                                        {{-- @dump($dispatch->products->slice(1)) --}}
                                                        <tr>
                                                            <td rowspan="{{ $count }}" class="align-middle">
                                                                {{ $dispatch->bilti_no }}
                                                            </td>
                                                            <td rowspan="{{ $count }}" class="align-middle">
                                                                {{ $dispatch->date }}</td>

                                                            <td class="text-center align-middle"
                                                                rowspan="{{ $count }}">
                                                                {{ $dispatch->contactNo1 == null ? '-' : $dispatch->contactNo1 }}
                                                            </td>
                                                            <td class="text-center align-middle"
                                                                rowspan="{{ $count }}">
                                                                {{ $dispatch->contactNo2 == null ? '-' : $dispatch->contactNo2 }}
                                                            </td>
                                                            <td class="text-center align-middle"
                                                                rowspan="{{ $count }}">
                                                                {{ $dispatch->driverName == null ? '-' : $dispatch->driverName }}
                                                            </td>
                                                            <td rowspan="{{ $count }}"
                                                                class="align-middle long-text">
                                                                {{ $dispatch->area }}</td>
                                                            <td class="long-text">
                                                                {{ $dispatch->products?->first()?->mainProduct->name }}
                                                            </td>
                                                            <td>{{ $dispatch->products?->first()?->mainSize->size }}</td>
                                                            <td>{{ $dispatch->products?->first()?->sft_ratio }}</td>
                                                            <td>{{ $dispatch->products?->first()?->total_tiles }}</td>
                                                            <td>{{ $dispatch->products?->first()?->red_qty == null ? '-' : $dispatch->products?->first()?->red_qty }}
                                                            </td>
                                                            <td>{{ $dispatch->products?->first()?->grey_qty == null ? '-' : $dispatch->products?->first()?->grey_qty }}
                                                            </td>
                                                            <td>{{ $dispatch->products?->first()?->black_qty == null ? '-' : $dispatch->products?->first()?->black_qty }}
                                                            </td>
                                                            <td>{{ $dispatch->products?->first()?->yellow_qty == null ? '-' : $dispatch->products?->first()?->yellow_qty }}
                                                            </td>
                                                            <td>{{ $dispatch->products?->first()?->white_qty == null ? '-' : $dispatch->products?->first()?->white_qty }}
                                                            </td>

                                                            <td>{{ $dispatch->products?->first()?->total_tiles_sft }}</td>
                                                            <td>{{ $dispatch->products?->first()?->price_sft }}</td>
                                                            <td>{{ $dispatch->products?->first()?->total_price }}</td>
                                                            <td rowspan="{{ $count }}" class="align-middle">
                                                                {{ $dispatch->vehicle_type }}
                                                            </td>
                                                            <td rowspan="{{ $count }}" class="align-middle">
                                                                {{ $dispatch->vehicle_number }}</td>
                                                            <td rowspan="{{ $count }}" class="align-middle">
                                                                {{-- view --}}
                                                                <a href="" class="btn btn-primary btn-sm">View</a>
                                                                {{-- print Bilti --}}
                                                                <a href="" class="btn btn-info btn-sm">Print
                                                                    Bilti</a>
                                                                <!-- edit -->
                                                                <a class="btn  btn-sm btn-parrot-green text-white"
                                                                    href="{{ route('DchemicalTiles.edit', $dispatch->id) }}"><i
                                                                        class="fa-solid fa-pencil"></i></a>
                                                                <!-- delete -->
                                                                @php
                                                                    $model_id = 'modelDelete' . $dispatch->id;
                                                                @endphp

                                                                @component('components.soft-delete-model', [
                                                                    'modelId' => $model_id,
                                                                    'Action' => route('DchemicalTiles.softDelete', $dispatch->id),
                                                                ])
                                                                @endcomponent


                                                            </td>
                                                        </tr>
                                                        @if ($count > 1)
                                                            @foreach ($dispatch->products->slice(1) as $product)
                                                                <tr>
                                                                    <td class="long-text">
                                                                        {{ $product->mainProduct->name }}</td>
                                                                    <td>{{ $product->mainSize->size }}</td>
                                                                    <td>{{ $product->sft_ratio }}</td>
                                                                    <td>{{ $product->total_tiles }}</td>
                                                                    <td>{{ $product->red_qty == null ? '-' : $product->red_qty }}
                                                                    </td>
                                                                    <td>{{ $product->grey_qty == null ? '-' : $product->grey_qty }}
                                                                    </td>
                                                                    <td>{{ $product->black_qty == null ? '-' : $product->black_qty }}
                                                                    </td>
                                                                    <td>{{ $product->yellow_qty == null ? '-' : $product->yellow_qty }}
                                                                    </td>
                                                                    <td>{{ $product->white_qty == null ? '-' : $product->white_qty }}
                                                                    </td>
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
                            </div>
                        </div>

                    </div>

                    {{-- ----------- Payment history ------------- --}}
                    <div class="tab-pane fade pt-3" id="nav-payment" role="tabpanel" aria-labelledby="nav-payment-tab">
                        <span class="tab-title mx-3">Payment history </span>
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered" id="myTable">
                                <thead class="">
                                    <tr>

                                        <th scope="col" class="text-blod">Payment ID</th>
                                        <th scope="col" class="text-blod">Date</th>
                                        <th scope="col" class="text-blod">Customer Name</th>
                                        <th scope="col" class="text-blod">Company Name</th>
                                        <th scope="col" class="text-blod">Deposit Bank Name</th>
                                        <th scope="col" class="text-blod">Amount Received</th>
                                        <th scope="col" class="text-blod">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($payments as $payment)
                                        <tr>

                                            <td>{{ $payment->payment_id }}</td>
                                            <td>{{ $payment->date }}</td>
                                            <td class="long-text">{{ $payment->customer->customer_name }}</td>
                                            <td class="long-text text-center">{{ $payment->company_name ?? '-' }}</td>
                                            <td>{{ $payment->deposit_bank_name }}</td>
                                            <td>{{ $payment->amount_reveived }}</td>
                                            <td>
                                                <!-- edit -->
                                                <a class="btn  btn-sm btn-parrot-green text-white"
                                                    href="{{ route('payment.edit', $payment->id) }}"><i
                                                        class="fa-solid fa-pencil"></i></a>
                                                <!--delete Modal  -->
                                                @php $modeld = 'modelDelete'. $payment->id; @endphp
                                                @component('components.delete-model', ['modelId' => $modeld, 'Action' => route('payment.destroy', $payment->id)])
                                                @endcomponent

                                            </td>
                                        </tr>
                                    @endforeach




                                </tbody>
                            </table>
                        </div>
                        <div class="row justify-content-center mt-5">
                            {{-- Final Received Payment Records - Customer wise --}}
                            <div class="col-md-6">
                                <div class="card  shadow-2-strong bg-white mt-2 ">
                                    <div class="card-header bg-blue text-center text-white">
                                        Final Received Payment Records - Bank Account Wise
                                    </div>
                                    <div class="table-responsive m-3">
                                        <table class="table table-bordered" id="myTable">
                                            <thead class="">
                                                <tr>
                                                    <th scope="col" class="text-blod">Bank Account</th>
                                                    <th scope="col" class="text-blod">Deposited Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($paymentBank as $payment)
                                                    <tr>
                                                        <td>{{ $payment['deposit_bank_name'] }}</td>
                                                        <td>{{ $payment['amount_reveived'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <thead class="">
                                                <tr>
                                                    <th scope="col" class="text-end text-blod"><b>Grand Total:</b></th>
                                                    <th scope="col" style="font-weight: 300;">{{ $TotalPayment }}
                                                    </th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    {{-- Final Material Dispatch Report --}}
                    <div class="tab-pane fade pt-3" id="nav-materialDispatch" role="tabpanel"
                        aria-labelledby="nav-materialDispatch-tab">
                        <span class="tab-title mx-3">Final Material Dispatch & Payment Report</span>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="table-responsive mt-2">
                                    <table class="table table-bordered" id="myTable">
                                        <thead class="">
                                            <tr>

                                                <th scope="col">Product Category</th>
                                                <th scope="col">Product Name</th>
                                                <th scope="col">Size or Thickness</th>
                                                <th scope="col">Total material in SFT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($productTotals as $dispatch)
                                                <tr>
                                                    <td>{{ $dispatch['category'] }}</td>
                                                    <td>{{ $dispatch['product_name'] }}</td>
                                                    <td>{{ $dispatch['size'] }}</td>
                                                    <td>{{ $dispatch['total'] }}</td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                        <thead class="">
                                            <tr>
                                                <th scope="col" colspan="3" class="text-end">Grand Total:</th>
                                                <th scope="col">{{ $GrandTotalProduct }}</th>
                                            </tr>
                                        </thead>
                                    </table>


                                </div>

                            </div>
                            <div class="col-md-5">
                                <div class="card stockCard shadow-2-strong bg-white mt-2 p-0">
                                    <div class="card-header bg-blue text-center text-white">
                                        Payment Report
                                    </div>
                                    <div class="">
                                        <table class="table  mb-0">
                                            <tr class="">
                                                <th class="text-center bg-light">Grand Total</th>
                                                <td class="text-center bg-light">{{ $GrandTotalPrice }}</td>
                                            </tr>
                                            <tr class="">
                                                <td class="text-center">Recover or Advance</td>
                                                <td class="text-center">{{ $TotalPayment }}</td>
                                            </tr>
                                            <tr class="">
                                                <td class="text-center">Remaining Balance</td>
                                                <td class="text-center">{{ $GrandTotalPrice - $TotalPayment }}</td>
                                            </tr>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    {{-- Bilti --}}
                    <div class="tab-pane fade pt-3" id="nav-bilti" role="tabpanel" aria-labelledby="nav-bilti-tab">
                        <div class="my-3"><span class="tab-title my-3">Bilti</span>
                            <a href="{{ route('chemicalTiles.create') }}" class="btn btn-primary "
                                style="float: right;">Create Bilti For Chemical Concrete
                                Pavers</a>
                            <a href="{{ route('tuffTile.create') }}" class="btn btn-primary me-2"
                                style="float: right;">Create Bilti For Tuff Tiles &
                                Blocks</a>
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered" id="myTable">
                                <thead>
                                    <tr>
                                        <th scope="col">Bilti No.</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Grand total in SFT</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productTotals as $dispatch)
                                        <tr class="">
                                            <td>{{ $dispatch['biltiNo'] }}</td>
                                            <td>{{ $dispatch['date'] }}</td>
                                            <td>{{ $dispatch['total'] }}</td>
                                            <td>
                                                {{-- view  --}}
                                                <button class="btn btn-primary btn-sm">View</button>
                                                {{-- print  --}}
                                                <button class="btn btn-info btn-sm"><i
                                                        class="fa-solid fa-print"></i></button>
                                                {{-- pdf --}}
                                                <button class="btn btn-secondary btn-sm"><i
                                                        class="fa-solid fa-file-pdf"></i></button>
                                                <!-- edit -->
                                                <a class="btn  btn-sm btn-parrot-green text-white" href=""><i
                                                        class="fa-solid fa-pencil"></i></a>
                                                <!-- delete -->
                                                <button class="btn  btn-sm btn-danger text-white" data-bs-toggle="modal"
                                                    data-bs-target="#modaBilti"><i class="fa-solid fa-trash"></i></button>
                                                <!-- Modal Body -->
                                                <div class="modal fade" id="modaBilti" tabindex="-1"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                                    aria-labelledby="modalTitleId" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <div class="text-center my-5">
                                                                    <span class="cancel-icon"><i
                                                                            class="fa-solid fa-xmark fa-2xl"></i></span>
                                                                </div>
                                                                <div class="text-center my-2">
                                                                    <span class="model_title">
                                                                        Are You Sure?
                                                                    </span>
                                                                    <p class="model_description">
                                                                        Do you really want to delete these
                                                                        record?<br>
                                                                        This process cannot be undone.
                                                                    </p>
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="button"
                                                                        class="btn btn-danger">Delete</button>

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- invoice --}}
                    <div class="tab-pane fade pt-3" id="nav-invoice" role="tabpanel" aria-labelledby="nav-invoice-tab">
                        <div class="my-3"><span class="tab-title my-3">Invoice</span>
                            <a href="{{ route('invoice.create') }}" class="btn btn-primary"
                                style="float: right;">Create Invoice</a>
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Invoice No.</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Total Amount</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $invoice)
                                        <tr class="">
                                            <td>{{ $invoice->invoice_no }}</td>
                                            <td>{{ $invoice->date }}</td>
                                            <td>{{ $invoice->total_price }}</td>
                                            <td>
                                                {{-- view  --}}
                                                <button class="btn btn-primary btn-sm">View</button>
                                                {{-- print  --}}
                                                <button class="btn btn-info btn-sm"><i
                                                        class="fa-solid fa-print"></i></button>
                                                {{-- pdf --}}
                                                <button class="btn btn-secondary btn-sm"><i
                                                        class="fa-solid fa-file-pdf"></i></button>
                                                <!-- edit -->
                                                <a class="btn  btn-sm btn-parrot-green text-white" href=""><i
                                                        class="fa-solid fa-pencil"></i></a>
                                                <!-- delete -->
                                                <button class="btn  btn-sm btn-danger text-white" data-bs-toggle="modal"
                                                    data-bs-target="#modaBilti"><i class="fa-solid fa-trash"></i></button>
                                                <!-- Modal Body -->
                                                <div class="modal fade" id="modaBilti" tabindex="-1"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                                    aria-labelledby="modalTitleId" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <div class="text-center my-5">
                                                                    <span class="cancel-icon"><i
                                                                            class="fa-solid fa-xmark fa-2xl"></i></span>
                                                                </div>
                                                                <div class="text-center my-2">
                                                                    <span class="model_title">
                                                                        Are You Sure?
                                                                    </span>
                                                                    <p class="model_description">
                                                                        Do you really want to delete these
                                                                        record?<br>
                                                                        This process cannot be undone.
                                                                    </p>
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="button"
                                                                        class="btn btn-danger">Delete</button>

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    </div>
@endsection
@section('script')
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
@endsection
