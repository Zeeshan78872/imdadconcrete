<?php

namespace App\Http\Controllers;

use App\Models\cementDetail;
use App\Models\stock;
use App\Models\stockProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class cementController extends Controller
{

    // current stock cement
    public function curentCement()

    {
        $query = stock::query();
        $currentDateTime = Carbon::now();
        $Date = $currentDateTime->format('Y-m-d');

        $cementSummery = $query->with('products')->where('delete', 0)->get();

        $productTotals = [];
        foreach ($cementSummery as $stock) {
            $key = $stock->date;
            foreach ($stock->products as $product) {
                if (!isset($productTotals[$key])) {
                    $productTotals[$key] = [
                        'date'   => $stock->date,
                        'plant_1' => 0,
                        'plant_2' => 0,
                        'plant_3' => 0,
                        'plant_4' => 0,
                        'plant_5' => 0,
                        'plant_6' => 0,
                        'plant_sum' => 0,
                        'farma' => 0,
                        'grand_total' => 0
                    ];
                }
                if ($product->cement_packs != null) {
                    if ($product->plant_name == 'Plant No. 1 (Fiyaz)') {
                        $productTotals[$key]['plant_1'] += $product->cement_packs;
                    }
                    if ($product->plant_name == 'Plant No. 2 (Saeed)') {
                        $productTotals[$key]['plant_2'] += $product->cement_packs;
                    }
                    if ($product->plant_name == 'Plant No. 3 (Aladita)') {
                        $productTotals[$key]['plant_3'] += $product->cement_packs;
                    }
                    if ($product->plant_name == 'Plant No. 4 (Saeed Bau)') {
                        $productTotals[$key]['plant_4'] += $product->cement_packs;
                    }
                    if ($product->plant_name == 'Plant No. 5 (Zafar)') {
                        $productTotals[$key]['plant_5'] += $product->cement_packs;
                    }
                    if ($product->plant_name == 'Plant No. 6 (Sohail)') {
                        $productTotals[$key]['plant_6'] += $product->cement_packs;
                    }
                    $productTotals[$key]['plant_sum'] += $product->cement_packs;
                    $productTotals[$key]['grand_total'] += $product->cement_packs;
                }
                if ($stock->cement_packs != null) {
                    $productTotals[$key]['farma'] += $stock->cement_packs;
                    $productTotals[$key]['grand_total'] += $stock->cement_packs;
                }
            }
        }
        // dd($productTotals);
        return view('rawMaterial.Cement.currentStock', compact('productTotals'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = cementDetail::query();
        if ($request->isMethod('POST')) {

            $filter = $request->all();
            // dd($filter);
            $currentDateTime = Carbon::now();
            $Date = $currentDateTime->format('Y-m-d');
            // dd($filter);
            if ($filter['from_date'] != null && $filter['to_date'] == null) {
                $query->whereBetween('date', [$filter['from_date'], $Date]);
            }
            if ($filter['from_date'] == null && $filter['to_date']) {
                $query->where('date', '<=', $filter['to_date']);
            }
            if ($filter['from_date']  && $filter['to_date']) {
                $query->whereBetween('date', [$filter['from_date'], $filter['to_date']]);
            }
            if ($filter['seller_name']) {
                $query->where('seller_name',   $filter['seller_name']);
            }
        } else {
            $startDate = now()->subDays(15)->toDateString(); // Calculate the start date
            $endDate = now()->toDateString();
            // dd($endDate);
            $query->whereBetween('date', [$startDate, $endDate]);

            $startDate = now()->subDays(15)->toDateString(); // Calculate the start date
            $endDate = now()->toDateString();
            $query->whereBetween('date', [$startDate, $endDate]);
            $filter = null;
            $filter['from_date'] = $startDate;
            $filter['to_date'] = $endDate;
        }
        $cements = $query->orderBy('id', 'desc')->get();
        $totalQuantity = $cements->sum('quantity');
        $totalPrice = $cements->sum('total_price');;
        // fetch seller_name
        $SellerNames = sellerName();
        return view('rawMaterial.Cement.index', compact('cements', 'SellerNames', 'filter', 'totalQuantity', 'totalPrice'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rawMaterial.Cement.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'seller_name' => 'required|max:255',
            'cement_company' => 'required',
            'quantity' => 'required',
            'price_pack' => 'required',
            'total_price' => 'required',
        ], [
            'date.required' => 'Date is required',
            'seller_name.required' => 'Seller Name is required',
            'cement_company.required' => 'Cement Company is required',
            'quantity.required' => 'Quantity of Cement Packs is required',
            'price_pack.required' => 'Price for Single Pack is required',
            'total_price.required' => 'Total Price is required',
        ]);
        $cement =  new  cementDetail();
        $cement->date = $request->date;
        $cement->seller_name = $request->seller_name;
        $cement->quantity = $request->quantity;
        $cement->cement_company = $request->cement_company;
        $cement->price_pack = $request->price_pack;
        $cement->total_price = $request->total_price;
        $cement->save();
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
        $cements = cementDetail::find($id);
        return view('rawMaterial.Cement.edit', compact('cements'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'date' => 'required',
            'seller_name' => 'required|max:255',
            'cement_company' => 'required',
            'quantity' => 'required',
            'price_pack' => 'required',
            'total_price' => 'required',
        ], [
            'date.required' => 'Date is required',
            'seller_name.required' => 'Seller Name is required',
            'cement_company.required' => 'Cement Company is required',
            'quantity.required' => 'Quantity of Cement Packs is required',
            'price_pack.required' => 'Price for Single Pack is required',
            'total_price.required' => 'Total Price is required',
        ]);
        $cement =  cementDetail::find($id);
        $cement->date = $request->date;
        $cement->seller_name = $request->seller_name;
        $cement->quantity = $request->quantity;
        $cement->cement_company = $request->cement_company;
        $cement->price_pack = $request->price_pack;
        $cement->total_price = $request->total_price;
        $cement->update();
        return redirect()->route('cement.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        cementDetail::find($id)->delete();
        return redirect()->back();
    }
}
