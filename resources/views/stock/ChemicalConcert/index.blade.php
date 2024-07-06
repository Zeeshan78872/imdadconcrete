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
            font-weight: 600;
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
            font-weight: 500;
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
        <div class="inner-container">
            <span>Chemical Concrete Pavers Stock Listings</span>
            <a href="{{ route('tuffTile.create') }}" class="btn btn-primary float-right">Add Stock</a>
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
                <form method="POST" action="{{ route('chemicalTiles.filter') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="from_date" class="form-label">From Date</label>
                                <input type="date" class="form-control" value="{{ $filter['from_date'] ?? '' }}"
                                    name="from_date" id="from_date" placeholder="">
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
                                <label for="product_id" class="form-label">Product Name <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <select id="itemSelect" class="form-select form-select-md" name="product_id"
                                    id="product_id">
                                    <option value="" selected>Choose Product Name</option>
                                    @foreach ($products as $product)
                                        <option {{ ($filter['product_id'] ?? '') == $product->id ? 'selected' : '' }}
                                            value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="size" class="form-label">Size <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <select id="showSize" class="form-select form-select-md" name="size" id="size">
                                    <option value="">Choose Size</option>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="text-end mt-4">
                                <a href="{{ route('chemicalTiles.index') }}"
                                    class="btn btn-light text-primary btn-rest">Reset</a>
                                <button type="submit" class="btn btn-primary">Apply Filter</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-------------------- View Tiles  ---------------------->

        <div class="card stockCard shadow-2-strong bg-white mt-5 py-2 px-3">
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-bordered" id="" style="width:100%">
                        <thead class="">
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Cement Pack </th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Size</th>
                                <th scope="col">Total Farmas</th>
                                <th scope="col">Quantity in SFT </th>
                                <th scope="col">Total Stock in SFT</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead class="table table-dark">
                        <tbody>
                            @foreach ($stocks as $stock)
                                @php
                                    $count = $stock->products->count();
                                @endphp
                                <tr>
                                    <td rowspan="{{ $count }}" class="align-middle rowspan-cell">{{ $stock->date }}
                                    </td>
                                    <td rowspan="{{ $count }}" class="align-middle rowspan-cell">
                                        {{ $stock->cement_packs }}
                                    </td>
                                    <td>{{ $stock->products?->first()?->mainProduct->name }}</td>
                                    <td>{{ $stock->products?->first()?->mainSize->size }}</td>
                                    <td>{{ $stock->products?->first()?->total_farma }}</td>
                                    <td>{{ $stock->products?->first()?->quentity_sft }}</td>
                                    <td rowspan="{{ $count }}" class="align-middle rowspan-cell">
                                        {{ $stock->total_stock }}
                                    </td>
                                    <td rowspan="{{ $count }}" class="align-middle rowspan-cell">
                                        <!-- edit -->
                                        <a class="btn  btn-sm btn-parrot-green text-white" href="}"><i
                                                class="fa-solid fa-pencil"></i></a>
                                        <!-- delete -->
                                        @php
                                            $modelId = 'modelDelete' . $stock->id;
                                        @endphp
                                        @component('components.delete-model', ['modelId' => $modelId, 'Action' => route('tuffTile.destroy', $stock->id)])
                                        @endcomponent
                                    </td>
                                </tr>
                                @if ($count > 1)
                                    @foreach ($stock->products->slice(1) as $product)
                                        <tr>
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
                    <div class="col-12 col-md-4 total-text"><span>Total Cement Packs: {{ $TotalCement }}</span></div>
                    <div class="col-12 col-md-4 total-text tf"><span>Total Farmas: {{ $TotalFarma }}</span></div>
                    <div class="col-12 col-md-4 total-text sm"><span>Total Stock Manufactured in SFT:
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
                                <th scope="col">Product Name</th>
                                <th scope="col">Size</th>
                                <th scope="col">Quantity in SFT - Based on Size Variation</th>
                                <th scope="col">Total Overall Quantity in SFT </th>
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
                                <th scope="col" class="text-end" colspan="3">Total Stock Manufactured in SFT:</th>
                                <th scope="col">{{ $TotalOverAll }}</th>
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
