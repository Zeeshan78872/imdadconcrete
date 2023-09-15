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




        .card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            border-radius: 4px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #337ab7;
            color: white;
            padding: 10px 15px;
        }

        .card-title {
            font-size: 18px;
        }

        .card-icon {
            float: right;
            margin-top: -10px;
        }

        .card-title {
            font-size: 18px;
        }

        .card-icon {
            float: right;
            margin-top: -10px;
        }

        .dashboard-card {
            box-shadow: 0px 4px 30px 0px rgba(15, 37, 110, 0.2);
            border-radius: 4px !important;
        }

        span.dashboard-icon {
            color: rgba(255, 255, 255, 0.2);
            font-size: 45px
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
@section('content')
    <div class="container mb-5">
        <div class="inner-container">
            <span>Dashboard</span>
        </div>

        <div class="row my-4">
            <div class="col-md-3 col-sm-6 my-2">
                <a href="{{ route('tuffTile.create') }}">
                    <div class="dashboard-card bg-primary">
                        <div class="icon-wrapper">
                            <i class="fa-solid fa-chart-bar"></i>
                        </div>
                        <div class="text-content">
                            Add Tuff Tiles and Block Stock
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 my-2">
                <a href="{{ route('chemicalTiles.create') }}">
                    <div class="dashboard-card bg-primary">
                        <div class="icon-wrapper">
                            <i class="fa-solid fa-notes-medical"></i>
                        </div>
                        <div class="text-content">
                            Add Chemical Concrete Pavers Stock
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 my-2">
                <a href="{{ route('DtuffTile.create') }}">
                    <div class="dashboard-card bg-primary">
                        <div class="icon-wrapper">
                            <i class="fa-regular fa-square"></i>
                        </div>
                        <div class="text-content">
                            Dispatch Order (Create Bilti) for Tuff Tiles and Blocks
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 my-2">
                <a href="{{ route('DchemicalTiles.create') }}">
                    <div class="dashboard-card bg-primary">
                        <div class="icon-wrapper">
                            <i class="fa-solid fa-chart-bar"></i>
                        </div>
                        <div class="text-content">
                            Dispatch Order (Create Bilti) for Chemical Concrete Pavers
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 my-2">
                <a href="{{ route('payment.create') }}">
                    <div class="dashboard-card bg-primary">
                        <div class="icon-wrapper">
                            <i class="fa-regular fa-clipboard me-1"></i>
                        </div>
                        <div class="text-content">
                            Add a Receive Payment Record
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 my-2">
                <a href="{{ route('cement.create') }}">
                    <div class="dashboard-card bg-primary">
                        <div class="icon-wrapper">
                            <i class="fa-solid fa-file-circle-plus"></i>
                        </div>
                        <div class="text-content">
                            Add Incoming Cement Stock
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 my-2">
                <a href="{{ route('gravelSand.create') }}">
                    <div class="dashboard-card bg-primary">
                        <div class="icon-wrapper">
                            <i class="fa-solid fa-file-circle-plus"></i>
                        </div>
                        <div class="text-content">
                            Add Incoming Gravel and Sand Stock
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 my-2">
                <a href="{{ route('customer.index') }}">
                    <div class="dashboard-card bg-primary">
                        <div class="icon-wrapper">
                            <i class="fa-solid fa-users me-1"></i>
                        </div>
                        <div class="text-content">
                            View Existing Customers
                        </div>
                    </div>
                </a>
            </div>

        </div>


    </div>
    </div>
@endsection
@section('script')
@endsection
