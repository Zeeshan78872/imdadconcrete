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
        <div class="row">
            <div class="col-md-6   top-left-view">
                <span>Existing System Users on View</span>
            </div>
            <div class="col-md-6  top-right-view d-flex align-items-center justify-content-end">
                <a href="{{ route('user.create') }}" class="btn btn-primary">Add A User</a>
            </div>
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
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->user_id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->role }}

                                    </td>
                                    <td> <!-- edit -->
                                        <a class="btn  btn-sm btn-parrot-green text-white"
                                            href="{{ route('user.edit', $user->id) }}"><i
                                                class="fa-solid fa-pencil"></i></a>
                                        <!--  -->
                                        <!-- delete -->
                                        @php
                                            $modelId = 'modelsoft' . $user->id;
                                        @endphp
                                        @component('components.soft-delete-model', [
                                            'modelId' => $modelId,
                                            'Action' => route('user.softDelete', $user->id),
                                        ])
                                        @endcomponent
                                        <form action="{{ route('logout.other') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            <button class="btn  btn-sm btn-warning text-white mt-2"
                                                type="submit">logout</button>
                                        </form>

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
@endsection
