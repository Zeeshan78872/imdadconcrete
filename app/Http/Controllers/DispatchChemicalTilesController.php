<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\customer;
use App\Models\Dispatch;
use App\Models\DispatchProduc;
use App\Models\productSize;

use Illuminate\Support\Carbon;
use App\Rules\QuantityLimit;

class DispatchChemicalTilesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Dispatch::query();
        $currentDateTime = Carbon::now();
        $Date = $currentDateTime->format('Y-m-d');
        $query->where('category', 'Chemical Tiles')->where('delete', 0);
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
                if ($filter['customer_id'] != null) {
                    $query->where('customer_id',  $filter['customer_id']);
                }
                // if (!empty($filter['area'])) {
                //     $query->where('area', 'Like', '%' . $filter['area'] . '%');
                // }
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
                $filter['from_date'] = $Date;
                $filter['to_date'] = $Date;
            }
        } else {
            $query->where('date', $Date);
            $filter = null;
            $filter = null;
            $filter['from_date'] = $Date;
            $filter['to_date'] = $Date;
        }
        $dispatches = $query->with(['customers', 'products' => function ($productQuery) use ($filter) {
            if (!empty($filter['product_id'])) {
                $productQuery->where('product_id', $filter['product_id']);
            }
            if (!empty($filter['size_id'])) {
                $productQuery->where('size_id', $filter['size_id']);
            }
            $productQuery->where('delete', 0);
        }])
            ->OrderBy('id', 'ASC')
            ->get();
        // dd($dispatches);
        $products = Product::where('category', 'Chemical Tiles')->where('delete', 0)->get();
        $Dispatch = Dispatch::with('customers')->get();
        $customersummery = $dispatches->groupBy('customer_id')
            ->map(function ($group) {
                return [
                    'customer_name' => $group->first()->customers->customer_name,
                    'total_qty' => $group->pluck('products')->flatten()->sum('total_tiles_sft') // Assuming 'products' is the relationship name
                ];
            });

        $ProductSummery = [];
        // dd($stocks->toArray());
        foreach ($dispatches as $stock) {
            foreach ($stock->products as $product) {

                $productId = $product->product_id;
                if (!isset($ProductSummery[$productId])) {
                    $ProductSummery[$productId] = [
                        'overall' => '',
                        'product_id' => $product->product_id,
                        'size_id' => $product->size_id,
                        'size' => $product->mainSize->size,
                        'quantity' => $product->total_tiles_sft

                    ];
                } else {

                    if ($ProductSummery[$productId]['size_id'] == $product->size_id) {
                        $sumSize = $ProductSummery[$productId]['quantity'] + $product->total_tiles_sft;
                        $ProductSummery[$productId]['quantity'] = $sumSize;
                    } else {
                        $second = [
                            'overall' => '',
                            'product_id' => $product->product_id,
                            'size_id' => $product->size_id,
                            'size' => $product->mainSize->size,
                            'quantity' => $product->total_tiles_sft
                        ];
                        $ProductSummery += $second;
                    }
                }
            }
        }

        $customers = customer::all();
        $sizes = productSize::all();

        // dd($products);
        return view('DiapatchStock.ChemicalTiles.index', compact(
            'dispatches',
            'products',
            'filter',
            'Dispatch', // all dispatch without filter
            'customersummery', // all customer summery
            'customers',
            'sizes'
        ));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = customer::all();
        $products = Product::where('category', 'Chemical Tiles')->where('delete', 0)->get();
        $sizes = productSize::where('delete', 0)->get();
        $vehicle_types = getVehicleType();

        return view('DiapatchStock.ChemicalTiles.create', compact(
            'vehicle_types',
            'sizes',
            'customers',
            'products'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'biltiNo'     =>  ['required'],
            'date'        => ['required'],
            'customer_id' => ['required'],
            'destination_city' => ['required'],
            'vehicle_type' => ['required'],
            'vehicle_no'   => ['required'],
            'contactNo1'  => ['required'],

            // multiple field
            'product_id.*'   => ['required'],
            'size.*'         => ['required'],
            'sft_ratio.*'    => ['required'],
            'total_tiles.*'  => ['required'],
            'tile_sft.*'     => ['required'],
            'price_sft.*'   => ['required'],
            'price_total.*' => ['required']
        ];
        // set rule for check current quentity for add records
        foreach ($request->input('product_id') as $index => $productId) {
            $sizeId = $request->input('size')[$index];
            $totalTiles = $request->input('tile_sft')[$index];

            $rules["tile_sft.$index"] = [
                // 'required',
                new QuantityLimit('Chemical Tiles', $productId, $sizeId, $totalTiles)
            ];
            // $customMessages = [
            //     "tile_sft.$index.required" => "Tiles in sft field is required.",
            //     // Other custom messages for specific rules if needed
            // ];
        }
        $customMessages = [
            'tile_sft.*.required' => "Tiles in sft field is required.",
            'biltiNo.required' => 'Bilti No is required',
            'date.required' => 'Date is required',
            'customer_id.required' => 'Customer name is required',
            'destination_city.required' => 'Destination city is required',
            'vehicle_type.required' => 'Vehicle type is required',
            'vehicle_no.required' => 'Vehicle no is required',
            'sft_ratio.*.required' => ' Sft  ratio is required.',
            'contactNo1.required' => 'Contact Number is required',
        ];
        $this->validate($request, $rules, $customMessages);
        // dd($request);
        $Dispatch  = new Dispatch();
        $Dispatch->category = 'Chemical Tiles';
        $Dispatch->bilti_no = $request->biltiNo;
        $Dispatch->date = $request->date;
        $Dispatch->customer_id = $request->customer_id;
        $Dispatch->area = $request->destination_city;
        $Dispatch->vehicle_type = $request->vehicle_type;
        $Dispatch->vehicle_number = $request->vehicle_no;
        $Dispatch->contactNo1 = $request->contactNo1;
        $Dispatch->contactNo2 = $request->contactNo2;
        $Dispatch->driverName = $request->driverName;
        $Dispatch->save();

        $Dispatch_id = $Dispatch->id;
        $product_id = $request->input('product_id');
        $sizes = $request->input('size');
        $sft_ratio = $request->input('sft_ratio');
        $total_tiles = $request->input('total_tiles');
        $red_qty = $request->input('red_qty');
        $grey_qty = $request->input('grey_qty');
        $black_qty = $request->input('black_qty');
        $yellow_qty = $request->input('yellow_qty');
        $white_qty = $request->input('white_qty');
        $tile_sft = $request->input('tile_sft');
        $price_sft = $request->input('price_sft');
        $price_total = $request->input('price_total');

        foreach ($sizes as $index => $size) {
            $data[] = [
                'dispatch_id' => $Dispatch_id,
                'product_id' => $product_id[$index],
                'size_id' => $size,
                'sft_ratio' => $sft_ratio[$index],
                'total_tiles' => $total_tiles[$index],
                'red_qty' => $red_qty[$index],
                'grey_qty' => $grey_qty[$index],
                'black_qty' => $black_qty[$index],
                'yellow_qty' => $yellow_qty[$index],
                'white_qty' => $white_qty[$index],
                'total_tiles_sft' => $tile_sft[$index],
                'price_sft' => $price_sft[$index],
                'total_price' => $price_total[$index],
            ];
            SubCurrentStock('Chemical Tiles', $product_id[$index], $size, $tile_sft[$index]);
        }
        foreach ($data as $value) {
            DispatchProduc::create($value);
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
        $customers = customer::all();
        $products = Product::where('category', 'Chemical Tiles')->where('delete', 0)->get();
        $dispatches = Dispatch::with(['products' => function ($productQuery) {
            $productQuery->where('delete', 0);
        }])->find($id);
        $sizes = productSize::where('delete', 0)->get();
        $vehicle_types = getVehicleType();

        return view('DiapatchStock.ChemicalTiles.edit', compact(
            'vehicle_types',
            'sizes',
            'customers',
            'products',
            'dispatches'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'biltiNo'     =>  ['required'],
            'date'        => ['required'],
            'customer_id' => ['required'],
            'destination_city' => ['required'],
            'vehicle_type' => ['required'],
            'vehicle_no'   => ['required'],
            'contactNo1'  => ['required'],

            // multiple field
            'product_id.*'   => ['required'],
            'size.*'         => ['required'],
            'sft_ratio.*'    => ['required'],
            'total_tiles.*'  => ['required'],

            'tile_sft.*'     => ['required'],
            'price_sft.*'   => ['required'],
            'price_total.*' => ['required'],
            // add new  dispatch products
            'newproduct_id.*'   => ['required'],
            'newsize.*'         => ['required'],
            'newsft_ratio.*'    => ['required'],
            'newtotal_tiles.*'  => ['required'],

            'newtile_sft.*'     => ['required'],
            'newprice_sft.*'   => ['required'],
            'newprice_total.*' => ['required']
        ];
        // set rule for check current quentity for already exist recore in stock
        foreach ($request->input('product_id') as $index => $productId) {
            $sizeId = $request->input('size')[$index];
            $totalTiles = $request->input('tile_sft')[$index];
            $customMessages = [
                "tile_sft.$index.required" => "Tiles in sft  is required.",
                // Other custom messages for specific rules if needed
            ];

            $rules["tile_sft.$index"] = [
                'required',
                new QuantityLimit('Chemical Tiles', $productId, $sizeId, $totalTiles)
            ];
        }
        if ($request->productCount > 0) {
            // set rule for check current quentity for add record
            foreach ($request->input('newproduct_id') as $index => $productId) {
                $sizeId = $request->input('newsize')[$index];
                $totalTiles = $request->input('newtile_sft')[$index];
                $rules["newtile_sft.$index"] = [
                    // 'required',
                    new QuantityLimit('Chemical Tiles', $productId, $sizeId, $totalTiles)
                ];
                $customMessages = [
                    "newtile_sft.$index.required" => "Tiles in sft is required.",
                    // Other custom messages for specific rules if needed
                ];
            }
        }
        $customMessages = [
            'biltiNo.required' => 'Bilti No is required',
            'date.required' => 'Date is required',
            'customer_id.required' => 'Customer name is required',
            'destination_city.required' => 'Destination city is required',
            'vehicle_type.required' => 'Vehicle type is required',
            'vehicle_no.required' => 'Vehicle no is required',
            'contactNo1.required' => 'Contact Number is required',

        ];
        $this->validate($request, $rules, $customMessages);
        // dd($request);
        // UPDATE EXISTING DISPATCH PRODUCTT
        $dispatch = Dispatch::find($id);
        $dispatch->date = $request->date;
        $dispatch->customer_id = $request->customer_id;
        $dispatch->area = $request->destination_city;
        $dispatch->vehicle_type = $request->vehicle_type;
        $dispatch->vehicle_number = $request->vehicle_no;
        $dispatch->contactNo1 = $request->contactNo1;
        $dispatch->contactNo2 = $request->contactNo2;
        $dispatch->driverName = $request->driverName;
        $dispatch->update();

        //   ALL PRODUCT EXISTING UPDATE
        $stockproducts = $request->input('stockproduct');

        $product_id = $request->input('product_id');
        $sizes = $request->input('size');
        $sft_ratio = $request->input('sft_ratio');
        $total_tiles = $request->input('total_tiles');
        $red_qty = $request->input('red_qty');
        $grey_qty = $request->input('grey_qty');
        $black_qty = $request->input('black_qty');
        $yellow_qty = $request->input('yellow_qty');
        $white_qty = $request->input('white_qty');
        $tile_sft = $request->input('tile_sft');
        $price_sft = $request->input('price_sft');
        $price_total = $request->input('price_total');

        foreach ($stockproducts as $index => $stockproduct) {
            $dispatchProduct = DispatchProduc::find($stockproduct);
            $previous_qty = $dispatchProduct->total_tiles_sft;
            // dd($tile_sft[$index]);
            $dispatchProduct->product_id = $product_id[$index];
            $dispatchProduct->size_id = $sizes[$index];
            $dispatchProduct->sft_ratio = $sft_ratio[$index];
            $dispatchProduct->total_tiles = $total_tiles[$index];
            $dispatchProduct->red_qty = $red_qty[$index];
            $dispatchProduct->grey_qty = $grey_qty[$index];
            $dispatchProduct->black_qty = $black_qty[$index];
            $dispatchProduct->yellow_qty = $yellow_qty[$index];
            $dispatchProduct->white_qty = $white_qty[$index];
            $dispatchProduct->total_tiles_sft = $tile_sft[$index];
            $dispatchProduct->price_sft = $price_sft[$index];
            $dispatchProduct->total_price = $price_total[$index];
            $dispatchProduct->update();
            updateCurrentStock('sub', 'Chemical Tiles', $product_id[$index], $sizes[$index], $previous_qty, $tile_sft[$index]);
        }
        // Add New dispatch products
        $newproduct_id = $request->input('newproduct_id');
        $newsizes = $request->input('newsize');
        $newsft_ratio = $request->input('newsft_ratio');
        $newtotal_tiles = $request->input('newtotal_tiles');
        $newred_qty = $request->input('newred_qty');
        $newgrey_qty = $request->input('newgrey_qty');
        $newblack_qty = $request->input('newblack_qty');
        $newyellow_qty = $request->input('newyellow_qty');
        $newwhite_qty = $request->input('newwhite_qty');
        $newtile_sft = $request->input('newtile_sft');
        $newprice_sft = $request->input('newprice_sft');
        $newprice_total = $request->input('newprice_total');
        if (
            empty($newproduct_id) ||
            empty($newsizes) ||
            empty($newsft_ratio) ||
            empty($newtotal_tiles) ||
            empty($newred_qty) ||
            empty($newgrey_qty) ||
            empty($newtile_sft) ||
            empty($newprice_sft) ||
            empty($newprice_total)
        ) {
        } else {
            foreach ($newsizes as $index => $size) {
                $data[] = [
                    'dispatch_id' => $id,
                    'product_id' => $newproduct_id[$index],
                    'size_id' => $size,
                    'sft_ratio' => $newsft_ratio[$index],
                    'total_tiles' => $newtotal_tiles[$index],
                    'red_qty' => $newred_qty[$index],
                    'grey_qty' => $newgrey_qty[$index],
                    'black_qty' => $newblack_qty[$index],
                    'yellow_qty' => $newyellow_qty[$index],
                    'white_qty' => $newwhite_qty[$index],
                    'total_tiles_sft' => $newtile_sft[$index],
                    'price_sft' => $newprice_sft[$index],
                    'total_price' => $newprice_total[$index],
                ];
                // updateCurrentStock('Addsub', 'Chemical Tiles', $newproduct_id[$index], $size, 0, $newtile_sft[$index]);
                SubCurrentStock('Chemical Tiles', $newproduct_id[$index], $size, $newtile_sft[$index]);
            }
            foreach ($data as $value) {
                DispatchProduc::create($value);
            }
        }
        // FOR DELETE  STOCK PRODUCTS
        $deletefields = $request->input('deletefield');
        // dd($deletefields);
        foreach ($deletefields as $delete_id) {
            if ($delete_id != null) {
                // DispatchProduc::find($delete_id)->delete();
                $DispatchProduc = DispatchProduc::find($delete_id);
                $DispatchProduc->delete = 1;
                $DispatchProduc->update();
            }
        }
        return redirect()->route('DchemicalTiles.index');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function softDelete(string $id)
    {
        $Dispatch =  Dispatch::find($id);
        $Dispatch->delete = 1;
        $Dispatch->update();
        $DispatchProduc = DispatchProduc::where('product_id', $id);
        // $DispatchProduc->delete = 1;
        $DispatchProduc->update(['delete' => 1]);
        return redirect()->back();
    }
    public function destroy(string $id)
    {
        Dispatch::find($id)->delete();
        DispatchProduc::where('dispatch_id', $id)->delete();
        return redirect()->route('DchemicalTiles.index');
    }
}
