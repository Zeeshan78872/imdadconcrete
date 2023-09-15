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
        @component('components.success-model', [
            'title' => 'Customer Added Successfully ',
            'desc' => 'A new customer has been added to the list',
            'closeText' => 'Close',
        ])
            <a href="{{ route('customer.index') }}" class="btn btn-primary">View All Customers</a>
        @endcomponent

        <div class="row">
            <div class="col-md-6   top-left-view">
                <span>List of All Existing Customers</span>
            </div>
            <div class="col-md-6  top-right-view d-flex align-items-center justify-content-end">
                <a href="{{ route('customer.create') }}" class="btn btn-primary">Add Customer</a>
            </div>
        </div>



        <div class="card stockCard shadow-2-strong bg-white mt-5 py-2 px-3">

            <div class="card-body">

                <div class="table-responsive">
                    <h4 class="col page-title">Total Customer: <span
                            style="font-weight: 400;">{{ $customers->count() }}</span></h4>
                    <table class="table table-bordered" id="myTable">
                        <thead class="">
                            <tr>
                                <th scope="col" class="text-blod">C.ID</th>
                                <th scope="col" class="text-blod">Customer Name</th>
                                <th scope="col" class="text-blod">Company Name</th>
                                <th scope="col" class="text-blod">City or Area</th>
                                <th scope="col" class="text-blod">Phone No. 1</th>
                                <th scope="col" class="text-blod">Phone No. 2</th>
                                <th scope="col" class="text-blod">Action</th>
                            </tr>
                        </thead class="table table-dark">
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $customer->customer_id }}</td>
                                    <td class="long-text">{{ $customer->customer_name }}</td>
                                    <td>{{ $customer->company_name }}</td>
                                    <td class="long-text">{{ $customer->city_area }}</td>
                                    <td>{{ $customer->phone_number_1 }}</td>
                                    <td class="text-center">{{ $customer->phone_number_2 ?? '-' }}</td>
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
