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
        <div class="inner-container">
            <span>Invoice Listing</span>
            <a href="{{ route('invoice.create') }}" class="btn btn-primary float-right">Create Invoice</a>
        </div>
        <!-- Model for success message after add invoice successfully -->
        <div class="modal fade" id="modalIdSuccess" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-body">
                        <div class="text-center my-5">
                            <span class="success-icon py-3 px-3"><i class="fa-solid fa-check"></i></span>
                        </div>
                        <div class="text-center my-2">
                            <span class="model_title">
                                Product Added Successfully
                            </span>
                            <p class="model_description">
                                Your Product added into Product listing Successfully <br>
                            </p>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <a href="" class="btn btn-primary">Download / Print Invoice</a>
                            <a href="" class="btn btn-primary">View All Invoices</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Your other content -->
        @if (session('success'))
            <script>
                // Script to show the modal after the page is loaded
                document.addEventListener("DOMContentLoaded", function() {
                    var myModal = new bootstrap.Modal(document.getElementById('modalIdSuccess'));
                    myModal.show();
                });
            </script>
        @endif
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
                <form method="POST" action="{{ route('invoice.filter') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="from_date" class="form-label">From Date</label>
                                <input type="date" class="form-control" name="from_date"
                                    value="{{ $filter['from_date'] ?? '' }}" id="from_date" placeholder="">
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
                                <label for="customer_id" class="form-label">Customer Name</label>
                                <select id="searchableSelect" class="form-select form-control form-select-md " required
                                    name="customer_id">
                                    <option value="">Choose Customer</option>
                                    @foreach ($customers as $customer)
                                        <option {{ ($filter['customer_id'] ?? '') == $customer->id ? 'selected' : '' }}
                                            value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex align-items-center justify-content-center">
                            <div class="text-end">
                                <button type="button" class="btn btn-light text-primary btn-rest">Reset</button>
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
                    <table class="table table-bordered" id="">
                        <thead class="">
                            <tr>
                                <th scope="col">Invoice No.</th>
                                <th scope="col">Date</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Total Amount</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead class="table table-dark">
                        <tbody>
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->invoice_no }}</td>
                                    <td>{{ $invoice->date }}</td>
                                    <td>{{ $invoice->customer_id }}</td>
                                    <td>{{ $invoice->total_price }}</td>
                                    <td>
                                        {{-- view  --}}
                                        <button class="btn btn-primary btn-sm">View</button>
                                        {{-- print  --}}
                                        <button class="btn btn-info btn-sm"><i class="fa-solid fa-print"></i></button>
                                        {{-- pdf --}}
                                        <button class="btn btn-secondary btn-sm"><i
                                                class="fa-solid fa-file-pdf"></i></button>

                                        <!-- edit -->
                                        <a class="btn  btn-sm btn-parrot-green text-white"
                                            href="{{ route('invoice.edit', 0) }}"><i class="fa-solid fa-pencil"></i></a>
                                       
                                        <!-- delete -->
                                        @php
                                            $model_id = 'modelDelete' . $invoice->id;
                                        @endphp
                                        @component('components.delete-model', [
                                            'Action' => route('invoice.destroy', $invoice->id),
                                            'modelId' => $model_id,
                                        ])
                                        @endcomponent
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
