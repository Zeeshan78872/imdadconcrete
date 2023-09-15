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

        .stockCard {
            width: 86%;
            margin: 0 auto;
            padding: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="container mb-5">
        <div class="row">
            <div class="col-6 col-md-auto  top-left">
                <span>Create Bilti</span>
            </div>

            <div class="col-6 col-md-auto  text-md-end top-right top-right-content">
                <a href="#" class="a-link">Dashboard</a>
                <span class="ms-3">Create Bilti</span>
            </div>
        </div>

        <div class="card stockCard shadow-2-strong bg-white  py-2 px-3">
            <div class="card-header bg-white text-center">
                <h4 class="page-title">CREATE BILTI</h4>
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
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="invoice_no" class="form-label">Bilti No.<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control" name="invoice_no" readonly
                                    value="I{{ str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT) }}" id="invoice_no"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="time" class="form-label">Time<sup class="text-danger"><b>*</b></sup></label>
                                <input type="time" class="form-control" name="time" id="time" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="date" class="form-label">Date<sup class="text-danger"><b>*</b></sup></label>
                                <input type="date" class="form-control" name="date" id="date" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="category" class="form-label">Customer Name<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <select class="form-select form-select-md" name="category" id="category">
                                    <option selected>Choose Customer Name</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="city" class="form-label">City or Area<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <select class="form-select form-select-md" name="city" id="city">
                                    <option selected>Choose City or Area</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="contact_no" class="form-label">Contact No.<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control" name="contact_no" id="contact_no" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="contact_no" class="form-label">Contact No. (Optional)<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control" name="contact_no" id="contact_no" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="vehicle_type" class="form-label">Vehicle Type<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <select class="form-select form-select-md" name="city" id="city">
                                    <option selected>Choose Vehicle Type</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="contact_no" class="form-label">Vehicle No.<sup
                                        class="text-danger"><b>*</b></sup></label>
                                <input type="text" class="form-control" name="contact_no" id="contact_no"
                                    placeholder="">
                            </div>
                        </div>


                    </div>

                    <div class="text-center">
                        <button type="button" class="btn btn-light text-primary btn-rest">Reset</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
