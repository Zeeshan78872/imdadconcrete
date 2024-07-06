@extends('layouts.app')

@section('style')
    <style>
        .card {
            width: 100%;
        }

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
    </style>
@endsection
@section('content')
    <div class="container mb-5">
        <div class="inner-container">
            <span>Existing Bank Details</span>
        </div>

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
                <form method="POST" action="{{ route('bank.filter') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="account_category" class="form-label">Account Category</label>
                                <select class="form-select form-select-md" name="account_category" id="account_category">
                                    <option value="">Choose Account Category</option>
                                    @foreach ($AccountCategory as $category)
                                    <option {{(($filter['account_category'] ?? '') == $category)?'selected':'' }} value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="text-end mt-4">
                                <a href="{{ route('bank.index') }}"
                                    class="btn btn-light text-primary btn-rest">Reset</a>
                                <button type="submit" class="btn btn-primary">Apply Filter</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <!-------------------- View gravel sand  ---------------------->

        <div class="card stockCard shadow-2-strong bg-white mt-5 py-2 px-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="">
                        <thead class="">
                            <tr>
                                <th scope="col">Account Category</th>
                                <th scope="col">Account Title - Bank Name</th>
                                <th scope="col">Account Number</th>
                                <th scope="col">City - Branch Address</th>
                                <th scope="col">Account type</th>
                                <th scope="col">Status</th>
                                <th scope="col">Account Owners</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($banks as $bank)
                                <tr>
                                    <td>{{ $bank->account_category }}</td>
                                    <td>{{ $bank->title_bank_name }}</td>
                                    <td>{{ $bank->account_number }}</td>
                                    <td>{{ $bank->city_branch_add }}</td>
                                    <td>{{ $bank->account_type }}</td>
                                    <td>{{ $bank->status }}</td>
                                    <td>{{ $bank->account_owner }}</td>
                                    <td>
                                        <!-- edit -->
                                        <a class="btn  btn-sm btn-parrot-green text-white"
                                            href="{{ route('bank.edit', $bank->id) }}"><i class="fa-solid fa-pencil"></i></a>
                                        <!-- delete -->
                                        <!-- Modal Body -->
                                        @php
                                            $model_id = 'deletemodel' . $bank->id;
                                        @endphp
                                        @component('components.delete-model', ['Action' => route('bank.destroy', $bank->id), 'modelId' => $model_id])
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
