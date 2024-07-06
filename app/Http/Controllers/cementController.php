<?php

namespace App\Http\Controllers;

use App\Models\cementDetail;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class cementController extends Controller
{

    // current stock cement
    public function curentCement()
    {
        return view('rawMaterial.Cement.currentStock');
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
            $filter = null;
        }
        $cements = $query->get();
        $totalQuantity = $cements->sum('quantity');
        $totalPrice = $cements->sum('total_price');;
        // fetch seller_name
        $SellerNames = cementDetail::select('seller_name')->get();
        // dd($SellerNames);
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