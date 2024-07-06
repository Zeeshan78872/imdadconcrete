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
        <div class="inner-container">
            <span>Cement Pack Usage Summary</span>
            {{-- <a href="{{ route('invoice.create') }}" class="btn btn-primary float-right">Create Invoice</a> --}}
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
                <form method="POST" action="">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="from_date" class="form-label">From Date</label>
                                <input type="date" class="form-control" value=""
                                    name="from_date" id="from_date" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="to_date" class="form-label">To Date</label>
                                <input type="date" class="form-control" value=""
                                    name="to_date" id="to_date" placeholder="">
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="text-end mt-4">
                                <a href="" class="btn btn-light text-primary btn-rest">Reset</a>
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
                <h4 class="page-title">Cement Packs Usage</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="">
                        <thead class="">
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Plant No. 1 (Fiyaz)</th>
                                <th scope="col">Plant No. 2 (Saeed)</th>
                                <th scope="col">Plant No. 3 (Alahdita)</th>
                                <th scope="col">Plant No. 4 (Saeed Bau)</th>
                                <th scope="col">Plant No. 5 (Zafar)</th>
                                <th scope="col">Plant No. 6 (Sohail)</th>
                                <th scope="col">Total Plants Sum</th>
                                <th scope="col">Farma</th>
                                <th scope="col">Grand Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>13/07/23</td>
                                <td>202</td>
                                <td>202</td>
                                <td>202</td>
                                <td>202</td>
                                <td>202</td>
                                <td>202</td>
                                <td>202</td>
                                <td>202</td>
                                <td>202</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>
    </div>
@endsection
@section('script')
   
@endsection
