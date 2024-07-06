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
            <span>Gravel and Sand Stock Listing</span>
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
                <form method="POST" action="{{ route('gravelSand.filter') }}">
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
                                <input type="date" class="form-control" value="{{ $filter['to_date'] ?? '' }}"
                                    name="to_date" id="to_date" placeholder="">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="material_type" class="form-label">Material Type</label>
                                <select class="form-select form-select-md" name="material_type" id="material_type">
                                    <option value="">Choose Material Type </option>
                                    <option value="Sand">Sand</option>
                                    <option value="Gravel">Gravel</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="seller_name" class="form-label">Seller Name</label>
                                <select class="form-select form-select-md" name="seller_name" id="seller_name">
                                    <option value="">Choose Seller Name</option>
                                    <option value="rasheed">rasheed</option>
                                    <option value="iqbal">iqbal</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="text-end mt-4">
                                <a href="{{ route('gravelSand.index') }}"
                                    class="btn btn-light text-primary btn-rest">Reset</a>
                                <button type="submit" class="btn btn-primary">Apply Filter</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <!-------------------- View gravel sand  ---------------------->

        <div class="card stockCard shadow-2-strong bg-white mt-5 py-2 px-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="">
                        <thead class="">
                            <tr>
                                <th scope="col">S.NO</th>
                                <th scope="col">Date</th>
                                <th scope="col">Vehicle No.</th>
                                <th scope="col">Bilti No.</th>
                                <th scope="col">Material Type</th>
                                <th scope="col">Lenght</th>
                                <th scope="col">Width</th>
                                <th scope="col">Height</th>
                                <th scope="col">Seller Name</th>
                                <th scope="col">Total Measurements in SFT</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sr =1;
                            @endphp
                            @foreach ($gravleSands as $gravleSand)
                                <tr>
                                    <td>{{$sr}}</td>
                                    <td>{{ $gravleSand->date }}</td>
                                    <td>{{ $gravleSand->vehicle_no }}</td>
                                    <td>{{ $gravleSand->bilti_no }}</td>
                                    <td>{{ $gravleSand->material_type }}</td>
                                    <td>{{ $gravleSand->length }}</td>
                                    <td>{{ $gravleSand->width }}</td>
                                    <td>{{ $gravleSand->height }}</td>
                                    <td>{{ $gravleSand->seller_name }}</td>
                                    <td>{{ $gravleSand->total_measeurement }}</td>
                                    <td>
                                        <!-- edit -->
                                        <a class="btn  btn-sm btn-parrot-green text-white"
                                            href="{{ route('gravelSand.edit', $gravleSand->id) }}"><i class="fa-solid fa-pencil"></i></a>
                                        <!-- delete -->
                                        <!-- Modal Body -->
                                        @php
                                            $model_id = 'deletemodel' . $gravleSand->id;
                                        @endphp
                                        @component('components.delete-model', ['Action' => route('gravelSand.destroy', $gravleSand->id), 'modelId' => $model_id])
                                        @endcomponent
                                    </td>
                                </tr>
                                @php
                                    $sr++;
                                @endphp
                            @endforeach
                        </tbody>

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
