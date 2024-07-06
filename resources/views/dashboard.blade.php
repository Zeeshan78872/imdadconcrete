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
            <div class="col-md-3 col-sm-6 my-1">
                <div class="dashboard-card"style="background-color: rgba(53, 184, 224, 1);border-radius: 4px;">
                    <div class="row align-items-center">
                        <span class="dashboard-icon col-4"><i class="fa-solid fa-chart-bar mx-2"></i></span>
                        <div class="col-8 text-white">Stock</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 my-1">
                <div class="dashboard-card" style="background-color: rgba(255, 91, 91, 1);border-radius: 4px;">
                    <div class="row align-items-center">
                        <span class="dashboard-icon col-4 text-center"><i class="fa-regular fa-square"></i></span>
                        <div class="col-8 text-white">Dispatch Stock</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 my-1">
                <div class="dashboard-card " style="background-color: rgba(16, 196, 105, 1);border-radius: 4px;">
                    <div class="row align-items-center">
                        <span class="dashboard-icon col-4"><i class="fa-solid fa-users mx-2"></i></span>
                        <div class="col-8 text-white">Customer</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 my-1">
                <div class="dashboard-card"style="background-color: rgba(224, 135, 53, 1);border-radius: 4px;">
                    <div class="row align-items-center">
                        <span class="dashboard-icon col-4"><i class="fa-solid fa-calendar-days mx-2"></i></span>
                        <div class="col-8 text-white">Current Stock</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card stockCard shadow-2-strong bg-white mt-5 py-2 px-3">
                    <div class="card-body">
                        <h5 class="card-title">Bar CHart</h5>
                        <canvas id="barChart" style="max-height: 400px;"></canvas>
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new Chart(document.querySelector('#barChart'), {
                                    type: 'bar',
                                    data: {
                                        labels: [
                                            'Red',
                                            'Blue',
                                            'Yellow',
                                            'Red',
                                            'Blue',
                                            'Yellow'
                                        ],
                                        datasets: [{
                                            label: 'My First Dataset',
                                            data: [300, 50, 100, 500, 650, 400],
                                            backgroundColor: [
                                                'rgb(255, 99, 132)',
                                                'rgb(54, 162, 235)',
                                                'rgb(255, 205, 86)',
                                                'rgb(255, 99, 132)',
                                                'rgb(54, 162, 235)',
                                                'rgb(255, 205, 86)'
                                            ],
                                            hoverOffset: 4
                                        }]
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card stockCard shadow-2-strong bg-white mt-5 py-2 px-3">
                    <div class="card-body">
                        <h5 class="card-title">Bar CHart</h5>
                        <canvas id="pieChart" style="max-height: 400px;"></canvas>
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new Chart(document.querySelector('#pieChart'), {
                                    type: 'pie',
                                    data: {

                                        datasets: [{
                                            label: 'My First Dataset',
                                            data: [300, 50, 100, 500, 650, 400],
                                            backgroundColor: [
                                                'rgb(255, 99, 132)',
                                                'rgb(54, 162, 235)',
                                                'rgb(255, 205, 86)',
                                                'rgb(255, 99, 132)',
                                                'rgb(54, 162, 235)',
                                                'rgb(255, 205, 86)'
                                            ],
                                            hoverOffset:3
                                        }], labels: [
                                            'Red',
                                            'Blue',
                                            'Yellow',
                                            'Red',
                                            'Blue',
                                            'Yellow'
                                        ],
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
@endsection
@section('script')
@endsection
