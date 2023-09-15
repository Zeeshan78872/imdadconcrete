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
                <span>View All Tuff Tiles</span>
            </div>
            <div class="col-md-6  top-right-view d-flex align-items-center justify-content-end">
                <a href="{{ route('tuffTile.create') }}" class="btn btn-primary float-right">Add Stock</a>
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
                <form method="POST" id="editForm" action="{{ route('tuffTile.filter') }}">
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
                                <label for="plant_name" class="form-label filter-title">Plant Name</label>
                                <select class="form-select form-select-md" name="plant_name" id="plant_name">
                                    <option value="">Choose Plant Name</option>
                                    @foreach ($PlantName as $name)
                                        <option {{ ($filter['plant_name'] ?? '') == $name ? 'selected' : '' }}
                                            value="{{ $name }}">{{ $name }}</option>
                                    @endforeach
                                </select>
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
                        <div class="col-md-9">
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

        <!---------------------------------------- View Tiles  --------------------------------->

        <div class="card stockCard shadow-2-strong bg-white mt-5 py-2 px-3">
            <div class="card-body">
                <div class="table-responsive">
                    <a class="btn-danger btn" href="{{ route('tufftiles.pdf') }}">
                        Print
                    </a>
                    <div class="col-md-3 ms-auto mb-3">
                        <input type="text" name="searchInput" id="searchInput" class="form-control"
                            placeholder="Enter Here to search">
                    </div>
                    <table class="table table-bordered display" id="dataTable" style="width:100%">
                        <thead class="">
                            <tr>
                                <th scope="col text-blod">Date</th>
                                <th scope="col text-blod">Plant Name</th>
                                <th scope="col text-blod">Product Name</th>
                                <th scope="col text-blod">Size</th>
                                <th scope="col text-blod">Cement Pack</th>
                                <th scope="col text-blod">No.of Pallets</th>
                                <th scope="col text-blod">Tiles / Pallet</th>
                                <th scope="col text-blod">Total Tiles in SFT</th>
                                <th scope="col text-blod" class="actionHide">Action</th>
                            </tr>
                        </thead class="table table-dark">
                        <tbody>
                            @foreach ($stocks as $index => $stock)
                                @php
                                    $count = $stock->products->count();
                                @endphp
                                <tr>
                                    <td rowspan="{{ $count }}" class="align-middle rowspan-cell">
                                        {{ $stock->date }}
                                    </td>
                                    <td class="long-text ">{{ $stock->products?->first()?->plant_name }}</td>
                                    <td class="long-text ">{{ $stock->products?->first()?->mainProduct->name }}</td>
                                    <td>{{ $stock->products?->first()?->mainSize->size }}</td>
                                    <td>{{ $stock->products?->first()?->cement_packs }}</td>
                                    <td>{{ $stock->products?->first()?->no_pallets }}</td>
                                    <td>{{ $stock->products?->first()?->tiles_pallets }}</td>
                                    <td>{{ $stock->products?->first()?->total_tiles_sft }}</td>
                                    <td class="actionHide align-middle rowspan-cell" rowspan="{{ $count }}">
                                        <!-- edit -->
                                        <a class="btn  btn-sm btn-parrot-green text-white"
                                            href="{{ route('tuffTile.edit', $stock->id) }}"><i
                                                class="fa-solid fa-pencil"></i></a>
                                        <!-- delete -->
                                        @php
                                            $modelId = 'modelDelete' . $stock->id;
                                        @endphp
                                        @component('components.soft-delete-model', [
                                            'modelId' => $modelId,
                                            'Action' => route('tuffTile.softDelete', $stock->id),
                                        ])
                                        @endcomponent
                                    </td>
                                </tr>
                                @if ($count > 1)
                                    @foreach ($stock->products->slice(1) as $product)
                                        <tr>
                                            <td>{{ $product->plant_name }}</td>
                                            <td>{{ $product->mainProduct->name }}</td>
                                            <td>{{ $product->mainSize->size }}</td>
                                            <td>{{ $product->cement_packs }}</td>
                                            <td>{{ $product->no_pallets }}</td>
                                            <td>{{ $product->tiles_pallets }}</td>
                                            <td>{{ $product->total_tiles_sft }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach

                        </tbody>
                    </table>
                    {{-- {{ $stocks->appends($queryParams)->links() }} --}}
                </div>
            </div>


        </div>

        <!-- Grand Totals  -->
        <div class="card stockCard shadow-2-strong bg-white mt-5 py-2 px-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-4 total-text "><span><span class="text-blod">Total Cement Packs:
                            </span>{{ $TotalCement }}</span></div>
                    <div class="col-4 total-text text-center"><span><span class="text-blod">Total Pallet:</span>
                            {{ $TotalPallet }}</span></div>
                    <div class="col-4 total-text text-end"><span><span class="text-blod">Total Products Manufactured in
                                SFT:</span>
                            {{ $TotalTiles }}</span></div>
                </div>
            </div>
        </div>
        <!-- Summery -->
        <div class="card stockCard shadow-2-strong bg-white mt-5 py-2 px-3">
            <div class="card-header bg-white py-3">
                <h4 class="page-title">Total Stock Summary</h4>
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
                                <th scope="col" style="    font-weight: 500;">{{ $TotalOverAll }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
    </div>
    {{-- <div style="display: none;"> --}}
    <div id="pdf-content" class="d-none">
        @include('components.pdf-stock', ['stocks' => $stocks])
    </div>
    {{-- </div> --}}
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <script>
        const element = document.getElementById('pdf-content');
        document.addEventListener('DOMContentLoaded', function() {
            const generatePdfButton = document.getElementById('pdf-button');
            generatePdfButton.addEventListener('click', function() {

                const componentContent = document.getElementById('pdf-content').innerHTML;
                console.log(componentContent);

                const pdfOptions = {
                    margin: 10,
                    filename: 'my-document.pdf',
                    image: {
                        type: 'jpeg',
                        quality: 0.98
                    },
                    html2canvas: {
                        scale: 2
                    },
                    jsPDF: {
                        unit: 'mm',
                        format: 'a4',
                        orientation: 'portrait'
                    },
                };
                console.log(pdfOptions);
                html2pdf().from(componentContent).set(pdfOptions).outputPdf();
            });
        });

        $(document).ready(function() {
            $("#searchInput").focus().on("keyup", function() {
                var value = $(this).val();
                var trs = $("#dataTable tbody tr:nth-child(n+2)");
                for (let i = 0; i < trs.length;) {
                    let grp = $(trs.slice(i, i += trs[i].children[0].rowSpan));
                    $(grp).toggle(!!$('td:contains(' + value + ')', grp).length);
                }
            });

        });

        function printTable(id) {
            var printContents = document.getElementById(id).outerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
        $(document).ready(function() {

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
