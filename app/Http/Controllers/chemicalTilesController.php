<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\stock;
use App\Models\stockProduct;
use App\Models\productSize;
use Illuminate\Support\Carbon;
use App\Rules\QuantityLimit;

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
        $query->where('category', 'Chemical Tiles')->where('delete', 0);
        if ($request->isMethod('POST')) {
            // dd($request);
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

                if (!empty($filter['product_type']) && !empty($filter['product_id']) && !empty($filter['size'])) {
                    $query->whereHas('products', function ($subQuery) use ($filter) {
                        $subQuery->where('product_type', $filter['product_type'])
                            ->where('product_id', $filter['product_id'])
                            ->where('size_id', $filter['size']);
                    });
                } elseif (!empty($filter['product_type']) && !empty($filter['product_id'])) {
                    $query->whereHas('products', function ($subQuery) use ($filter) {
                        $subQuery->where('product_type', $filter['product_type'])
                            ->where('product_id', $filter['product_id']);
                    });
                } elseif (!empty($filter['product_type'])) {
                    $query->whereHas('products', function ($subQuery) use ($filter) {
                        $subQuery->where('product_type', $filter['product_type']);
                    });
                }
            } else {
                $query->where('date', $Date);
                $filter = null;
            }
        } else {
            $query->where('date', $Date);
            $filter = null;
            $filter['from_date'] = $Date;
            $filter['to_date'] = $Date;
        }
        // dd($query);
        $stocks = $query->with([
            'products' => function ($productQuery) use ($filter) {

                if (!empty($filter['product_type']) && !empty($filter['product_id']) && !empty($filter['size'])) {
                    $productQuery->where('product_type', $filter['product_type'])
                        ->where('product_id', $filter['product_id'])
                        ->where('size_id', $filter['size']);
                } elseif (!empty($filter['product_type']) && !empty($filter['product_id'])) {
                    $productQuery->where('product_type', $filter['product_type'])
                        ->where('product_id', $filter['product_id']);
                } elseif (!empty($filter['product_type'])) {
                    $productQuery->where('product_type', $filter['product_type']);
                }
                $productQuery->where('delete', 0);
            },
            'products.mainProduct', // Eager load mainProduct relationship
            'products.mainSize',
        ])->OrderBy('date', 'DESC')->get();
        // dd($stocks);
        $products = Product::where('category', 'Chemical Tiles')->where('delete', 0)->get();
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
        $sizes = productSize::all();
        $productTypes = getProductType();

        return view(
            'stock.ChemicalConcert.index',
            compact(
                'products', // whole products
                'filter', // active filter
                'stocks',
                'ProductSummery',
                'TotalCement',
                'TotalFarma',
                'TotalStock',
                'sizes',
                'productTypes'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productTypes = getProductType();
        $products = Product::where('category', 'Chemical Tiles')->where('delete', 0)->get();
        $sizes = productSize::all();

        return view('stock.ChemicalConcert.create', compact('sizes', 'products', 'productTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'date'        => ['required'],
                'cement_pack' => ['required'],
                'product_type.*' => ['required'],
                'product_id.*' => ['required'],
                'size.*'      => ['required'],
                'total_farma.*' => ['required'],
                'quantity_sft.*' => ['required'],
            ],
            [
                'date.date' => 'Date is required',
                'cement_pack.required' => 'Cement Pack is required'
            ]
        );
        // dd($request);
        $stock = new stock();
        $stock->date = $request->date;
        $stock->category = 'Chemical Tiles';
        $stock->cement_packs = $request->cement_pack;
        $stock->total_stock = $request->total_stock_sft;
        $stock->save();
        $stock_id = $stock->id;
        $product_type = $request->input('product_type');
        $product_id = $request->input('product_id');
        $sizes = $request->input('size');
        $total_farmas = $request->input('total_farma');
        $quantity_sfts = $request->input('quantity_sft');

        foreach ($sizes as $index => $size) {
            $data[] = [
                'stock_id' => $stock_id,
                'product_id' => $product_id[$index],
                'product_type' => $product_type[$index],
                'size_id' => $size,
                'total_farma' => $total_farmas[$index],
                'quentity_sft' => $quantity_sfts[$index]
            ];
            addCurrentStock('Chemical Tiles', $product_type[$index], $product_id[$index], $size, $quantity_sfts[$index]);
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
        $productTypes = getProductType();
        $products = Product::where('category', 'Chemical Tiles')->get();
        $stocks = stock::with(['products' => function ($productQuery) {
            $productQuery->where('delete', 0);
        }])->find($id);
        $sizes = productSize::where('delete', 0)->get();

        // dd($products);
        return view('stock.ChemicalConcert.edit', compact('sizes', 'stocks', 'products', 'productTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = ([
            'date'        => ['required'],
            'cement_pack' => ['required'],
            'newproduct_type.*' => ['required'],
            'newproduct_id.*' => ['required'],
            'newsize.*'      => ['required'],
            'newtotal_farma.*' => ['required'],
            'newquantity_sft.*' => ['required'],

            'product_type.*' => ['required'],
            'product_id.*' => ['required'],
            'size.*'      => ['required'],
            'total_farma.*' => ['required'],
            'quantity_sft.*' => ['required'],
        ]);
        // dd($request);
        // set rule for check current quentity for already exist recore in dispatch
        foreach ($request->input('product_id') as $index => $productId) {
            $sizeId = $request->input('size')[$index];
            $totalTiles = $request->input('quantity_sft')[$index];
            $customMessages = [
                "quantity_sft.$index.required" => "Quantity  is required",
                // Other custom messages for specific rules if needed
            ];

            $rules["quantity_sft.$index"] = [
                'required'
            ];
        }

        if ($request->productCount != 0) {

            // set rule for check current quentity for new add record at edit
            foreach ($request->input('newproduct_id') as $index => $productId) {
                $sizeId = $request->input('newsize')[$index];
                $totalTiles = $request->input('newquantity_sft')[$index];
                $customMessages = [
                    "newquantity_sft.$index.required" => "Quantity  is required",
                    // Other custom messages for specific rules if needed
                ];

                $rules["newquantity_sft.$index"] = [
                    'required'
                ];
            }
        }

        $this->validate($request, $rules, $customMessages, ['cement_pack.reduired' => 'Cement pack is required']);

        $stock = stock::find($id);
        $stock->date = $request->date;
        $stock->cement_packs = $request->cement_pack;
        $stock->total_stock = $request->total_stock_sft;
        $stock->update();
        // FOR DELETE  STOCK PRODUCTS
        $deletefields = $request->input('deletefield');
        // dd($deletefields);
        foreach ($deletefields as $delete_id) {
            if ($delete_id != null) {
                // stockProduct::find($delete_id)->delete();
                $stockProduct = stockProduct::find($delete_id);
                $stockProduct->delete = 1;
                $stockProduct->update();
            }
        }
        // UPDATE EXISTING STOCK PRODUCTS
        $stockproducts = $request->input('stockproduct');
        $product_type = $request->input('product_type');
        $product_id = $request->input('product_id');
        $sizes = $request->input('size');
        $total_farmas = $request->input('total_farma');
        $quantity_sfts = $request->input('quantity_sft');
        foreach ($stockproducts as $index => $stockproduct) {
            // dd($stockproduct);
            $stock_product = stockProduct::find($stockproduct);
            // dd($stock_product);
            $previous_qty = $stock_product->quentity_sft;
            // dd($previous_qty);
            $stock_product->product_type = $product_type[$index];
            $stock_product->product_id = $product_id[$index];
            $stock_product->size_id = $sizes[$index];
            $stock_product->total_farma = $total_farmas[$index];
            $stock_product->quentity_sft = $quantity_sfts[$index];
            $stock_product->update();
            $editstock =  updateCurrentStock('add', 'Chemical Tiles', $product_id[$index], $sizes[$index], $previous_qty, $quantity_sfts[$index]);
        }
        // ADD NEW PRODUCTS IN STOCK
        if ($request->productCount != 0) {

            $newproduct_type = $request->input('newproduct_type');
            $newproduct_id = $request->input('newproduct_id');
            $newsizes = $request->input('newsize');
            $newquantity_sfts = $request->input('newquantity_sft');
            $newtotal_farmas = $request->input('newtotal_farma');

            foreach ($newsizes as $index => $size) {
                $data[] = [
                    'stock_id' => $id,
                    'product_type' => $newproduct_type[$index],
                    'product_id' => $newproduct_id[$index],
                    'size_id' => $size,
                    'quentity_sft' => $newquantity_sfts[$index],
                    'total_farma' => $newtotal_farmas[$index],
                ];
                // $editstock =  updateCurrentStock('add', 'Chemical Tiles', $newproduct_id[$index], $sizes[$index], 0, $newquantity_sfts[$index]);
                addCurrentStock('Chemical Tiles', $newproduct_type[$index], $newproduct_id[$index], $sizes[$index], $newquantity_sfts[$index]);
            }
            foreach ($data as $value) {
                stockProduct::create($value);
            }
        }
        return redirect()->route('chemicalTiles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function softDelete(string $id)
    {
        $stock =  stock::find($id);
        $stock->delete = 1;
        $stock->update();
        $stockProduct = stockProduct::where('product_id', $id);
        // $stockProduct->delete = 1;
        $stockProduct->update(['delete' => 1]);
        return redirect()->route('chemicalTiles.index');
    }
    public function destroy(string $id)
    {
        stock::find($id)->delete();
        stockProduct::where('stock_id', $id)->delete();
        return redirect()->route('chemicalTiles.index');
    }
}
