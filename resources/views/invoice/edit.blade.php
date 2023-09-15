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
            margin-top: 95px !important;

        }

        .stockCard {
            width: 86%;
            margin: 0 auto;
            /* Set left and right margins to auto to center the div */
            padding: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="container mb-5">
        <div class="row">
            <div class="col-6 col-md-auto  top-left">
                <span>Edit Invoice Details</span>
            </div>


        </div>

        <div class="card stockCard shadow-2-strong bg-white mt-5 py-2 px-3">
            <div class="card-header bg-white text-center">
                <h4 class="page-title">EDIT INVOICE DETAILS</h4>
            </div>
            <div class="card-body">


                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="POST" action="">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="billing_date" class="form-label text-blod">Billing Date <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="date" class="form-control" name="from_date" id="from_date" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="from_date" class="form-label text-blod">From Date <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="date" class="form-control" name="from_date" id="from_date" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="to_date" class="form-label text-blod">To Date <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="date" class="form-control" name="to_date" id="to_date" placeholder="">
                            </div>
                        </div>

                    </div>
                    <span class="my-3 text-blod">Customer Details</span>
                    <div class="row bg-light mb-3 mt-3">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="category" class="form-label text-blod">Customer Name <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <select class="form-select form-select-md" name="category" id="category">
                                    <option selected>Choose Customer Name</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="category" class="form-label text-blod">Company Name <sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" name="company_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="category" class="form-label text-blod">Contact No.<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="tel" name="contact_no" class="form-control" placeholder="0300 0000000">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="category" class="form-label text-blod">City or Area<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="tel" name="city" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="category" class="form-label text-blod">Purpose of Purchase<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="tel" name="purposeOFPurchase" class="form-control" placeholder="">
                            </div>
                        </div>
                    </div>
                    <span class="my-3 text-blod">Company Details</span>
                    <div class="row bg-light mt-3 mb-3 ">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="category" class="form-label text-blod">Contact No.<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="tel" name="contact_no" class="form-control" placeholder="0300 0000000">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="category" class="form-label text-blod">Web Site</label>
                                <input type="tel" name="contact_no" class="form-control" placeholder="www.xyz.com">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="category" class="form-label text-blod">Email</label>
                                <input type="tel" name="contact_no" class="form-control"
                                    placeholder="example@example.com">
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="button" class="btn btn-light text-primary btn-rest mx-3">Reset</button>
                        <button type="submit" class="btn btn-primary">Print Invoice</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
