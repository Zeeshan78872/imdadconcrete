<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\customer;

class customerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd('');
        $query = customer::query();
        $customer_names = customer::select('customer_name')->distinct()->get();
        $company_names = customer::select('company_name')->distinct()->get();
        $city_names = customer::select('city_area')->distinct()->get();
        // if($request){
        //     dd($request);
        // }
        if ($request->isMethod('POST')) {
        // dd($request);
            $filter = $request->all();
            if ($filter['customer_name']) {
                $query->where('customer_name',   $filter['customer_name'] );
            }
            if ($filter['company_name']) {
                $query->where('company_name', $filter['company_name']);
            }
            if ($filter['city']) {
                $query->where('city_area', $filter['city']);
            }
        } else {
            $filter = null;
        }

        // Get the filtered customers or all customers if no filtering
        $customers = $query->get();

        return view('customer.ViewCustomer', compact('customers', 'customer_names', 'company_names', 'city_names', 'filter'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customer.AddCustomer');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'customer_name' => 'required',
            'company_name' => 'required',
            'city_area' => 'required',
            'phone_number_1' => 'required',
        ]);
        $customer = new customer();
        $customer->customer_id = $request->customer_id;
        $customer->customer_name = $request->customer_name;
        $customer->company_name = $request->company_name;
        $customer->city_area = $request->city_area;
        $customer->phone_number_1 = $request->phone_number_1;
        $customer->phone_number_2 = $request->phone_number_2;
        $customer->save();
        return redirect()->route('customer.index');
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
        $customer = customer::find($id);
        return view('customer.edit',compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = $request->validate([
            'customer_name' => 'required',
            'company_name' => 'required',
            'city_area' => 'required',
            'phone_number_1' => 'required',
        ]);
        $customer =  customer::find($id);
        $customer->customer_id = $request->customer_id;
        $customer->customer_name = $request->customer_name;
        $customer->company_name = $request->company_name;
        $customer->city_area = $request->city_area;
        $customer->phone_number_1 = $request->phone_number_1;
        $customer->phone_number_2 = $request->phone_number_2;
        $customer->update();
        return redirect()->route('customer.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = customer::find($id)->delete();
        return redirect()->back();
    }
}