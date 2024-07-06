@extends('layouts.app')

@section('style')
    <style>
        .stockCard {
            width: 100%
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
    </style>
    <!-- Example of including Bootstrap CSS and JavaScript -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-8hgVJjHlqfpW4lVg+o6XbbHsRB/1KhgStxmAxhNGQp5PyZifVJZpEAwo6W+XTz5" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-jFnAj7hTfko3lOKcddz77L7goMHhV/j7Ig2Fs7B5Hq2GgE2yU3FSCirz2U2MvRWp" crossorigin="anonymous">
    </script>
@endsection
@section('content')
    <div class="container mb-5">

        <div class="inner-container mt-2">
            <span class="top-left mt-2">Product Listing</span>
        </div>

        <div class="card stockCard shadow-2-strong bg-white mt-5 py-2 px-3">

            <div class="card-body">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <button class="nav-link  active" id="nav-customerDetail-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-customerDetail" type="button" role="tab" aria-controls="nav-home"
                            aria-selected="true">Tuff Tiles & Blocks</button>

                        <button class="nav-link" id="nav-dispatchDetail-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-dispatchDetail" type="button" role="tab" aria-controls="nav-profile"
                            aria-selected="false">Chemical Concrete Pavers</button>

                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    {{-- Tuff Tiles & Blocks --}}
                    <div class="tab-pane fade show active pt-3" id="nav-customerDetail" role="tabpanel"
                        aria-labelledby="nav-customerDetail-tab">
                        <div class="table-responsive">
                             <div><span class="float-left m-2"><b>Total Products:</b>{{$products->where('category', 'Tuff Tiles')->count()}}</span></div>
                            <table class="table table-bordered" id="myTable">
                                <thead class="">
                                    <tr>
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Product Size</th>
                                        <th scope="col">SFT Ratio</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead class="table table-dark">
                                <tbody>
                                    @foreach ($products->where('category', 'Tuff Tiles') as $product)
                                        @php
                                            $count = $product->sizes->count();
                                            $array = $product->sizes->toArray();
                                        @endphp
                                        <tr>
                                            </td>
                                            <td rowspan="{{ $count }}" class="align-middle">{{ $product->name }}</td>
                                            <td>{{ $product->sizes?->first()?->size }}</td>
                                            <td>{{ $product->sizes?->first()?->sft }}</td>
                                            <td rowspan="{{ $count }}" class="align-middle">
                                                <!-- edit -->
                                                <a class="btn  btn-sm btn-parrot-green text-white"
                                                    href="{{ route('product.edit', $product->id) }}"><i
                                                        class="fa-solid fa-pencil"></i></a>
                                                <!--delete Modal  -->
                                                @php $modeld = 'modelDelete'. $product->id; @endphp
                                                @component('components.delete-model', ['modelId' => $modeld, 'Action' => route('product.destroy', $product->id)])
                                                @endcomponent
                                                <!-- Optional: Place to the bottom of scripts -->
                                                <script>
                                                    const myModal = new bootstrap.Modal(document.getElementById('modalId'), options)
                                                </script>
                                            </td>
                                        </tr>
                                        @if ($count > 1)
                                            @foreach ($product->sizes->slice(1) as $size)
                                                <tr>
                                                    <td>{{ $size->size }}</td>
                                                    <td>{{ $size->sft }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Chemical Concrete Pavers --}}
                    <div class="tab-pane fade pt-3" id="nav-dispatchDetail" role="tabpanel"
                        aria-labelledby="nav-dispatchDetail-tab">
                        <div class="table-responsive">
                            <div><span class="float-right m-2"><b>Total Products:</b>{{$products->where('category', 'Chemical Tiles')->count()}}</span></div>
                            <table class="table table-bordered" id="MYTable">
                                <thead class="">
                                    <tr>
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Product Type</th>
                                        <th scope="col">Height Type</th>
                                        <th scope="col">Product Size</th>
                                        <th scope="col">SFT Ratio</th>
                                        <th scope="col">Quantity / Farma</th>
                                        <th scope="col">Total Farmas</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead class="table table-dark">
                                <tbody>
                                    @foreach ($products->where('category', 'Chemical Tiles') as $product)
                                        @php
                                            $count = $product->sizes->count();
                                            $array = $product->sizes->toArray();
                                        @endphp
                                        <tr>
                                            <td rowspan="{{ $count }}" class="align-middle">{{ $product->name }}</td>
                                            <td rowspan="{{ $count }}" class="align-middle">{{ $product->product_type }}</td>
                                            <td rowspan="{{ $count }}" class="align-middle">{{ $product->height_type }}</td>
                                            <td>{{ $product->sizes?->first()?->size }}</td>
                                            <td>{{ $product->sizes?->first()?->sft }}</td>
                                            <td>{{ $product->sizes?->first()?->quantity_farma }}</td>
                                            <td>{{ $product->sizes?->first()?->total_farma }}</td>
                                            <td rowspan="{{ $count }}" class="align-middle">
                                                <!-- edit -->
                                                <a class="btn  btn-sm btn-parrot-green text-white"
                                                    href="{{ route('product.edit', $product->id) }}"><i
                                                        class="fa-solid fa-pencil"></i></a>

                                                <!--delete Modal  -->
                                                @php $modeld = 'modelDelete'. $product->id; @endphp
                                                @component('components.delete-model', ['modelId' => $modeld, 'Action' => route('product.destroy', $product->id)])
                                                @endcomponent

                                                <!-- Optional: Place to the bottom of scripts -->
                                                <script>
                                                    const myModal = new bootstrap.Modal(document.getElementById('modalId'), options)
                                                </script>
                                            </td>
                                        </tr>
                                        @if ($count > 1)
                                            @foreach ($product->sizes->slice(1) as $size)
                                                <tr>
                                                    <td>{{ $size->size }}</td>
                                                    <td>{{ $size->sft }}</td>
                                                    <td>{{ $size->quantity_farma }}</td>
                                                    <td>{{ $size->total_farma }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#MYTable').DataTable({
                dom: 'Bfrtip', // Display buttons
                buttons: [
                    'pdf', 'print'
                ],
                border: true
            });
        })
    </script>
@endsection
