@extends('layouts.app')

@section('style')
    <style>
        /* .card {
            margin-top: 134px !important;
        } */

        .inner-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

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

        .stockCard {
            width: 100%;
        }
    </style>
@endsection
@section('content')
    <div class="container mb-5">
        <div class="inner-container">
            <span>User Listing</span>
            {{-- <span class="float-right">
                <a href="#" class="a-link">Dashboard</a>
                <span class="ms-3">User Listing</span>
            </span> --}}
        </div>



        <div class="card stockCard shadow-2-strong bg-white mt-5 py-2 px-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="">
                        <thead class="">
                            <tr>
                                <th scope="col">User ID</th>
                                <th scope="col">Full Name </th>
                                <th scope="col">Username</th>
                                <th scope="col">Role</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead class="table table-dark">
                        <tbody>
                            @for ($i = 1; $i < 12; $i++)
                                <tr>
                                    <td>ID202</td>
                                    <td>Zeeshan mushtaq mushtaq mushtaq</td>
                                    <td>zeeshan123</td>
                                    <td>Admin</td>
                                    <td> <!-- edit -->
                                        <a class="btn  btn-sm btn-parrot-green text-white" href=""><i
                                                class="fa-solid fa-pencil"></i></a>
                                        <!--  -->
                                        <a class="btn  btn-sm btn-warning text-white" href=""><i
                                                class="fa-solid fa-ban"></i></a>
                                        <!-- delete -->
                                        @component('components.delete-model', ['modelId' => '', 'Action' => ''])
                                        @endcomponent

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
@endsection
