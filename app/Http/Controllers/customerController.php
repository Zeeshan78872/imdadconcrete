<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\customer;
use App\Models\Dispatch;
use App\Models\DispatchProduc;
use App\Models\invoice;
use App\Models\payment;

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
                $query->where('customer_name',   $filter['customer_name']);
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
            'customer_name' => 'required|unique:customers,customer_name',
            'company_name' => 'required',
            'city_area' => 'required',
            'phone_number_1' => 'required|unique:customers,phone_number_1',
        ], [
            'customer_name.required' => 'Customer Name is required',
            'customer_name.unique' => 'Customer Name must unique',
            'company_name' => 'Company Name is required',
            'city_area' => 'City Area is required',
            'phone_number_1.required' => 'Phone Number 1 is required',
            'phone_number_1.unique' => 'Phone Number 1 must unique',
        ]);
        $customer = new customer();
        $customer->customer_id = $request->customer_id;
        $customer->customer_name = $request->customer_name;
        $customer->company_name = $request->company_name;
        $customer->city_area = $request->city_area;
        $customer->phone_number_1 = $request->phone_number_1;
        $customer->phone_number_2 = $request->phone_number_2;
        $customer->save();
        return redirect()->route('customer.create')->with('success', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = customer::find($id);
        $dispatch_Tufftiles = dispatch::where('customer_id', $id)->where('category', 'Tuff Tiles')->where('delete', 0)->get();
        $dispatch_Chemicletiles = dispatch::where('customer_id', $id)->where('category', 'Chemical Tiles')->where('delete', 0)->get();
        // PAYMENT
        $payments = payment::where('customer_id', $id)->get();
        // payment report bank wise
        $paymentBank = $payments->groupBy('deposit_bank_name')
            ->map(function ($group) {
                return [
                    'deposit_bank_name' => $group->first()->deposit_bank_name,
                    'amount_reveived' => $group->sum('amount_reveived')
                ];
            });
        // Calculate the total payment amount
        $TotalPayment = 0;
        foreach ($paymentBank as $payment) {
            $TotalPayment += $payment['amount_reveived'];
        }
        // Invoice
        $invoices = invoice::where('customer_id', $id)->get();
        // Fianl Dispatch Material report

        $dispatches =  Dispatch::where('customer_id', $id)->where('delete', 0)
            ->with('products')
            ->get();
        $productTotals = [];
        $GrandTotalProduct = 0;
        $GrandTotalPrice = 0;
        foreach ($dispatches as $dispatch) {
            foreach ($dispatch->products as $product) {
                $key = $product->mainProduct->name . $product->mainSize->size;
                if (!isset($productTotals[$key])) {
                    $productTotals[$key] = [
                        'id' => $dispatch->id,
                        'date'   => $dispatch->date,
                        'biltiNo' => $dispatch->bilti_no,
                        'category' => $dispatch->category,
                        'product_name' => $product->mainProduct->name,
                        'size' => $product->mainSize->size,
                        'total' => 0,
                        'price' => 0,
                    ];
                }
                $productTotals[$key]['total'] += $product->total_tiles_sft;
                $productTotals[$key]['price'] += $product->total_price;
                $GrandTotalPrice += $product->total_price;
                $GrandTotalProduct += $product->total_tiles_sft;
            }
        }
        // dd($productTotals);
        return view(
            'customer.detailCustomer',
            compact(
                'customer',
                'dispatch_Tufftiles',
                'dispatch_Chemicletiles',
                'payments',
                'paymentBank',
                'TotalPayment', // grand total payment report amount
                'invoices',
                'productTotals', // dispatched  products
                'GrandTotalProduct',  // Grand Total of all product quantity
                'GrandTotalPrice',   //Grand total of all product Price
                'TotalPayment' //Total payment received
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = customer::find($id);
        return view('customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = $request->validate(
            [
                'customer_name' => 'required',
                'company_name' => 'required',
                'city_area' => 'required',
                'phone_number_1' => 'required',
            ],
            [
                'customer_name' => 'Customer Name is required',
                'company_name' => 'Company Name is required',
                'city_area' => 'City Area is required',
                'phone_number_1' => 'Phone Number 1 is required',
            ]
        );
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
