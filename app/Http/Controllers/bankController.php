<?php

namespace App\Http\Controllers;

use App\Models\bank;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;

class bankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = bank::query();
        if ($request->isMethod('POST')) {

            $filter = $request->all();

            $currentDateTime = Carbon::now();
            $Date = $currentDateTime->format('Y-m-d');

            if ($filter['account_category']) {
                $query->where('account_category',   $filter['account_category']);
            }
        } else {
            $filter = null;
        }
        $banks = $query->get();
        $AccountCategory = getAccountCategory();

        return view('banks.index', compact('banks',  'filter', 'AccountCategory'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $AccountCategory = getAccountCategory();
        $AccountStatus = getAccountStatus();
        return view('banks.create', compact('AccountCategory', 'AccountStatus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $AccountCategory = getAccountCategory();
        $request->validate([
            'account_category' => ['required', Rule::in($AccountCategory)],
            'title_bank_name' => ['required'],
            'account_number' => ['required'],
            'account_owner' => ['required']
        ]);
        $bank = new bank();
        $bank->account_category = $request->account_category;
        $bank->title_bank_name = $request->title_bank_name;
        $bank->account_number = $request->account_number;
        $bank->city_branch_add = $request->city_branch_add;
        $bank->account_type = $request->account_type;
        $bank->status = $request->status;
        $bank->account_owner = $request->account_owner;
        $bank->save();
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
        $AccountCategory = getAccountCategory();
        $AccountStatus = getAccountStatus();
        $bank = bank::find($id);
        return view('banks.edit', compact('bank', 'AccountCategory', 'AccountStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $AccountCategory = getAccountCategory();
        $request->validate([
            'account_category' => ['required', Rule::in($AccountCategory)],
            'title_bank_name' => ['required'],
            'account_number' => ['required'],
            'account_owner' => ['required']
        ]);
        $bank = bank::find($id);
        $bank->account_category = $request->account_category;
        $bank->title_bank_name = $request->title_bank_name;
        $bank->account_number = $request->account_number;
        $bank->city_branch_add = $request->city_branch_add;
        $bank->account_type = $request->account_type;
        $bank->status = $request->status;
        $bank->account_owner = $request->account_owner;
        $bank->update();
        return redirect()->route('bank.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        bank::find($id)->delete();
        return redirect()->back();
    }
}
