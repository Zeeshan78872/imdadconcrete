<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\stock;
use App\Models\stockProduct;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;

class TuffTilesStockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = stock::query();
        $currentDateTime = Carbon::now();
        $Date = $currentDateTime->format('Y-m-d');
        $query->where('category', 'Tuff Tiles');
        if ($request->isMethod('POST')) {
            // dump($request);
            if (!empty($request->all())) {
                $filter = $request->all();
                if ($filter['from_date'] != null && $filter['to_date'] != null) {
                    $query->whereBetween('date', [$filter['from_date'], $filter['to_date']]);
                } elseif ($filter['from_date'] != null && $filter['to_date'] == null) {
                    $query->whereBetween('date', [$filter['from_date'], $Date]);
                } elseif ($filter['from_date'] == null && $filter['to_date'] != null) {
                    $query->where('date', '<=', $filter['to_date']);
                } else {
                    $query->where('date', $Date);
                }
                if (!empty($filter['plant_name'])) {
                    $query->whereHas('products', function ($subQuery) use ($filter) {
                        $subQuery->where('plant_name', 'LIKE', '%' . $filter['plant_name'] . '%');
                    });
                }
                if (!empty($filter['product_id'])) {
                    $query->whereHas('products', function ($subQuery) use ($filter) {
                        $subQuery->where('product_id', $filter['product_id']);
                    });
                }
                if (!empty($filter['size'])) {
                    $query->whereHas('products', function ($subQuery) use ($filter) {
                        $subQuery->where('size_id', $filter['size']);
                    });
                }
            } else {
                $query->where('date', $Date);
                $filter = null;
            }
        } else {
            $query->where('date', $Date);
            $filter = null;
        }

        $stocks = $query->with(['products' => function ($productQuery) use ($filter) {
            if (!empty($filter['product_id'])) {
                $productQuery->where('product_id', $filter['product_id']);
            }
            if (!empty($filter['size_id'])) {
                $productQuery->where('size_id', $filter['size_id']);
            }
        }])->OrderBy('date', 'DESC')->get();
        // dd($stocks);
        $products = Product::where('category', 'Tuff Tiles')->get();
        $TotalCement = 0;
        $TotalPallet = 0;
        $TotalTiles = 0;
        $ProductSummery = [];

        foreach ($stocks as $stock) {

            foreach ($stock->products as $product) {

                $TotalCement += $product->cement_packs;
                $TotalPallet += $product->no_pallets;
                $TotalTiles += $product->total_tiles_sft;

                $productId = $product->product_id;
                if (!isset($ProductSummery[$productId])) {
                    $ProductSummery[$productId] = [
                        'overall' => '',
                        'product_id' => $product->product_id,
                        'product_name' => $product->mainProduct->name,
                        'products' => [
                            [
                                'size_id' => $product->size_id,
                                'size' => $product->mainSize->size,
                                'quantity' => $product->total_tiles_sft
                            ]
                        ],
                    ];
                } else {
                    if ($ProductSummery[$productId]['products'][0]['size_id'] != $product->size_id) {
                        $ProductSummery[$productId]['products'][] = [
                            'size_id' => $product->size_id,
                            'size' => $product->mainSize->size,
                            'quantity' => $product->total_tiles_sft
                        ];
                    } else {
                        $sumSize = $ProductSummery[$productId]['products'][0]['quantity'] + $product->total_tiles_sft;
                        $ProductSummery[$productId]['products'][0]['quantity'] = $sumSize;
                    }
                }
            }
        }
        // create total summery
        foreach ($ProductSummery as $key => $value) {
            $overall = 0;

            foreach ($value['products'] as $data) {
                $overall += $data['quantity'];
            }
            $ProductSummery[$key]['overall'] = $overall;
            // dump($value);
        }
        $PlantName = getPlantName();

        return view(
            'stock.tuffTiles.index',
            compact(
                'products', // whole products
                'filter', // active filter
                'stocks',
                'ProductSummery',
                'TotalCement',
                'TotalPallet',
                'TotalTiles',
                'PlantName'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $PlantName = getPlantName();
        $products = Product::where('category', 'Tuff Tiles')->get();
        return view('stock.tuffTiles.create', compact('products', 'PlantName'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $rules = [
            'plant_name.*' => ['required'],
            'product_id.*' => ['required'],
            'size.*' => ['required'],
            'cement_pack.*' => ['required'],
            'pallet_no.*' => ['required'],
            'tiles_pallet.*' => ['required'],
            'totla_tiles.*' => ['required'],
        ];

        $this->validate($request, $rules);
        //    dd($request);
        $stock = new stock();
        $stock->date = $request->date;
        $stock->category = 'Tuff Tiles';
        $stock->save();
        $stock_id = $stock->id;
        $plant_name = $request->input('plant_name');
        $product_id = $request->input('product_id');
        $sizes = $request->input('size');
        $cement_packs = $request->input('cement_pack');
        $no_pallets = $request->input('pallet_no');
        $tiles_pallets = $request->input('tiles_pallet');
        $total_tiles_sft = $request->input('totla_tiles');

        foreach ($sizes as $index => $size) {
            $data[] = [
                'stock_id' => $stock_id,
                'product_id' => $product_id[$index],
                'size_id' => $size,
                'plant_name' => $plant_name[$index],
                'cement_packs' => $cement_packs[$index],
                'no_pallets' => $no_pallets[$index],
                'tiles_pallets' => $tiles_pallets[$index],
                'total_tiles_sft' => $total_tiles_sft[$index],
            ];
        }
        // dd($data);
        foreach ($data as $value) {
            stockProduct::create($value);
        }
        return redirect()->back()->with('success', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $PlantName = getPlantName();
        $products = Product::where('category', 'Tuff Tiles')->get();
        $stocks = stock::with('products')->find($id);
        // dd($stocks);
        return view('stock.tuffTiles.edit',compact('stocks','products','PlantName'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        stock::find($id)->delete();
        stockProduct::where('stock_id', $id)->delete();
        return redirect()->route('tuffTile.index');
    }
}