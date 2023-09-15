<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\customer;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

use App\Models\invoice;
use App\Models\Dispatch;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $customers = customer::all();
        $query = invoice::query();
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
            if ($filter['customer_id']) {
                $query->where('customer_id',   $filter['customer_id']);
            }
        } else {
            $filter = null;
        }
        $invoices = $query->get();
        return view('invoice.index', compact('customers', 'invoices', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = customer::all();
        return view('invoice.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $currentDateTime = Carbon::now();
        $Date = $currentDateTime->format('Y-m-d');
        $customer_id = $request->customer_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $dispatches = Dispatch::with('products')->where('customer_id', $customer_id)
            ->whereBetween('date', [$from_date, $to_date])->get();
        $totalAmount = calculateTotalAmount($dispatches);
        $invoice = new invoice();
        $invoice->invoice_no = $request->invoice_no;
        $invoice->date = $Date;
        $invoice->from_date = $from_date;
        $invoice->to_date = $to_date;
        $invoice->customer_id = $customer_id;
        $invoice->total_price = $totalAmount;
        $invoice->save();
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
        return view('invoice.edit');
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