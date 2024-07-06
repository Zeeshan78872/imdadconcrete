<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\customer;
use App\Models\Dispatch;
use App\Models\DispatchProduc;

use Illuminate\Support\Carbon;

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
                if ($filter['customer_id'] != null) {
                    $query->where('customer_id',  $filter['customer_id']);
                }
                if (!empty($filter['area'])) {
                    $query->where('area', 'Like', '%' . $filter['area'] . '%');
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
        $dispatches = $query->with(['customers', 'products' => function ($productQuery) use ($filter) {
            if (!empty($filter['product_id'])) {
                $productQuery->where('product_id', $filter['product_id']);
            }
            if (!empty($filter['size_id'])) {
                $productQuery->where('size_id', $filter['size_id']);
            }
        }])->OrderBy('date', 'DESC')->get();
        $products = Product::where('category', 'Tuff Tiles')->get();
        $Dispatch = Dispatch::with('customers')->get();
        // dd($filter);
        $CustomerSummery = [];
        $OverallStock = 0;
        foreach ($dispatches as $dispatch) {
            $TotalStocked = 0;
            foreach ($dispatch->products as $product) {
                $TotalStocked += $product->total_tiles_sft;
            }
            $CustomerSummery += [
                [
                    'customer_name' => $dispatch->customers->customer_name,
                    'TotalStocked' => $TotalStocked
                ]
            ];
            $OverallStock += $TotalStocked;
        }
        // dd($CustomerSummery);
        return view('DiapatchStock.ChemicalTiles.index', compact(
            'dispatches',
            'products',
            'filter',
            'Dispatch', // all dispatch without filter
            'CustomerSummery', // all customer summery
            'OverallStock' // Grand Total Stock customer wise
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = customer::all();
        $products = Product::where('category', 'Chemical Tiles')->get();
        return view('DiapatchStock.ChemicalTiles.create', compact(
            'customers',
            'products'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'biltiNo'     =>  ['required'],
            'date'        => ['required'],
            'customer_id' => ['required'],
            'destination_city' => ['required'],
            'vehicle_type' => ['required'],
            'vehicle_no'   => ['required'],
            // multiple field
            'product_id.*'   => ['required'],
            'size.*'         => ['required'],
            'sft_ratio.*'    => ['required'],
            'total_tiles.*'  => ['required'],
            'red_qty.*'      => ['required'],
            'grey_qty.*'     => ['required'],
            'black_qty.*'     => ['required'],
            'yellow_qty.*'     => ['required'],
            'white_qty.*'     => ['required'],
            'tile_sft.*'     => ['required'],
            'price_sft.*'   => ['required'],
            'price_total.*' => ['required']
        ]);
        // dd($request);
        $Dispatch  = new Dispatch();
        $Dispatch->category = 'Chemical Tiles';
        $Dispatch->bilti_no = $request->biltiNo;
        $Dispatch->date = $request->date;
        $Dispatch->customer_id = $request->customer_id;
        $Dispatch->area = $request->destination_city;
        $Dispatch->vehicle_type = $request->vehicle_type;
        $Dispatch->vehicle_number = $request->vehicle_no;
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
        //
    }
}