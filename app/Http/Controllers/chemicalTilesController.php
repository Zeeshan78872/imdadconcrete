<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\stock;
use App\Models\stockProduct;
use Illuminate\Support\Carbon;

class chemicalTilesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = stock::query();
        $currentDateTime = Carbon::now();
        $Date = $currentDateTime->format('Y-m-d');
        $query->where('category', 'Chemical Tiles');
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
        $products = Product::where('category', 'Chemical Tiles')->get();
        $TotalCement = 0;
        $TotalStock = 0;
        $TotalFarma = 0;
        $ProductSummery = [];
        // dd($stocks->toArray());
        foreach ($stocks as $stock) {
            $TotalCement += $stock->cement_packs;
            $TotalStock += $stock->total_stock;
            foreach ($stock->products as $product) {
                $TotalFarma += $product->total_farma;

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
                                'quantity' => $product->quentity_sft
                            ]
                        ],
                    ];
                } else {
                    if ($ProductSummery[$productId]['products'][0]['size_id'] != $product->size_id) {
                        $ProductSummery[$productId]['products'][] = [
                            'size_id' => $product->size_id,
                            'size' => $product->mainSize->size,
                            'quantity' => $product->quentity_sft
                        ];
                    } else {
                        $sumSize = $ProductSummery[$productId]['products'][0]['quantity'] + $product->quentity_sft;
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
        // dd($ProductSummery);

        // dd($stocks);
        return view(
            'stock.ChemicalConcert.index',
            compact(
                'products', // whole products
                'filter', // active filter
                'stocks',
                'ProductSummery',
                'TotalCement',
                'TotalFarma',
                'TotalStock'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::where('category', 'Chemical Tiles')->get();
        return view('stock.ChemicalConcert.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date'        => ['required'],
            'cement_pack' => ['required'],
            'product_id.*' => ['required'],
            'size.*'      => ['required'],
            'total_farma.*' => ['required'],
            'quantity_sft.*' => ['required'],
        ]);
        // dd($request);
        $stock = new stock();
        $stock->date = $request->date;
        $stock->category = 'Chemical Tiles';
        $stock->cement_packs = $request->cement_pack;
        $stock->total_stock = $request->total_stock_sft;
        $stock->save();
        $stock_id = $stock->id;
        $product_id = $request->input('product_id');
        $sizes = $request->input('size');
        $total_farmas = $request->input('total_farma');
        $quantity_sfts = $request->input('quantity_sft');

        foreach ($sizes as $index => $size) {
            $data[] = [
                'stock_id' => $stock_id,
                'product_id' => $product_id[$index],
                'size_id' => $size,
                'total_farma' => $total_farmas[$index],
                'quentity_sft' => $quantity_sfts[$index]
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
        //
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
        return redirect()->route('chemicalTiles.index');
    }
}
