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
                <span>Cement Stock Details</span>
            </div>
            <div class="col-md-6  top-right-view d-flex align-items-center justify-content-end">
                <a href="{{ route('cement.create') }}" class="btn btn-primary">Add Cement Stock</a>
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
                <form method="POST" action="{{ route('cement.filter') }}">
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
                                <label for="seller_name" class="form-label filter-title">Seller Name</label>
                                <select class="form-select form-select-md" name="seller_name" id="seller_name">
                                    <option value="">Choose Seller Name</option>
                                    @foreach ($SellerNames as $SellerName)
                                        <option {{ ($filter['seller_name'] ?? '') == $SellerName ? 'selected' : '' }}
                                            value="{{ $SellerName }}">{{ $SellerName }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-end mt-4">
                                <a href="{{ route('cement.index') }}"
                                    class="btn btn-light text-primary btn-rest mt-1 mx-3">Reset</a>
                                <button type="submit" class="btn btn-primary mt-1">Apply Filter</button>
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
                    <table class="table table-bordered" id="">
                        <thead class="">
                            <tr>
                                <th scope="col" class="text-blod">Date</th>
                                <th scope="col" class="text-blod">Seller Name</th>
                                <th scope="col" class="text-blod">Cement Company</th>
                                <th scope="col" class="text-blod">Quantity of Cement Packs</th>
                                <th scope="col" class="text-blod">Price For Single Pack</th>
                                <th scope="col" class="text-blod">Total Price</th>
                                <th scope="col" class="text-blod">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cements as $cement)
                                <tr>
                                    <td>{{ $cement->date }}</td>
                                    <td>{{ $cement->seller_name }}</td>
                                    <td>{{ $cement->cement_company }}</td>
                                    <td>{{ $cement->quantity }}</td>
                                    <td>{{ $cement->price_pack }}</td>
                                    <td>{{ $cement->total_price }}</td>
                                    <td>

                                        <!-- edit -->
                                        <a class="btn  btn-sm btn-parrot-green text-white"
                                            href="{{ route('cement.edit', $cement->id) }}"><i
                                                class="fa-solid fa-pencil"></i></a>
                                        <!-- delete -->
                                        <!-- Modal Body -->
                                        @php
                                            $model_id = 'deletemodel' . $cement->id;
                                        @endphp
                                        @component('components.delete-model', ['Action' => route('cement.destroy', $cement->id), 'modelId' => $model_id])
                                        @endcomponent

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <thead class="">
                            <tr>
                                <th colspan="3" class="text-end text-blod"><b>Total Cement Packs:</b></th>
                                <th scope="col" style="font-weight: 300;">{{ $totalQuantity }}</th>
                                <th scope="col" class="text-end text-blod"><b>Total Price:</b></th>
                                <th colspan="2" style="font-weight: 300;">{{ $totalPrice }}</th>
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
