<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Models\gravelSand;
use Illuminate\Validation\Rule;

class sandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = gravelSand::query();
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
            if ($filter['material_type']) {
                $query->where('material_type',   $filter['material_type']);
            }
            if ($filter['seller_name']) {
                $query->where('seller_name',   $filter['seller_name']);
            }
        } else {
            $filter = null;
        }
        $gravleSands = $query->get();
        $sellerNames = getSellerNames();
        $materialTypes = getMaterialTypes();

        return view('rawMaterial.gravelSand.index', compact('gravleSands',  'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sellerNames = getSellerNames();
        $materialTypes = getMaterialTypes();
        return view('rawMaterial.gravelSand.create', compact('materialTypes', 'sellerNames'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $sellerNames = getSellerNames();
        $materialTypes = getMaterialTypes();
        // dd($materialTypes);
        $request->validate([
            'date' => 'required',
            'vehicle_no' => 'required|max:255',
            'bilti_no' => 'required|max:255',
            'material_type' => ['required', Rule::in($materialTypes)],
            'length' => 'required',
            'width' => 'required',
            'height' => 'required',
            'seller_name' => ['required',Rule::in($sellerNames)],
            'total_measeurement' => 'required',
        ]);

        $gravelSand = new gravelSand();
        $gravelSand->date = $request->date;
        $gravelSand->vehicle_no = $request->vehicle_no;
        $gravelSand->bilti_no = $request->bilti_no;
        $gravelSand->material_type = $request->material_type;
        $gravelSand->length = $request->length;
        $gravelSand->width = $request->width;
        $gravelSand->height = $request->height;
        $gravelSand->seller_name = $request->seller_name;
        $gravelSand->total_measeurement = $request->total_measeurement;
        $gravelSand->save();
        return redirect()->back()->with('success', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sellerNames = getSellerNames();
        $materialTypes = getMaterialTypes();
        $gravelSand = gravelSand::find($id);
        return view('rawMaterial.gravelSand.edit', compact('gravelSand', 'sellerNames', 'materialTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sellerNames = getSellerNames();
        $materialTypes = getMaterialTypes();
        $request->validate([
            'date' => 'required',
            'vehicle_no' => 'required|max:255',
            'bilti_no' => 'required|max:255',
            'material_type' => ['required', Rule::in($materialTypes)],
            'length' => 'required',
            'width' => 'required',
            'height' => 'required',
            'seller_name' => ['required', Rule::in($sellerNames)],
            'total_measeurement' => 'required',
        ]);

        $gravelSand =  gravelSand::find($id);
        $gravelSand->date = $request->date;
        $gravelSand->vehicle_no = $request->vehicle_no;
        $gravelSand->bilti_no = $request->bilti_no;
        $gravelSand->material_type = $request->material_type;
        $gravelSand->length = $request->length;
        $gravelSand->width = $request->width;
        $gravelSand->height = $request->height;
        $gravelSand->seller_name = $request->seller_name;
        $gravelSand->total_measeurement = $request->total_measeurement;
        $gravelSand->update();
        return redirect()->route('gravelSand.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        gravelSand::find($id)->delete();
        return redirect()->back();
    }
}