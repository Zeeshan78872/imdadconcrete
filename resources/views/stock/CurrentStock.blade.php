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

            font-family: Nunito;
            font-size: 18px;
            font-weight: 400;
            line-height: 75px;
            letter-spacing: 0em;

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
        }
    </style>
@endsection
@section('content')
    <div class="container mb-5">
        <div class="inner-container">
            <span>Tuff Tiles & Blocks - Current Stock</span>

        </div>
        <div class="card stockCard shadow-2-strong bg-white ">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="">
                            <tr>
                                <th scope="col">Product Name</th>
                                <th scope="col">Size</th>
                                <th scope="col">Quantity in SFT - Based on Size</th>
                                <th scope="col">Total Quantity in SFT </th>
                            </tr>
                        </thead class="table table-dark">
                        <tbody>
                            {{-- @foreach ($products as $product)
                                @php
                                    $count = $product->sizes->count();
                                    $array = $product->sizes->toArray();
                                @endphp --}}
                            <tr>
                                <td rowspan="2" class="align-middle">Cobol</td>
                                <td>600</td>
                                <td>34</td>
                                <td rowspan="2" class="align-middle">43 </td>
                            </tr>
                            {{-- @if ($count > 1)
                                    @foreach ($product->sizes->slice(1) as $size) --}}
                            <tr>
                                <td>12</td>
                                <td>23</td>
                            </tr>
                            {{-- @endforeach
                                @endif
                            @endforeach --}}

                        </tbody>
                        <thead>
                            <th colspan="3" class="text-end">Total Stock Manufactured in SFT:</th>
                            <th> 504530510</th>
                        </thead>
                    </table>
                </div>

            </div>
        </div>


    </div>

    </div>
    </div>
@endsection
