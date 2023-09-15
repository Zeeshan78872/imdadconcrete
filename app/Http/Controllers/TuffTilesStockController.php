<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\stock;
use App\Models\stockProduct;
use App\Models\productSize;

use App\Rules\QuantityLimit;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade as PDF;
use Dompdf\Dompdf; // Import the Dompdf class

class TuffTilesStockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function pdfgenerate()
    {
        $currentDateTime = Carbon::now();
        $Date = $currentDateTime->format('Y-m-d');
        $stocks = stock::where('date', $Date);
        // $pdf = PDF::loadView('stock.tuffTiles.pdfgenerate', $stocks);
        $pdf = new Dompdf();
        $pdfHtml = view('stock.tuffTiles.pdfgenerate', compact('stocks'));
        $pdf->loadHtml($pdfHtml);
        $pdf->render();
        // $pdfPath = public_path('stock/' . 'stock.pdf');
        // file_put_contents($pdfPath, $pdf->output());
        $pdf->output();

        // echo $pdfContent;
    }
    public function currentStock($category)
    {
        if ($category == 'tuffTile') {
            $category = 'Tuff Tiles';
            $pageName = 'Tuff Tiles & Blocks';
        } else {
            $category = 'Chemical Tiles';
            $pageName = 'Chemical Concrete Pavers';
        }
        return view('stock.CurrentStock', compact('category', 'pageName'));
    }

    public function index(Request $request)
    {
        $query = stock::query();
        $currentDateTime = Carbon::now();
        $Date = $currentDateTime->format('Y-m-d');
        $query->where('category', 'Tuff Tiles')->where('delete', 0);
        if ($request->isMethod('POST')) {
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
                        $subQuery->where('plant_name', $filter['plant_name']);
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
            $filter['from_date'] = $Date;
            $filter['to_date'] = $Date;
        }

        $stocks = $query->with(['products' => function ($productQuery) use ($filter) {
            if (!empty($filter['plant_name'])) {
                $productQuery->where('plant_name', $filter['plant_name']);
            }
            if (!empty($filter['product_id'])) {
                $productQuery->where('product_id', $filter['product_id']);
            }
            if (!empty($filter['size_id'])) {
                $productQuery->where('size_id', $filter['size_id']);
            }
            $productQuery->where('delete', 0);
        }])
            ->OrderBy('id', 'DESC')
            ->OrderBy('date', 'DESC')
            // ->groupBy('date')
            ->get();
        $products = Product::where('category', 'Tuff Tiles')->where('delete', 0)->get();
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
        $sizes = productSize::all();

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
                'PlantName',
                'sizes'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $PlantName = getPlantName();
        $products = Product::where('category', 'Tuff Tiles')->where('delete', 0)->get();
        $sizes = productSize::where('delete', 0)->get();

        return view('stock.tuffTiles.create', compact('sizes', 'products', 'PlantName'));
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
            addCurrentStock('Tuff Tiles', null, $product_id[$index], $size, $total_tiles_sft[$index]);
        }
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
        $products = Product::where('category', 'Tuff Tiles')->where('delete', 0)->get();
        $stocks = stock::with(['products' => function ($productQuery) {
            $productQuery->where('delete', 0);
        }])->find($id);
        $sizes = productSize::where('delete', 0)->get();

        // dd($stocks);
        return view('stock.tuffTiles.edit', compact('sizes', 'stocks', 'products', 'PlantName'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $rules = [
            'plant_name.*' => ['required'],
            'product_id.*' => ['required'],
            'size.*' => ['required'],
            'cement_pack.*' => ['required'],
            'pallet_no.*' => ['required'],
            'tiles_pallet.*' => ['required'],
            'totla_tiles.*' => ['required'],

            'newplant_name.*' => ['required'],
            'newproduct_id.*' => ['required'],
            'newsize.*' => ['required'],
            'newcement_pack.*' => ['required'],
            'newpallet_no.*' => ['required'],
            'newtiles_pallet.*' => ['required'],
            'newtotla_tiles.*' => ['required', 'lt:'],
        ];
        // set rule for check current quentity for already exist recore in stock
        foreach ($request->input('product_id') as $index => $productId) {
            $sizeId = $request->input('size')[$index];
            $totalTiles = $request->input('totla_tiles')[$index];
            $customMessages = [
                "totla_tiles.$index.required" => "The total tiles field is required.",
                // Other custom messages for specific rules if needed
            ];

            $rules["totla_tiles.$index"] = [
                'required'
                // new QuantityLimit('Tuff Tiles', $productId, $sizeId, $totalTiles)
            ];
        }
        if ($request->productCount != 0) {
            // set rule for check current quentity for new add record at edit
            foreach ($request->input('newproduct_id') as $index => $productId) {
                $sizeId = $request->input('newsize')[$index];
                $totalTiles = $request->input('newtotla_tiles')[$index];
                $customMessages = [
                    "newtotla_tiles.$index.required" => "The total tiles field is required.",
                    // Other custom messages for specific rules if needed
                ];

                $rules["newtotla_tiles.$index"] = [
                    'required'
                    // new QuantityLimit('Tuff Tiles', $productId, $sizeId, $totalTiles)
                ];
            }
        }
        $this->validate($request, $rules, $customMessages);

        $stock = stock::find($id);
        $stock->date = $request->date;
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
        $plant_name = $request->input('plant_name');
        $product_id = $request->input('product_id');
        $sizes = $request->input('size');
        $cement_packs = $request->input('cement_pack');
        $no_pallets = $request->input('pallet_no');
        $tiles_pallets = $request->input('tiles_pallet');
        $total_tiles_sft = $request->input('totla_tiles');

        foreach ($stockproducts as $index => $stockproduct) {
            $stock_product = stockProduct::find($stockproduct);
            $previous_qty = $stock_product->total_tiles_sft;
            // dd($previous_qty);
            $stock_product->product_id = $product_id[$index];
            $stock_product->size_id = $sizes[$index];
            $stock_product->plant_name = $plant_name[$index];
            $stock_product->cement_packs = $cement_packs[$index];
            $stock_product->no_pallets = $no_pallets[$index];
            $stock_product->tiles_pallets = $tiles_pallets[$index];
            $stock_product->total_tiles_sft = $total_tiles_sft[$index];
            $stock_product->update();
            //  Update current stock for when edit stock
            $editstock =  updateCurrentStock('add', 'Tuff Tiles', $product_id[$index], $sizes[$index], $previous_qty, $total_tiles_sft[$index]);
            // dd($editstock);
        }
        // ADD NEW PRODUCTS IN STOCK
        if ($request->productCount != 0) {

            $newplant_name = $request->input('newplant_name');
            $newproduct_id = $request->input('newproduct_id');
            $newsizes = $request->input('newsize');
            $newcement_packs = $request->input('newcement_pack');
            $newno_pallets = $request->input('newpallet_no');
            $newtiles_pallets = $request->input('newtiles_pallet');
            $newtotal_tiles_sft = $request->input('newtotla_tiles');

            foreach ($newsizes as $index => $size) {
                $data[] = [
                    'stock_id' => $id,
                    'product_id' => $newproduct_id[$index],
                    'size_id' => $size,
                    'plant_name' => $newplant_name[$index],
                    'cement_packs' => $newcement_packs[$index],
                    'no_pallets' => $newno_pallets[$index],
                    'tiles_pallets' => $newtiles_pallets[$index],
                    'total_tiles_sft' => $newtotal_tiles_sft[$index],
                ];
                //  Update current stock for when add new product at time of edit
                updateCurrentStock('add', 'Tuff Tiles', $newproduct_id[$index], $size, 0, $newtotal_tiles_sft[$index]);
            }
            foreach ($data as $value) {
                stockProduct::create($value);
            }
        }
        return redirect()->route('tuffTile.index');
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
        return redirect()->back();
    }
    public function destroy(string $id)
    {
        stock::find($id)->delete();
        stockProduct::where('stock_id', $id)->delete();
        return redirect()->route('tuffTile.index');
    }
}
