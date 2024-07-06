<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\customer;
use App\Models\payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class paymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = payment::query();
        if ($request->isMethod('POST')) {
            // dd($request);
            $filter = $request->all();
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
            if ($filter['customer_name']) {
                $query->where('customer_name',   $filter['customer_name']);
            }
            if ($filter['deposit_bank_name']) {
                $query->where('deposit_bank_name', $filter['deposit_bank_name']);
            }
            if ($filter['amount_reveived']) {
                $query->where('amount_reveived', $filter['amount_reveived']);
            }
        } else {
            $filter = null;
        }
        $payments = $query->get();
        // dd($payments);
        // Group the payments by customer_name
        $paymentCustomer = $payments->groupBy('customer_name')
            ->map(function ($group) {
                return [
                    'customer_name' => $group->first()->customer_name,
                    'amount_reveived' => $group->sum('amount_reveived')
                ];
            });
        // dd($paymentCustomer);
        // Group the payments by deposit_bank_name
        $paymentBank = $payments->groupBy('deposit_bank_name')
            ->map(function ($group) {
                return [
                    'deposit_bank_name' => $group->first()->deposit_bank_name,
                    'amount_reveived' => $group->sum('amount_reveived')
                ];
            });
        // dd($paymentBank);
        // Calculate the total payment amount
        $TotalPayment = 0;
        foreach ($paymentBank as $payment) {
            $TotalPayment += $payment['amount_reveived'];
        }
        // dd($TotalPayment);
        // fetch customer
        $customerNames = customer::select('customer_name')->get();
        $DepositBank = getDepositBank();


        return view('payment.viewPayment', compact('payments', 'customerNames', 'paymentCustomer', 'paymentBank', 'TotalPayment', 'filter', 'DepositBank'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $DepositBank = getDepositBank();
        $customerNames = customer::select('customer_name')->get();
        return view('payment.addPayment', compact('customerNames', 'DepositBank'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $DepositBank = getDepositBank();
        $validator = $request->validate([
            'date' => 'required',
            'customer_name' => 'exists:customers,customer_name',
            'deposit_bank_name' => ['required', Rule::in($DepositBank)],
            'amount_reveived' => 'required',
        ]);
        $payment = new payment();
        $payment->payment_id = $request->payment_id;
        $payment->date = $request->date;
        $payment->customer_name = $request->customer_name;
        $payment->company_name = $request->company_name;
        $payment->deposit_bank_name = $request->deposit_bank_name;
        $payment->amount_reveived = $request->amount_reveived;
        $payment->save();
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
        $DepositBank = getDepositBank();
        $customerNames = customer::select('customer_name')->get();
        $payments = payment::find($id);
        return view('payment.edit', compact('payments', 'customerNames', 'DepositBank'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $DepositBank = getDepositBank();
        $validator = $request->validate([
            'date' => 'required',
            'customer_name' => 'exists:customers,customer_name',
            'deposit_bank_name' => ['required', Rule::in($DepositBank)],
            'amount_reveived' => 'required',
        ]);
        $payment = payment::find($id);
        $payment->payment_id = $request->payment_id;
        $payment->date = $request->date;
        $payment->customer_name = $request->customer_name;
        $payment->company_name = $request->company_name;
        $payment->deposit_bank_name = $request->deposit_bank_name;
        $payment->amount_reveived = $request->amount_reveived;
        $payment->update();
        return redirect()->route('payment.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $payment = payment::find($id)->delete();
        return redirect()->back();
    }
}