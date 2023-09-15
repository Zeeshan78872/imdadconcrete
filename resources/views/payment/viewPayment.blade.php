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

        .stockCard {
            width: 100%;
        }
    </style>
@endsection
@section('content')
    <div class="container mb-5">
        <div class="row">
            <div class="col-md-6   top-left-view">
                <span>Received Payment Listing</span>
            </div>
            <div class="col-md-6  top-right-view d-flex align-items-center justify-content-end">
                <a href="{{ route('payment.create') }}" class="btn btn-primary">Add A Received Payment Record</a>
            </div>
        </div>
        {{-- success model  --}}
        @component('components.success-model', [
            'title' => 'Payment Record Added Successfully',
            'desc' => 'A received payment record has been added to the list',
            'closeText' => 'Close',
        ])
            <a href="{{ route('payment.index') }}" class="btn btn-primary">View All Received Payments</a>
        @endcomponent

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
                <form method="POST" action="{{ route('payment.filter') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="from_date" class="form-label filter-title">From Date <sup
                                        class="text-danger"></label>
                                <input type="date" class="form-control " name="from_date"
                                    value="{{ $filter['from_date'] ?? '' }}" id="from_date" placeholder="">

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="to_date" class="form-label filter-title">From Date <sup
                                        class="text-danger"></label>
                                <input type="date" class="form-control " name="to_date"
                                    value="{{ $filter['to_date'] ?? '' }}" id="to_date" placeholder="">

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="customer_id" class="form-label filter-title">Customer Name</label>
                                <select class="form-select form-select-md" name="customer_id" id="searchableSelect">
                                    <option value="">Choose Customer Name</option>

                                    @foreach ($customerNames as $name)
                                        @php
                                            $selected = ($filter['customer_id'] ?? '') == $name->id ? 'selected' : '';
                                        @endphp
                                        <option {{ $selected }} value="{{ $name->id }}">
                                            {{ $name->customer_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="deposit_bank_name" class="form-label filter-title">Deposit Bank Account</label>
                                <select class="form-select form-select-md" name="deposit_bank_name" id="deposit_bank_name">
                                    <option value="">Choose Bank Account</option>
                                    @foreach ($DepositBank as $bank)
                                        <option
                                            {{ ($filter['deposit_bank_name'] ?? '') == $bank->title_bank_name ? 'selected' : '' }}
                                            value="{{ $bank->title_bank_name }}">{{ $bank->title_bank_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- <div class="col-md-3">
                            <div class="mb-3">
                                <label for="amount_reveived" class="form-label">Amount Received </label>
                                <input type="number" class="form-control " name="amount_reveived"
                                    value="{{ $filter['amount_reveived'] ?? '' }}" id="amount_reveived" placeholder="">

                            </div>
                        </div> --}}
                        <div class="col-md-12">
                            <div class="text-end mt-4 pt-1">
                                <a href="{{ route('payment.index') }}"
                                    class="btn btn-light text-primary btn-rest mx-3">Reset</a>
                                <button type="submit" class="btn btn-primary">Apply Filter</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- --------------------- View Payment Listing ------------------------------ --}}
        <div class="card stockCard shadow-2-strong bg-white mt-5 py-2 px-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="myTable">
                        <thead class="">
                            <tr>

                                <th scope="col" class="text-blod">Payment ID</th>
                                <th scope="col" class="text-blod">Date</th>
                                <th scope="col" class="text-blod">Customer Name</th>
                                <th scope="col" class="text-blod">Company Name</th>
                                <th scope="col" class="text-blod">Deposit Bank Name</th>
                                <th scope="col" class="text-blod">Amount Received</th>
                                <th scope="col" class="text-blod">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($payments as $payment)
                                <tr>

                                    <td>{{ $payment->payment_id }}</td>
                                    <td>{{ $payment->date }}</td>
                                    <td class="long-text">{{ $payment->customer->customer_name }}</td>
                                    <td class="long-text text-center">{{ $payment->company_name ?? '-' }}</td>
                                    <td>{{ $payment->deposit_bank_name }}</td>
                                    <td>{{ $payment->amount_reveived }}</td>
                                    <td>
                                        <!-- edit -->
                                        <a class="btn  btn-sm btn-parrot-green text-white"
                                            href="{{ route('payment.edit', $payment->id) }}"><i
                                                class="fa-solid fa-pencil"></i></a>
                                        <!--delete Modal  -->
                                        @php $modeld = 'modelDelete'. $payment->id; @endphp
                                        @component('components.delete-model', ['modelId' => $modeld, 'Action' => route('payment.destroy', $payment->id)])
                                        @endcomponent

                                    </td>
                                </tr>
                            @endforeach




                        </tbody>
                    </table>
                </div>
            </div>


        </div>

        <div class="row justify-content-center mt-5">
            {{-- Final Received Payment Records - Customer wise --}}
            <div class="col-md-6">
                <div class="card  shadow-2-strong bg-white mt-2 ">
                    <div class="card-header bg-blue text-center text-white">
                        Final Received Payment Records - Customer Wise
                    </div>
                    <div class="table-responsive m-3">
                        <table class="table table-bordered" id="myTable">
                            <thead class="">
                                <tr>
                                    <th scope="col" class="text-blod">Customer Name</th>
                                    <th scope="col" class="text-blod">Deposited Amount</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($paymentCustomer as $payment)
                                    <tr>
                                        <td>{{ $payment['customer_name'] }}</td>
                                        <td>{{ $payment['amount_reveived'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <thead class="">
                                <tr>
                                    <th scope="col" class="text-end text-blod"><b>Grand Total:</b></th>
                                    <th scope="col" style="font-weight: 300;">{{ $TotalPayment }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            {{-- Final Received Payment Records - Bank wise --}}
            <div class="col-md-6">
                <div class="card  shadow-2-strong bg-white mt-2 ">
                    <div class="card-header bg-blue text-center text-white">
                        Final Received Payment Records - Bank Account Wise
                    </div>
                    <div class="table-responsive m-3">
                        <table class="table table-bordered" id="myTable">
                            <thead class="">
                                <tr>
                                    <th scope="col" class="text-blod">Bank Account</th>
                                    <th scope="col" class="text-blod">Deposited Amount</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($paymentBank as $payment)
                                    <tr>
                                        <td>{{ $payment['deposit_bank_name'] }}</td>
                                        <td>{{ $payment['amount_reveived'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <thead class="">
                                <tr>
                                    <th scope="col" class="text-end text-blod"><b>Grand Total:</b></th>
                                    <th scope="col" style="font-weight: 300;">{{ $TotalPayment }}</th>
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
    <script>
        $('#searchableSelect').select2({});

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
