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
            <span>Bilti Listing</span>
            <a href="{{ route('bilti.create') }}" class="btn btn-primary float-right">Create Bilti</a>
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
                            <a href="" class="btn btn-primary">Download / Print
                                Invoice</a>
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
                <form method="POST" action="">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="from_date" class="form-label">From Date</label>
                                <input type="date" class="form-control" name="from_date" id="from_date" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="to_date" class="form-label">To Date</label>
                                <input type="date" class="form-control" name="to_date" id="to_date" placeholder="">
                            </div>
                        </div>



                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="customer_name" class="form-label">Customer Name</label>
                                <select class="form-select form-select-md" name="customer_name" id="customer_name">
                                    <option selected>Choose Customer Name</option>
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
                                <th scope="col">Bilti No.</th>
                                <th scope="col">Date</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Grand Total in SFT</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead class="table table-dark">
                        <tbody>
                            @for ($i = 1; $i < 12; $i++)
                                <tr>
                                    <td>00233</td>
                                    <td>13/07/23</td>
                                    <td>Airi Satou</td>
                                    <td>23650</td>
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
                                            href="{{ route('bilti.edit', 0) }}"><i class="fa-solid fa-pencil"></i></a>
                                        <!-- view -->
                                        <a class="btn  btn-sm btn-primary text-white" href=""><i
                                                class="fa-solid fa-file-lines"></i></a>
                                        <!-- delete -->
                                        <button class="btn  btn-sm btn-danger text-white" data-bs-toggle="modal"
                                            data-bs-target="#modalId"><i class="fa-solid fa-trash"></i></button>


                                        <!-- Modal Body -->
                                        <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                        <div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static"
                                            data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="text-center my-5">
                                                            <span class="cancel-icon"><i
                                                                    class="fa-solid fa-xmark fa-2xl"></i></span>
                                                        </div>
                                                        <div class="text-center my-2">
                                                            <span class="model_title">
                                                                Are You Sure?
                                                            </span>
                                                            <p class="model_description">
                                                                Do you really want to delete these record?<br>
                                                                This process cannot be undone.
                                                            </p>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                            <button type="button" class="btn btn-danger">Delete</button>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                        <!-- Optional: Place to the bottom of scripts -->
                                        <script>
                                            const myModal = new bootstrap.Modal(document.getElementById('modalId'), options)
                                        </script>
                                    </td>
                                </tr>
                            @endfor


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
