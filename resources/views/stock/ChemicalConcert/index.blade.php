@extends('layouts.app')

@section('style')
    <style>
        .stockCard {
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
            /* Set your desired color here */
        }

        .total-text {
            font-family: Nunito;
            font-weight: 300;
            line-height: 30px;
            letter-spacing: 0em;
        }

        .col-md-4.total-text.tf {
            text-align: center;
        }

        .col-md-4.total-text.sm {
            text-align: end;
        }

        /* Media query for mobile screens (less than 768px) */
        @media (max-width: 767px) {

            .col-12.total-text.tf,
            .col-12.total-text.sm {
                text-align: unset;
            }
        }
    </style>
@endsection
@section('content')
    <div class="container mb-5">


        <div class="row">
            <div class="col-md-6   top-left-view">
                <span>Chemical Concrete Pavers Stock Listings</span>
            </div>
            <div class="col-md-6  top-right-view d-flex align-items-center justify-content-end">
                <a href="{{ route('chemicalTiles.create') }}" class="btn btn-primary float-right">Add Stock</a>
            </div>
        </div>

        <!-------------------- Apply Filter ---------------------->
        {{-- @dd($filter['product_type']); --}}
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
                <form method="POST" action="{{ route('chemicalTiles.filter') }}">
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
                                <input type="date" class="form-control" name="to_date"
                                    value="{{ $filter['to_date'] ?? '' }}" id="to_date" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="product_type" class="form-label filter-title">Product Type</label>
                                <select class="form-select form-select-md" name="product_type" id="product_type"
                                    onchange="getProductName()">
                                    <option value="">Choose Product Type</option>
                                    @foreach ($productTypes as $type)
                                        <option {{ ($filter['product_type'] ?? '') == $type ? 'selected' : '' }}
                                            value="{{ $type }}">
                                            {{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="product_id" class="form-label filter-title">Product Name</label>
                                <select id="itemSelect" class="form-select form-select-md" name="product_id">
                                    <option value="">Choose Product Name</option>
                                    @if (isset($filter['product_type']) && $filter['product_type'] != null)
                                        @foreach ($products as $product)
                                            @if (($filter['product_type'] ?? '') == $product->product_type)
                                                <option
                                                    {{ ($filter['product_id'] ?? '') == $product->id ? 'selected' : '' }}
                                                    value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="size" class="form-label filter-title">Size</label>
                                <select id="showSize" class="form-select form-select-md" name="size" id="size">
                                    <option value="">Choose Size</option>
                                    @if (isset($filter['product_id']) && $filter['product_id'] != null)
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
                                <a href="{{ route('chemicalTiles.index') }}"
                                    class="btn btn-light text-primary btn-rest me-3">Reset</a>
                                <button type="submit" class="btn btn-primary">Apply Filter</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-------------------- View Tiles  ---------------------->

        <div class="card stockCard shadow-2-strong bg-white mt-5 py-2 px-3">
            <div class="card-header bg-white py-3">
                <h4 class="page-title">Stock Details</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-bordered" id="" style="width:100%">
                        <thead class="">
                            <tr>
                                <th scope="col" class="text-blod">Date</th>
                                <th scope="col" class="text-blod">Cement Pack </th>
                                <th scope="col" class="text-blod ">Product Type</th>
                                <th scope="col" class="text-blod ">Product Name</th>
                                <th scope="col" class="text-blod">Size</th>
                                <th scope="col" class="text-blod">Total Farmas</th>
                                <th scope="col" class="text-blod">Quantity in SFT </th>
                                <th scope="col" class="text-blod">Total Stock in SFT</th>
                                <th scope="col" class="text-blod">Action</th>
                            </tr>
                        </thead class="table table-dark">
                        <tbody>
                            @foreach ($stocks as $stock)
                                @php
                                    $count = $stock->products->count();
                                @endphp
                                <tr>
                                    <td rowspan="{{ $count }}" class="align-middle rowspan-cell">
                                        {{ $stock->date }}
                                    </td>
                                    <td rowspan="{{ $count }}" class="align-middle rowspan-cell">
                                        {{ $stock->cement_packs }}
                                    </td>
                                    <td class="long-text">{{ $stock->products?->first()?->product_type }}</td>
                                    <td class="long-text">{{ $stock->products?->first()?->mainProduct->name }}</td>
                                    <td>{{ $stock->products?->first()?->mainSize->size }}</td>
                                    <td>{{ $stock->products?->first()?->total_farma }}</td>
                                    <td>{{ $stock->products?->first()?->quentity_sft }}</td>
                                    <td rowspan="{{ $count }}" class="align-middle rowspan-cell">
                                        {{ $stock->total_stock }}
                                    </td>
                                    <td rowspan="{{ $count }}" class="align-middle rowspan-cell">
                                        <!-- edit -->
                                        <a class="btn  btn-sm btn-parrot-green text-white"
                                            href="{{ route('chemicalTiles.edit', $stock->id) }}"><i
                                                class="fa-solid fa-pencil"></i></a>
                                        <!-- delete -->
                                        @php
                                            $modelId = 'modelDelete' . $stock->id;
                                        @endphp
                                        @component('components.soft-delete-model', [
                                            'modelId' => $modelId,
                                            'Action' => route('chemicalTiles.softDelete', $stock->id),
                                        ])
                                        @endcomponent
                                    </td>
                                </tr>
                                @if ($count > 1)
                                    @foreach ($stock->products->slice(1) as $product)
                                        <tr>
                                            <td>{{ $product?->product_type }}</td>
                                            <td>{{ $product->mainProduct->name }}</td>
                                            <td>{{ $product->mainSize->size }}</td>
                                            <td>{{ $product->total_farma }}</td>
                                            <td>{{ $product->quentity_sft }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>


        </div>

        <!-- Grand Totals  -->
        <div class="card stockCard shadow-2-strong bg-white mt-5 py-2 px-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-4 total-text"><span class="text-blod">Total Cement Packs:</span><span>
                            {{ $TotalCement }}</span></div>
                    <div class="col-12 col-md-4 total-text tf"><span class="text-blod">Total Farmas:</span><span>
                            {{ $TotalFarma }}</span></div>
                    <div class="col-12 col-md-4 total-text sm"> <span class="text-blod">Total Stock Manufactured in
                            SFT:</span><span>
                            {{ $TotalStock }}</span></div>
                </div>

            </div>
        </div>
        <!-- Summery -->

        <div class="card stockCard shadow-2-strong bg-white mt-5 ">
            <div class="card-header bg-white py-3">
                <h4 class="page-title">Total Stock Summary</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-bordered" id="">
                        <thead>
                            <tr>
                                <th scope="col" class="text-blod">Product Name</th>
                                <th scope="col" class="text-blod">Size</th>
                                <th scope="col" class="text-blod">Quantity in SFT - Based on Size Variation</th>
                                <th scope="col" class="text-blod">Total Overall Quantity in SFT </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $itemsExceptFirst = [];
                                $TotalOverAll = 0;
                            @endphp
                            @foreach ($ProductSummery as $product)
                                @php
                                    $count = count($product['products']);
                                    $TotalOverAll += $product['products'][0]['quantity'];
                                @endphp
                                <tr class="">
                                    <td rowspan="{{ $count }}" class="align-middle">
                                        {{ $product['product_name'] }}
                                    </td>
                                    <td>{{ $product['products'][0]['size'] }}</td>
                                    <td>{{ $product['products'][0]['quantity'] }}</td>
                                    <td rowspan="{{ $count }}" class="align-middle">{{ $product['overall'] }}
                                    </td>
                                </tr>
                                @if ($count > 1)
                                    @php
                                        $itemsExceptFirst = array_merge($itemsExceptFirst, array_slice($product['products'], 1));
                                        
                                    @endphp
                                    @foreach ($itemsExceptFirst as $value)
                                        @php
                                            $TotalOverAll += $value['quantity'];
                                        @endphp
                                        <tr>
                                            <td>{{ $value['size'] }}</td>
                                            <td>{{ $value['quantity'] }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach


                        </tbody>
                        <thead>
                            <tr>
                                <th scope="col" class="text-end text-blod" colspan="3">Total Stock Manufactured in
                                    SFT:</th>
                                <th scope="col" style="    font-weight: 500;">{{ $TotalOverAll }}</th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>

    </div>
@endsection
@section('script')
    <script>
        // fetch product name
        function getProductName() {
            const typeToFetch = $('#product_type').val();
            const url = window.location.origin + '/fetchproductName/' + typeToFetch;
            $('#itemSelect').empty();
            $('#itemSelect').append('<option value="">Choose Product Name</option>')
            $('#showSize').empty();
            $('#showSize').append('<option value="">Choose Size</option>')
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $.each(response, function(index, value) {
                        $('#itemSelect').append('<option value="' + value['id'] +
                            '">' + value['name'] + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
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
