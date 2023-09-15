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
                <span>{{ $pageName }} - Current Stock</span>
            </div>

        </div>
        @if ($category == 'Tuff Tiles')
            <div class="card stockCard shadow-2-strong bg-white mt-2 ">
                <div class="card-body p-0">
                    @component('components.stock-current', [
                        'selectCurrentStock' => selectCurrentStock($category),
                    ])
                    @endcomponent
                </div>
            </div>
        @else
            @php
                $overallGrandTotal = 0;
            @endphp
            @foreach (getProductType() as $product_type)
                @php
                    $array = selectCurrentStock($category, $product_type);
                    $overallGrandTotal += $array['overallSum'];
                @endphp
                @if (!empty($array['currentstocks']))
                    <div class="card stockCard shadow-2-strong bg-white mt-4">
                        <div class="card-header bg-white py-2">
                            <h4 class="page-title">{{ $product_type }}</h4>
                        </div>
                        <div class="card-body p-0">
                            @component('components.stock-current', [
                                'selectCurrentStock' => selectCurrentStock($category, $product_type),
                            ])
                            @endcomponent
                        </div>
                    </div>
                @endif
            @endforeach
            <div class="card stockCard shadow-2-strong bg-white mt-5 py-2 px-3">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-4 total-text"><span class="text-blod">Grand Total Availabel Stock in
                                SFT:</span><span>
                                &nbsp;{{ $overallGrandTotal }}</span></div>

                    </div>

                </div>
            </div>
        @endif

    </div>

    </div>
    </div>
@endsection
