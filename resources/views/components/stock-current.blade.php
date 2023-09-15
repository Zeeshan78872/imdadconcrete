<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="">
            <tr>
                <th scope="col" class="text-blod">Product Name</th>
                <th scope="col" class="text-blod">Size</th>
                <th scope="col" class="text-blod">Quantity in SFT - Based on Size Variation</th>
                <th scope="col" class="text-blod">Total Quantity in SFT </th>
            </tr>
        </thead class="table table-dark">
        <tbody>
            {{-- @dd($selectCurrentStock); --}}
            @foreach ($selectCurrentStock['currentstocks'] as $stock)
                @php
                    $count = count($stock['details']['size']);
                @endphp
                <tr>
                    <td rowspan="{{ $count }}" class="align-middle">{{ $stock['product_name'] }}
                    </td>
                    <td>{{ $stock['details']['size'][0] }}</td>
                    <td>{{ $stock['details']['quantity'][0] }}</td>
                    <td rowspan="{{ $count }}" class="align-middle">{{ $stock['total'] }}</td>
                </tr>
                @if ($count > 1)
                    @for ($i = 1; $i < $count; $i++)
                        <tr>
                            <td>{{ $stock['details']['size'][$i] }}</td>
                            <td>{{ $stock['details']['quantity'][$i] }}</td>
                        </tr>
                    @endfor
                @endif
            @endforeach

        </tbody>
        <thead>
            <th colspan="3" class="text-end text-blod">Total Availabel Stock in SFT</th>
            <th style="    font-weight: 500;"> {{ $selectCurrentStock['overallSum'] }}</th>
        </thead>
    </table>
</div>
