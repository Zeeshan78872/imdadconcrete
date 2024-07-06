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
        }

        .bg-color td,
        .bg-color th {
            background: linear-gradient(to bottom, #fff, #f1f1f1b5);
        }

        .nav-tabs .nav-link.active {
            background-color: #0f256e !important;
            color: #ffffff !important;
            border-radius: unset;
        }

        .nav.nav-tabs {
            background-color: rgba(222, 226, 230, 1);
        }

        .nav-tabs .nav-link {
            color: #000;
        }

        .tab-title {
            font-family: Nunito;
            font-size: 17px;
            font-weight: 500;
            line-height: 16px;
            letter-spacing: 0.2879999876022339px;
            text-align: left;

        }

        .customer-table th {
            font-family: Nunito;
            font-size: 16px;
            font-weight: 400;
            line-height: 22px;
            letter-spacing: 0em;
            text-align: left;
            border-color: rgba(222, 226, 230, 1) !important;
        }

        .customer-table td {
            font-family: Nunito;
            font-size: 15px;
            font-weight: 600;
            line-height: 22px;
            letter-spacing: 0em;
            text-align: left;
            border-color: rgba(222, 226, 230, 1) !important;
        }


        .card-header:not(.collapsed) .rotate-icon {
            transform: rotate(180deg);
        }

        .btn .fa-solid {
            float: right;
            transition: transform 0.2s;
        }

        /* Style the icon to rotate when the collapsible is active */
        .collapse.show .icon {
            transform: rotate(180deg);
            transition: transform 0.3s ease;
        }
    </style>
    <!-- Add the jQuery library -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
@section('content')
    <div class="container mb-5">
        <div class="inner-container">
            <span>Customer Name (Company Name)</span>
            <span class="float-right">
                <a href="#" class="a-link">Dashboard</a>
                <span class="ms-3">Current Stock</span>
            </span>
        </div>


        <div class="card stockCard shadow-2-strong bg-white mt-5 ">
            <div class="card-body">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <button class="nav-link  active" id="nav-customerDetail-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-customerDetail" type="button" role="tab" aria-controls="nav-home"
                            aria-selected="true">Customer Detail</button>
                        <button class="nav-link" id="nav-dispatchDetail-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-dispatchDetail" type="button" role="tab" aria-controls="nav-profile"
                            aria-selected="false">Dispatch Detail</button>
                        <button class="nav-link" id="nav-payment-tab" data-bs-toggle="tab" data-bs-target="#nav-payment"
                            type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Payment
                            History</button>
                        <button class="nav-link" id="nav-materialDispatch-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-materialDispatch" type="button" role="tab" aria-controls="nav-profile"
                            aria-selected="false">Final Material Dispatch & Payment Report</button>

                        <button class="nav-link" id="nav-bilti-tab" data-bs-toggle="tab" data-bs-target="#nav-bilti"
                            type="button" role="tab" aria-controls="nav-bilti" aria-selected="false">Bilti</button>
                        <button class="nav-link" id="nav-invoice-tab" data-bs-toggle="tab" data-bs-target="#nav-invoice"
                            type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Invoice</button>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                    {{-- CUSTOMERS DETAIL --}}
                    <div class="tab-pane fade show active pt-3" id="nav-customerDetail" role="tabpanel"
                        aria-labelledby="nav-customerDetail-tab">
                        <span class="tab-title mx-3">CUSTOMERS DETAIL</span>
                        <div class="table-responsive">
                            <table class="table table-bordered mt-2">
                                <tr class="customer-table">
                                    <th scope="col" class=" bg-light">Customer ID</th>
                                    <td scope="col">C001</td>
                                    <th scope="col" class=" bg-light">Customer Name</th>
                                    <td scope="col">Zeeshan</td>
                                </tr>
                                <tr class="customer-table">
                                    <th scope="col" class=" bg-light">Company Name</th>
                                    <td scope="col">Crexed</td>
                                    <th scope="col" class=" bg-light">City or Area</th>
                                    <td scope="col">Bahawalpur</td>
                                </tr>
                                <tr class="customer-table">
                                    <th scope="col" class=" bg-light">Phone Number 1</th>
                                    <td scope="col">030077777654</td>
                                    <th scope="col" class=" bg-light">Phone Number 2</th>
                                    <td scope="col">030055555555</td>
                                </tr>
                            </table>
                        </div>

                    </div>
                    {{-- Dispatch Detail --}}
                    <div class="tab-pane fade pt-3" id="nav-dispatchDetail" role="tabpanel"
                        aria-labelledby="nav-dispatchDetail-tab">
                        <span class="tab-title mx-3">Dispatch Detail </span>
                        <div id="accordion">
                            {{-- tuff tiles  --}}
                            <div class="my-2">
                                <div class="">
                                    <a class="btn btn-primary d-flex justify-content-between align-items-center"
                                        style="width: -webkit-fill-available;" data-bs-toggle="collapse"
                                        href="#collapseOne">
                                        Tuff Tiles <i class="fa-solid fa-angle-down"></i>
                                    </a>
                                </div>
                                <div id="collapseOne" class="collapse show" data-bs-parent="#accordion">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="">
                                                <thead class="">
                                                    <tr>

                                                        <th scope="col" rowspan="2">B.No.</th>
                                                        <th scope="col" rowspan="2">Date</th>
                                                        <th scope="col" rowspan="2">Customer Name</th>
                                                        <th scope="col" rowspan="2">City/Area</th>
                                                        <th scope="col" rowspan="2">Product Type</th>
                                                        <th scope="col" rowspan="2">Size</th>
                                                        <th scope="col" rowspan="2">SFT Ratio</th>
                                                        <th scope="col" rowspan="2">Total Tiles</th>
                                                        <th scope="col" colspan="2">Color's Quantity</th>
                                                        <th scope="col" rowspan="2">Tiles in SFT</th>
                                                        <th scope="col" rowspan="2">Price / SFT</th>
                                                        <th scope="col" rowspan="2">Total Price</th>
                                                        <th scope="col" rowspan="2">Vehicle Type</th>
                                                        <th scope="col" rowspan="2">Vehicle No.</th>
                                                        <th scope="col" rowspan="2">Action</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Red</th>
                                                        <th>Gray</th>
                                                    </tr>

                                                </thead class="table table-dark">
                                                <tbody>
                                                    <tr>

                                                        <td rowspan="2" class="align-middle">001</td>
                                                        <td rowspan="2" class="align-middle">13/07/23</td>
                                                        <td rowspan="2" class="align-middle">Zeeshan Mushtaq</td>
                                                        <td rowspan="2" class="align-middle">Airi Satou</td>
                                                        <td>Auto mobile</td>
                                                        <td>150</td>
                                                        <td>23%</td>
                                                        <td>2365</td>
                                                        <td>20</td>
                                                        <td>20</td>
                                                        <td>344</td>
                                                        <td>2365</td>
                                                        <td>Zigzag</td>
                                                        <td rowspan="2" class="align-middle">Zigzag</td>
                                                        <td rowspan="2" class="align-middle">600</td>
                                                        <td rowspan="2" class="align-middle">
                                                            <!-- edit -->
                                                            <a class="btn  btn-sm btn-parrot-green text-white"
                                                                href=""><i class="fa-solid fa-pencil"></i></a>
                                                            <!-- delete -->
                                                            <button class="btn  btn-sm btn-danger text-white"
                                                                data-bs-toggle="modal" data-bs-target="#modalId"><i
                                                                    class="fa-solid fa-trash"></i></button>
                                                            <!-- Modal Body -->
                                                            <div class="modal fade" id="modalId" tabindex="-1"
                                                                data-bs-backdrop="static" data-bs-keyboard="false"
                                                                role="dialog" aria-labelledby="modalTitleId"
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
                                                                                    Do you really want to delete these
                                                                                    record?<br>
                                                                                    This process cannot be undone.
                                                                                </p>
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                                <button type="button"
                                                                                    class="btn btn-danger">Delete</button>

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
                                                    <tr>
                                                        <td>Auto mobile</td>
                                                        <td>150</td>
                                                        <td>23%</td>
                                                        <td>2365</td>
                                                        <td>20</td>
                                                        <td>20</td>
                                                        <td>34</td>
                                                        <td>2365</td>
                                                        <td>Zigzag</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- chemical tiles --}}
                            <div class="">
                                <div class="">
                                    <a class="collapsed btn btn-primary d-flex justify-content-between align-items-center"
                                        style="width: -webkit-fill-available;" data-bs-toggle="collapse"
                                        href="#collapseTwo">
                                        <span>Chemical Tiles</span> <i class=" fa-solid fa-angle-down"></i>
                                    </a>
                                </div>
                                <div id="collapseTwo" class="collapse" data-bs-parent="#accordion">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="">
                                                <thead class="">
                                                    <tr>

                                                        <th scope="col" rowspan="2">B.No.</th>
                                                        <th scope="col" rowspan="2">Date</th>
                                                        <th scope="col" rowspan="2">Customer Name</th>
                                                        <th scope="col" rowspan="2">City/Area</th>
                                                        <th scope="col" rowspan="2">Product Type</th>
                                                        <th scope="col" rowspan="2">Size</th>
                                                        <th scope="col" rowspan="2">SFT Ratio</th>
                                                        <th scope="col" rowspan="2">Total Tiles</th>
                                                        <th scope="col" colspan="5" class="text-center">Color's
                                                            Quantity</th>
                                                        <th scope="col" rowspan="2">Tiles in SFT</th>
                                                        <th scope="col" rowspan="2">Price / SFT</th>
                                                        <th scope="col" rowspan="2">Total Price</th>
                                                        <th scope="col" rowspan="2">Vehicle Type</th>
                                                        <th scope="col" rowspan="2">Vehicle No.</th>
                                                        <th scope="col" rowspan="2">Action</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Red</th>
                                                        <th>Gray</th>
                                                        <th>Black</th>
                                                        <th>Yellow</th>
                                                        <th>Green</th>
                                                    </tr>
                                                </thead class="table table-dark">
                                                <tbody>
                                                    <tr>
                                                        <td rowspan="2" class="align-middle">001</td>
                                                        <td rowspan="2" class="align-middle">13/07/23</td>
                                                        <td rowspan="2" class="align-middle">Zeeshan Mushtaq</td>
                                                        <td rowspan="2" class="align-middle">Airi Satou</td>
                                                        <td>Auto mobile</td>
                                                        <td>150</td>
                                                        <td>23%</td>
                                                        <td>2365</td>
                                                        <td>20</td>
                                                        <td>20</td>
                                                        <td>20</td>
                                                        <td>20</td>
                                                        <td>20</td>
                                                        <td>344</td>
                                                        <td>2365</td>
                                                        <td>Zigzag</td>
                                                        <td rowspan="2" class="align-middle">Zigzag</td>
                                                        <td rowspan="2" class="align-middle">600</td>
                                                        <td rowspan="2" class="align-middle">
                                                            <!-- edit -->
                                                            <a class="btn  btn-sm btn-parrot-green text-white"
                                                                href=""><i class="fa-solid fa-pencil"></i></a>
                                                            <!-- delete -->
                                                            <button class="btn  btn-sm btn-danger text-white"
                                                                data-bs-toggle="modal" data-bs-target="#modalId"><i
                                                                    class="fa-solid fa-trash"></i></button>
                                                            <!-- Modal Body -->
                                                            <div class="modal fade" id="modalId" tabindex="-1"
                                                                data-bs-backdrop="static" data-bs-keyboard="false"
                                                                role="dialog" aria-labelledby="modalTitleId"
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
                                                                                    Do you really want to delete these
                                                                                    record?<br>
                                                                                    This process cannot be undone.
                                                                                </p>
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                                <button type="button"
                                                                                    class="btn btn-danger">Delete</button>

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
                                                    <tr>
                                                        <td>Auto mobile</td>
                                                        <td>150</td>
                                                        <td>23%</td>
                                                        <td>2365</td>
                                                        <td>20</td>
                                                        <td>20</td>
                                                        <td>20</td>
                                                        <td>20</td>
                                                        <td>20</td>
                                                        <td>34</td>
                                                        <td>2365</td>
                                                        <td>Zigzag</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- ----------- Payment history ------------- --}}
                    <div class="tab-pane fade pt-3" id="nav-payment" role="tabpanel" aria-labelledby="nav-payment-tab">
                        <span class="tab-title mx-3">Payment history </span>
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered" id="myTable">
                                <thead class="">
                                    <tr>

                                        <th scope="col">Billing ID</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Customer Name</th>
                                        <th scope="col">Company Name</th>
                                        <th scope="col">Deposit Bank Name</th>
                                        <th scope="col">Amount Received</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 1; $i < 12; $i++)
                                        <tr>

                                            <td>001</td>
                                            <td>13/07/23</td>
                                            <td>Zeeshan mushtaq</td>
                                            <td>Crexed</td>
                                            <td>Allied Bank</td>
                                            <td>16000</td>

                                        </tr>
                                    @endfor


                                </tbody>
                            </table>
                        </div>
                        <div class="row justify-content-center mt-5">
                            {{-- Final Received Payment Records - Customer wise --}}
                            <div class="col-md-6">
                                <div class="card stockCard shadow-2-strong bg-white mt-2 ">
                                    <div class="card-header bg-blue text-center text-white">
                                        Final Received Payment Records - Bank wise
                                    </div>
                                    <div class="table-responsive m-3">
                                        <table class="table table-bordered" id="myTable">
                                            <thead class="">
                                                <tr>
                                                    <th scope="col">Bank Name</th>
                                                    <th scope="col">Deposited Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- @foreach ($payments as $payment) --}}
                                                    <tr>
                                                        <td>Allied Bank</td>
                                                        <td>3243</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Allied Bank</td>
                                                        <td>3243</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Allied Bank</td>
                                                        <td>3243</td>
                                                    </tr>
                                                {{-- @endforeach --}}
                                            </tbody>
                                            <thead class="">
                                                <tr>
                                                    <th scope="col" class="text-end">Grand Total:</th>
                                                    <th scope="col">456546</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    {{-- Material Dispatch Report --}}
                    <div class="tab-pane fade pt-3" id="nav-materialDispatch" role="tabpanel"
                        aria-labelledby="nav-materialDispatch-tab">
                        <span class="tab-title mx-3">Material Dispatch Report</span>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="table-responsive mt-2">
                                    <table class="table table-bordered" id="myTable">
                                        <thead class="">
                                            <tr>

                                                <th scope="col">Product Category</th>
                                                <th scope="col">Product Type</th>
                                                <th scope="col">Size or Thickness</th>
                                                <th scope="col">Total material in SFT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td>0012</td>
                                            <td>AbC company</td>
                                            <td>60mm</td>
                                            <td>2365</td>

                                        </tbody>
                                        <thead class="">
                                            <tr>
                                                <th scope="col" colspan="3" class="text-end" >Grand Total:</th>
                                                <th scope="col">20500</th>
                                            </tr>
                                        </thead>
                                    </table>


                                </div>

                            </div>
                            <div class="col-md-5">
                                <div class="card stockCard shadow-2-strong bg-white mt-2 ">
                                    <div class="card-header bg-blue text-center text-white">
                                        Payment Report
                                    </div>
                                    <div class="">
                                        <table class="table  mb-0">
                                            <tr class="">
                                                <th class="text-center bg-light">Grand Total</th>
                                                <td class="text-center bg-light">20500</td>
                                            </tr>
                                            <tr class="">
                                                <td class="text-center">Recover or Advance</td>
                                                <td class="text-center">20500</td>
                                            </tr>
                                            <tr class="">
                                                <td class="text-center">Remaning Balance</td>
                                                <td class="text-center">5000</td>
                                            </tr>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    {{-- Bilti --}}
                    <div class="tab-pane fade pt-3" id="nav-bilti" role="tabpanel" aria-labelledby="nav-bilti-tab">
                        <div class="my-3"><span class="tab-title my-3">Bilti</span>
                            <button class="btn btn-primary " style="float: right;">Create Bilti For Chemical Concrete Pavers</button>
                            <button class="btn btn-primary me-2" style="float: right;">Create Bilti For Tuff Tiles & Blocks</button>
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered" id="myTable">
                                <thead>
                                    <tr>
                                        <th scope="col">Bilti No.</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Grand total in SFT</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="">
                                        <td>0012</td>
                                        <td>13/07/23</td>
                                        <td>2365</td>
                                        <td>
                                            {{-- view  --}}
                                            <button class="btn btn-primary btn-sm">View</button>
                                            {{-- print  --}}
                                            <button class="btn btn-info btn-sm"><i class="fa-solid fa-print"></i></button>
                                            {{-- pdf --}}
                                            <button class="btn btn-secondary btn-sm"><i
                                                    class="fa-solid fa-file-pdf"></i></button>
                                            <!-- edit -->
                                            <a class="btn  btn-sm btn-parrot-green text-white" href=""><i
                                                    class="fa-solid fa-pencil"></i></a>
                                            <!-- delete -->
                                            <button class="btn  btn-sm btn-danger text-white" data-bs-toggle="modal"
                                                data-bs-target="#modaBilti"><i class="fa-solid fa-trash"></i></button>
                                            <!-- Modal Body -->
                                            <div class="modal fade" id="modaBilti" tabindex="-1"
                                                data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                                aria-labelledby="modalTitleId" aria-hidden="true">
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
                                                                    Do you really want to delete these
                                                                    record?<br>
                                                                    This process cannot be undone.
                                                                </p>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="button"
                                                                    class="btn btn-danger">Delete</button>

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
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- invoice --}}
                    <div class="tab-pane fade pt-3" id="nav-invoice" role="tabpanel" aria-labelledby="nav-invoice-tab">
                        <div class="my-3"><span class="tab-title my-3">Invoice</span>
                            <button class="btn btn-primary" style="float: right;">Create Invoice</button>
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Invoice No.</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Total Amount</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="">
                                        <td>0012</td>
                                        <td>13/07/23</td>
                                        <td>2365</td>
                                        <td>
                                            {{-- view  --}}
                                            <button class="btn btn-primary btn-sm">View</button>
                                            {{-- print  --}}
                                            <button class="btn btn-info btn-sm"><i class="fa-solid fa-print"></i></button>
                                            {{-- pdf --}}
                                            <button class="btn btn-secondary btn-sm"><i
                                                    class="fa-solid fa-file-pdf"></i></button>
                                            <!-- edit -->
                                            <a class="btn  btn-sm btn-parrot-green text-white" href=""><i
                                                    class="fa-solid fa-pencil"></i></a>
                                            <!-- delete -->
                                            <button class="btn  btn-sm btn-danger text-white" data-bs-toggle="modal"
                                                data-bs-target="#modaBilti"><i class="fa-solid fa-trash"></i></button>
                                            <!-- Modal Body -->
                                            <div class="modal fade" id="modaBilti" tabindex="-1"
                                                data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                                aria-labelledby="modalTitleId" aria-hidden="true">
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
                                                                    Do you really want to delete these
                                                                    record?<br>
                                                                    This process cannot be undone.
                                                                </p>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="button"
                                                                    class="btn btn-danger">Delete</button>

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
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    </div>
@endsection
@section('script')
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
@endsection
