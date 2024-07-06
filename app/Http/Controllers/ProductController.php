<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\productSize;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();


        return view('product.index', compact('products'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product.create', ['productType' => 0]);
    }
    public function createWithId($id)
    {
        return view('product.create', ['productType' => $id]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function sizeCreate($product_id)
    {
        $products = Product::all();
        $bv = $products->sizes;
        return view('product.AddSize', compact('products', 'product_id'));
    }
    public function StoreSize(Request $request)
    {
        $sizes = new productSize();
        $sizes->product_id = $request->product_id;
        $sizes->size = $request->size;
        $sizes->sft = $request->sft;

        $sizes->save();
        return redirect()->route('product.index');
    }
    public function store(Request $request)
    {
        $request->validate([
            'category' => ['required'],
            'name'    => ['required'],
            'product_type' => ['required_if:category,Chemical Tiles'],
            'height_type' => ['required_if:category,Chemical Tiles'],

            'size.*'        => ['required'],
            'sft.*'         => ['required'],
            'quantity_farms.*' => ['required_if:category,Chemical Tiles'],
            'total_Farms.*' => ['required_if:category,Chemical Tiles'],
        ]);
        $product = new Product();
        $product->category = $request->category;
        $product->name = $request->name;
        if (isset($request->product_type) && isset($request->height_type)) {
            $product->product_type = $request->product_type;
            $product->height_type = $request->height_type;
        }
        $product->save();
        $product_id = $product->id;
        $sizes = $request->input('size');
        $sfts = $request->input('sft');
        $quantity_farms = $request->input('quantity_farms');
        $total_Farms = $request->input('total_Farms');
        foreach ($sizes as $index => $size) {
            $data[] = [
                'product_id' => $product_id,
                'size' => $size,
                'sft' => $sfts[$index],
                'quantity_farma' => isset($quantity_farms[$index]) ? $quantity_farms[$index] : null,
                'total_farma' => isset($total_Farms[$index]) ? $total_Farms[$index] : null
            ];
        }
        // dd($data);
        foreach ($data as $value) {
            productSize::create($value);
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
        $products = Product::find($id);
        return view('product.edit', compact('products'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function fetchQuantity($id)
    {
        $quantity = productSize::find($id);
        return response()->json($quantity);
    }
    public function fetchSize($id)
    {
        $sizes = productSize::where('product_id', $id)->get();
        return response()->json($sizes);
    }

    public function update(Request $request, string $id)
    {

        $rules = [
            'category' => ['required'],
            'name' => ['required'],
            'product_type' => ['required_if:category,Chemical Tiles'],
            'height_type' => ['required_if:category,Chemical Tiles'],

            'newsize.*' => ['required'],
            'newsft.*' => ['required'],
            'newquantity_farms.*' => ['required_if:category,Chemical Tiles'],
            'newtotal_Farms.*' => ['required_if:category,Chemical Tiles'],
        ];
        foreach ($request->input('size') as $sizeId => $values) {
            foreach ($values as $index => $value) {
                $rules["size.{$sizeId}.{$index}"] = 'required';
            }
        }
        foreach ($request->input('sft') as $sizeId => $values) {
            foreach ($values as $index => $value) {
                $rules["sft.{$sizeId}.{$index}"] = 'required';
            }
        }
        if ($request->category == 'Chemical Tiles') {
            foreach ($request->input('quantity_farms') as $sizeId => $values) {
                foreach ($values as $index => $value) {
                    $rules["quantity_farms.{$sizeId}.{$index}"] = 'required_if:category,Chemical Tiles';
                }
            }
            foreach ($request->input('total_Farms') as $sizeId => $values) {
                foreach ($values as $index => $value) {
                    $rules["total_Farms.{$sizeId}.{$index}"] = 'required_if:category,Chemical Tiles';
                }
            }
        }
        $request->validate($rules);
        // dd($request);
        foreach ($request->deleteSize as $size_id) {
            if ($size_id != null) {
                productSize::find($size_id)->delete();
            }
        }
        $sizes = $request->input('newsize');
        $sfts = $request->input('newsft');
        $quantity_farms = $request->input('newquantity_farms');
        $total_Farms = $request->input('newtotal_Farms');
        if ($sizes != null && $sfts != null) {
            foreach ($sizes as $index => $size) {
                $data[] = [
                    'product_id' => $id,
                    'size' => $size,
                    'sft' => $sfts[$index],
                    'quantity_farma' => $quantity_farms[$index],
                    'total_farma' => $total_Farms[$index],
                ];
            }
            foreach ($data as $value) {
                productSize::create($value);
            }
        }

        $product =  Product::find($id);
        $product->category = $request->category;
        $product->name = $request->name;
        if (isset($request->product_type) && isset($request->height_type)) {
            $product->product_type = $request->product_type;
            $product->height_type = $request->height_type;
        }
        $product->update();
        foreach ($request->size as $id => $size) {
            $sizes = productSize::find($id);
            $sizes->size = $size[0];
            $sizes->sft = $request->sft[$id][0];
            if (isset($request->quantity_farms)) {
                $sizes->quantity_farma = $request->quantity_farms[$id][0];
                $sizes->total_farma = $request->total_Farms[$id][0];
            }

            $sizes->update();
        }

        return redirect()->route('product.index');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function deleteSize($id)
    {
        $record = productSize::findOrFail($id);
        $record->delete();
        return response()->json(['message' => 'Record deleted successfully']);
    }
    public function destroy(string $id)
    {
        Product::find($id)->delete();
        productSize::where('product_id', $id)->delete();
        return redirect()->back();
    }
}