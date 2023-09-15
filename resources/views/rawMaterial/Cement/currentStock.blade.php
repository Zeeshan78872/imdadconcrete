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
    </style>
@endsection
@section('content')
    <div class="container mb-5">
        <div class="row">
            <div class="col-md-6   top-left-view">
                <span>Cement Pack Usage Summary</span>
            </div>
        </div>
        <!-------------------- Apply Filter ---------------------->

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
                <form method="POST" action="">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="from_date" class="form-label">From Date</label>
                                <input type="date" class="form-control" value="" name="from_date" id="from_date"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="to_date" class="form-label">To Date</label>
                                <input type="date" class="form-control" value="" name="to_date" id="to_date"
                                    placeholder="">
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="text-end mt-4">
                                <a href="" class="btn btn-light text-primary btn-rest">Reset</a>
                                <button type="submit" class="btn btn-primary mx-3">Apply Filter</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <!-------------------- View Tiles  ---------------------->

        <div class="card stockCard shadow-2-strong bg-white mt-5 py-2 px-3">
            <div class="card-header bg-white py-3">
                <h4 class="page-title">Cement Packs Usage</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="">
                        <thead class="">
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Plant No. 1 (Fiyaz) </th>
                                <th scope="col">Plant No. 2 (Saeed) </th>
                                <th scope="col">Plant No. 3 (Aladita)</th>
                                <th scope="col">Plant No. 4 (Saeed Bau)</th>
                                <th scope="col">Plant No. 5 (Zafar)</th>
                                <th scope="col">Plant No. 6 (Sohail)</th>
                                <th scope="col">Total Plants Sum</th>
                                <th scope="col">Farma</th>
                                <th scope="col">Grand Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $plantAveragy = [
                                    'Plant No. 1 (Fiyaz)' => 0,
                                    'Plant No. 2 (Saeed)' => 0,
                                    'Plant No. 3 (Aladita)' => 0,
                                    'Plant No. 4 (Saeed Bau)' => 0,
                                    'Plant No. 5 (Zafar)' => 0,
                                    'Plant No. 6 (Sohail)' => 0,
                                ];
                            @endphp
                            @foreach ($productTotals as $products)
                                <tr>
                                    <td>{{ $products['date'] }}</td>
                                    <td>{{ $products['plant_1'] }}</td>
                                    <td>{{ $products['plant_2'] }}</td>
                                    <td>{{ $products['plant_3'] }}</td>
                                    <td>{{ $products['plant_4'] }}</td>
                                    <td>{{ $products['plant_5'] }}</td>
                                    <td>{{ $products['plant_6'] }}</td>
                                    <td>{{ $products['plant_sum'] }}</td>
                                    <td>{{ $products['farma'] }}</td>
                                    <td>{{ $products['grand_total'] }}</td>
                                </tr>
                                @php
                                    $plantAveragy['Plant No. 1 (Fiyaz)'] += $products['plant_1'];
                                    $plantAveragy['Plant No. 2 (Saeed)'] += $products['plant_2'];
                                    $plantAveragy['Plant No. 3 (Aladita)'] += $products['plant_3'];
                                    $plantAveragy['Plant No. 4 (Saeed Bau)'] += $products['plant_4'];
                                    $plantAveragy['Plant No. 5 (Zafar)'] += $products['plant_5'];
                                    $plantAveragy['Plant No. 6 (Sohail)'] += $products['plant_6'];
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


        </div>

        <div class="row justify-content-center mt-5">
            {{-- Cement Packs Usage Averages For Plants --}}
            <div class="col-md-6">
                <div class="card  shadow-2-strong bg-white mt-2 ">
                    <div class="card-header bg-blue text-center text-white">
                        Cement Packs Usage Averages For Plants
                    </div>
                    <div class="table-responsive m-3">
                        <table class="table table-bordered">
                            <thead class="">
                                <tr>
                                    <th scope="col" class="text-blod">Plant Name</th>
                                    <th scope="col" class="text-blod">Cement Packs Used</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $grandAverage = 0;
                                @endphp
                                @foreach ($plantAveragy as $key => $plantAvg)
                                    @php
                                        $plantAvg = round($plantAvg / 6);
                                        $grandAverage += $plantAvg;
                                    @endphp
                                    <tr>
                                        <td>{{ $key }}</td>
                                        <td>{{ $plantAvg }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <thead class="">
                                <tr>
                                    <th scope="col" class="text-end text-blod"><b>Grand Total:</b></th>
                                    <th scope="col" style="font-weight: 300;">{{ $grandAverage }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            {{-- Cement Packs Usage Average For Farmas --}}
            <div class="col-md-6">
                <div class="card  shadow-2-strong bg-white mt-2 ">
                    <div class="card-header bg-blue text-center text-white">
                        Cement Packs Usage Average For Farmas
                    </div>
                    <div class="table-responsive m-3">
                        <table class="table table-bordered">
                            <thead class="">
                                <tr>
                                    <th scope="col" class="text-blod">Plant Name</th>
                                    <th scope="col" class="text-blod">Cement Packs Used</th>
                                </tr>
                            </thead>
                            <tbody>

                                {{-- @foreach ($paymentBank as $payment) --}}
                                <tr>
                                    <td>Farma</td>
                                    <td>4545</td>
                                </tr>
                                {{-- @endforeach --}}
                            </tbody>
                            <thead class="">
                                <tr>
                                    <th scope="col" class="text-end text-blod"><b>Grand Total:</b></th>
                                    <th scope="col" style="font-weight: 300;">45</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('script')
@endsection
