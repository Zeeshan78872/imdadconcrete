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
            border: none !important;
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
        @component('components.success-model', [
            'title' => 'Customer Added Successfully ',
            'desc' => 'A new customer has been added to the list',
            'closeText' => 'Close',
        ])
            <a href="{{ route('customer.index') }}" class="btn btn-primary">View All Customers</a>
        @endcomponent
        <div class="inner-container">
            <span>Customer Listing</span>
            <a href="{{ route('customer.create') }}" class="btn btn-primary float-right">Add Customer</a>
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
                <form method="POST" action="{{ route('customer.filter') }}">
                    @csrf
                    <div class="row">

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="customer_name" class="form-label">Customer Name</label>
                                <select class="form-select form-select-md" name="customer_name" id="customer_name">
                                    <option value="">Choose Customer Name</option>
                                    @foreach ($customer_names as $name)
                                        @php
                                            $selected = ($filter['customer_name'] ?? '') == $name->customer_name ? 'selected' : '';
                                        @endphp
                                        <option {{ $selected }} value="{{ $name->customer_name }}">
                                            {{ $name->customer_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="company_name" class="form-label">Company Name</label>
                                <select class="form-select form-select-md" name="company_name" id="company_name">
                                    <option value="">Choose Plant Name</option>
                                    @foreach ($company_names as $company_name)
                                        @php
                                            $selected = ($filter['company_name'] ?? '') == $company_name->company_name ? 'selected' : '';
                                        @endphp
                                        <option {{ $selected }} value="{{ $company_name->company_name }}">
                                            {{ $company_name->company_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="city" class="form-label">City</label>
                                <select class="form-select form-select-md" name="city" id="city">
                                    <option value="">Choose City</option>
                                    @foreach ($city_names as $city_name)
                                        @php
                                            $selected = ($filter['city'] ?? '') == $city_name->city_area ? 'selected' : '';
                                        @endphp
                                        <option {{ $selected }} value="{{ $city_name->city_area }}">
                                            {{ $city_name->city_area }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-end mt-4 pt-1">
                                <button type="button" class="btn btn-light text-primary btn-rest">Reset</button>
                                <button type="submit" class="btn btn-primary">Apply Filter</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="card stockCard shadow-2-strong bg-white mt-5 py-2 px-3">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <h4 class="col page-title">Customer Listing</h4>
                    <h4 class="col page-title text-end">Total Customer: {{ $customers->count() }}</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="myTable">
                        <thead class="">
                            <tr>
                                <th scope="col">C.ID</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Company Name</th>
                                <th scope="col">City or Area</th>
                                <th scope="col">Phone No. 1</th>
                                <th scope="col">Phone No. 2</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead class="table table-dark">
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $customer->customer_id }}</td>
                                    <td>{{ $customer->customer_name }}</td>
                                    <td>{{ $customer->company_name }}</td>
                                    <td>{{ $customer->city_area }}</td>
                                    <td>{{ $customer->phone_number_1 }}</td>
                                    <td>{{ $customer->phone_number_2 }}</td>
                                    <td>
                                        <!-- view -->
                                        <a class="btn  btn-sm btn-primary text-white"
                                            href="{{ route('customer.show', $customer->id) }}">View details</a>
                                        <!-- edit -->
                                        <a class="btn  btn-sm btn-parrot-green text-white"
                                            href="{{ route('customer.edit', $customer->id) }}"><i
                                                class="fa-solid fa-pencil"></i></a>
                                        <!-- delete -->
                                        @php $modeld = 'modelDelete'. $customer->id; @endphp
                                        @component('components.delete-model', [
                                            'modelId' => $modeld,
                                            'Action' => route('customer.destroy', $customer->id),
                                        ])
                                        @endcomponent



                                        <!-- Optional: Place to the bottom of scripts -->
                                        <script>
                                            const myModal = new bootstrap.Modal(document.getElementById('modalId'), options)
                                        </script>
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
