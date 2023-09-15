<div class="table-responsive">
    <table class="table table-bordered display" id="dataTable" style="width:100%">
            <tr>
                <th scope="col">Date</th>
                <th scope="col">Plant Name</th>
                <th scope="col">Product Name</th>
                <th scope="col">Size</th>
                <th scope="col">Cement Pack</th>
                <th scope="col">No.of Pallets</th>
                <th scope="col">Tiles / Pallet</th>
                <th scope="col">Total Tiles in SFT</th>
            </tr>
            @foreach ($stocks as $index => $stock)
                @php
                    $count = $stock->products->count();
                @endphp
                <tr>
                    <td rowspan="{{ $count }}" class="align-middle rowspan-cell">
                        {{ $stock->date }}
                    </td>
                    <td>{{ $stock->products?->first()?->plant_name }}</td>
                    <td>{{ $stock->products?->first()?->mainProduct->name }}</td>
                    <td>{{ $stock->products?->first()?->mainSize->size }}</td>
                    <td>{{ $stock->products?->first()?->cement_packs }}</td>
                    <td>{{ $stock->products?->first()?->no_pallets }}</td>
                    <td>{{ $stock->products?->first()?->tiles_pallets }}</td>
                    <td>{{ $stock->products?->first()?->total_tiles_sft }}</td>

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
    </table>
    {{-- {{ $stocks->appends($queryParams)->links() }} --}}
</div>
