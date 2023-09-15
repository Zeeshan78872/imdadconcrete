@extends('layouts.app')

@section('style')
    <style>
        .stockCard {
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

        .total-text {
            font-family: Nunito;
            font-weight: 300;
            line-height: 30px;
            letter-spacing: 0em;
        }

        @media print {
            .actionHide {
                display: none;
            }
        }
    </style>
@endsection
@section('content')
    <div class="container mb-5">

        <div class="row">
            <div class="col-md-6   top-left-view">
                <span>Tuff Tiles & Blocks - In / Out Stock Summary</span>
            </div>

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
                <form method="POST" id="editForm" action="">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="from_date" class="form-label filter-title">From Date</label>
                                <input type="date" class="form-control" value="{{ $filter['from_date'] ?? '' }}"
                                    name="from_date" id="from_date" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="to_date" class="form-label filter-title">To Date</label>
                                <input type="date" class="form-control" name="to_date"
                                    value="{{ $filter['to_date'] ?? '' }}" id="to_date" placeholder="">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="product_id" class="form-label filter-title">Product Name </label>
                                <select id="itemSelect" class="form-select form-select-md" name="product_id"
                                    id="product_id">
                                    <option value="">Choose Product Name</option>
                                    @foreach ($products as $product)
                                        <option {{ ($filter['product_id'] ?? '') == $product->id ? 'selected' : '' }}
                                            value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="size" class="form-label filter-title">Size </label>
                                <select id="showSize" class="form-select form-select-md" name="size" id="size">
                                    <option value="">Choose Size</option>
                                    @if (isset($filter['product_id']) && $filter['product_id'] != null)
                                        @foreach ($sizes as $size)
                                            @if (($filter['product_id'] ?? '') == $size->product_id)
                                                <option {{ ($filter['size'] ?? '') == $size->id ? 'selected' : '' }}
                                                    value="{{ $size->id }}">{{ $size->size }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="text-end mt-4">
                                <a href="{{ route('tuffTile.index') }}" class="btn btn-light text-primary btn-rest me-3"
                                    id="resetButton">Reset</a>
                                <button type="submit" class="btn btn-primary">Apply Filter</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!---------------------------------------- View Total Stock Manufactured  --------------------------------->

        <div class="card stockCard shadow-2-strong bg-white mt-5 py-2 px-3">
            <div class="card-header bg-white py-3">
                <h4 class="page-title">Total Stock Manufactured</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="">
                        <thead>
                            <tr>
                                <th scope="col" class="text-blod">Product Name</th>
                                <th scope="col" class="text-blod">Size</th>
                                <th scope="col" class="text-blod">Quantity in SFT - Based on Size Variation</th>
                                <th scope="col" class="text-blod">Total Overall Quantity in SFT </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $itemsExceptFirst = [];
                                $TotalOverAll = 0;
                            @endphp
                            @foreach ($ProductSummery as $product)
                                @php
                                    $count = count($product['products']);
                                    $TotalOverAll += $product['products'][0]['quantity'];
                                @endphp
                                <tr class="">
                                    <td rowspan="{{ $count }}" class="align-middle">
                                        {{ $product['product_name'] }}
                                    </td>
                                    <td>{{ $product['products'][0]['size'] }}</td>
                                    <td>{{ $product['products'][0]['quantity'] }}</td>
                                    <td rowspan="{{ $count }}" class="align-middle">{{ $product['overall'] }}
                                    </td>
                                </tr>
                                @if ($count > 1)
                                    @php
                                        $itemsExceptFirst = array_merge($itemsExceptFirst, array_slice($product['products'], 1));
                                        
                                    @endphp
                                    @foreach ($itemsExceptFirst as $value)
                                        @php
                                            $TotalOverAll += $value['quantity'];
                                        @endphp
                                        <tr>
                                            <td>{{ $value['size'] }}</td>
                                            <td>{{ $value['quantity'] }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach


                        </tbody>
                        <thead>
                            <tr>
                                <th scope="col" class="text-end text-blod" colspan="3">Total Stock Manufactured in
                                    SFT:</th>
                                <th scope="col" style="font-weight: 500;">{{ $TotalOverAll }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>


        </div>
        <!---------------------------------------- View Total Stock Dispatched --------------------------------->

        <div class="card stockCard shadow-2-strong bg-white mt-5 py-2 px-3">
            <div class="card-header bg-white py-3">
                <h4 class="page-title">Total Stock Dispatched</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="">
                        <thead>
                            <tr>
                                <th scope="col" class="text-blod">Product Name</th>
                                <th scope="col" class="text-blod">Size</th>
                                <th scope="col" class="text-blod">Quantity in SFT - Based on Size Variation</th>
                                <th scope="col" class="text-blod">Total Overall Quantity in SFT </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $itemsExceptFirst = [];
                                $TotalOverAll = 0;
                            @endphp
                            @foreach ($dispatchProductSummery as $product)
                                @php
                                    $count = count($product['products']);
                                    $TotalOverAll += $product['products'][0]['quantity'];
                                @endphp
                                <tr class="">
                                    <td rowspan="{{ $count }}" class="align-middle">
                                        {{ $product['product_name'] }}
                                    </td>
                                    <td>{{ $product['products'][0]['size'] }}</td>
                                    <td>{{ $product['products'][0]['quantity'] }}</td>
                                    <td rowspan="{{ $count }}" class="align-middle">{{ $product['overall'] }}
                                    </td>
                                </tr>
                                @if ($count > 1)
                                    @php
                                        $itemsExceptFirst = array_merge($itemsExceptFirst, array_slice($product['products'], 1));
                                        
                                    @endphp
                                    @foreach ($itemsExceptFirst as $value)
                                        @php
                                            $TotalOverAll += $value['quantity'];
                                        @endphp
                                        <tr>
                                            <td>{{ $value['size'] }}</td>
                                            <td>{{ $value['quantity'] }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach


                        </tbody>
                        <thead>
                            <tr>
                                <th scope="col" class="text-end text-blod" colspan="3">Total Stock Manufactured in
                                    SFT:</th>
                                <th scope="col" style="    font-weight: 500;">{{ $TotalOverAll }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>


        </div>
        <!---------------------------------------- View Current stock  --------------------------------->

        <div class="card stockCard shadow-2-strong bg-white mt-5 py-2 px-3">
            <div class="card-header bg-white py-3">
                <h4 class="page-title">Current Stock</h4>
            </div>
            <div class="card-body">
                @component('components.stock-current', [
                    'selectCurrentStock' => selectCurrentStock('Tuff Tiles'),
                ])
                @endcomponent
            </div>


        </div>


    </div>
    </div>
@endsection
@section('script')
    <script>
        function printTable(id) {
            var printContents = document.getElementById(id).outerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
        $(document).ready(function() {
            $("#searchInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#Table tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
            $('#itemSelect').on('change', function() {
                const idToFetch = $(this).val();
                const url = window.location.origin + '/fetchSize/' + idToFetch;
                $('#showSize').empty();
                $('#showSize').append('<option value="">Choose Size</option>')
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $.each(response, function(index, value) {
                            $('#showSize').append('<option value="' + value['id'] +
                                '">' + value['size'] + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });


            // Listen for the reset button click
            let formModified = false;

            // Listen for input changes on form fields
            const formFields = document.querySelectorAll('#editForm input, #editForm select, #editForm textarea');
            formFields.forEach(field => {
                field.addEventListener('input', () => {
                    formModified = true;
                });
            });

            // Reset form function
            const resetForm = () => {
                document.getElementById('editForm').reset();
                formFields.forEach(field => {
                    field.value = ''; // Clear the field's value
                });
                formModified = false;
            };

            // Listen for the reset button click
            document.getElementById('resetButton').addEventListener('click', () => {
                if (formModified) {
                    resetForm();

                } else {
                    resetForm();
                }
            });

            // $('#Table').DataTable({});
            $('#myTable').DataTable({
                "paging": true // Enable pagination
            });
        });
    </script>
@endsection
