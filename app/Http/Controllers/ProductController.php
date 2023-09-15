<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\productSize;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['sizes' => function ($productQuery) {
            $productQuery->where('delete', 0);
        }])->where('delete', 0)->orderBy('id', 'desc')->get();
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
            'name'    => ['required', Rule::unique('products', 'name')->ignore(1, 'delete')],
            'product_type' => ['required_if:category,Chemical Tiles'],
            'height_type' => ['required_if:category,Chemical Tiles'],

            'size.*'           => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'sft.*'            => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'quantity_farms.*' => ['required_if:category,Chemical Tiles'],
            'total_Farms.*'    => ['required_if:category,Chemical Tiles'],
        ], [
            'category.required' => 'Product  Category is required',
            'name.required' => 'Product Name is required',
            'name.unique' => 'Product Name already exists',
            'product_type.required_if' => 'Product Type is required',
            'height_type.required_if' => 'Height Type is required',

            'size.*.required' => 'Product Size  is required.',
            'size.*.numeric' => 'Product Size  is number or float.',
            'size.*.regex' => 'Product Size  is number or float.',
            'sft.*.required' => ' Sft  Ratio is required.',
            'sft.*.numeric' => ' Sft Ratio   is number or float.',
            'sft.*.regex' => ' Sft Ratio   is number or float',
            'quantity_farms.*.required_if' => ' Quantity / farms  is required',
            'total_Farms.*.required_if' => ' Total farms  is required',
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
        $products = Product::with(['sizes' => function ($productQuery) {
            $productQuery->where('delete', 0);
        }])->find($id);
        return view('product.edit', compact('products'));
    }
    /**
     * Update the specified resource in storage.
     */
    // fetch product name against product type
    public function fetchproductName($product_type)
    {
        $productnames = Product::where('product_type', $product_type)->get();
        return response()->json($productnames);
    }
    public function fetchQuantity($id)
    {
        $quantity = productSize::find($id);
        return response()->json($quantity);
    }
    public function fetchSize($id)
    {
        $sizes = productSize::where('product_id', $id)->where('delete', 0)->get();
        return response()->json($sizes);
    }

    public function update(Request $request, string $id)
    {
        $product_ignore =  Product::find($id);
        $rules = [
            'category' => ['required'],
            'name' => ['required', Rule::unique('products', 'name')->ignore($product_ignore->id),],
            'product_type' => ['required_if:category,Chemical Tiles'],
            'height_type' => ['required_if:category,Chemical Tiles'],

            'newsize.*' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'newsft.*' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'newquantity_farms.*' => ['required_if:category,Chemical Tiles'],
            'newtotal_Farms.*' => ['required_if:category,Chemical Tiles'],
        ];
        $customeMessage = [
            'category.required' => 'Category is required',
            'name.required' => 'Product Name is required',
            'name.unique' => 'Product Name already exists',
            'product_type.required_if' => 'Product Type is required',
            'height_type.required_if' => 'Height Type is required',

            'size.*.required' => ' size  is required.',
            'sft.*.required' => ' Sft  Ratio is required.',
            // 'sft.*.numeric' => ' Sft  ratio is number.',
            'quantity_farms.*.required_if' => ' Quantity / farms  is required',
            'total_Farms.*.required_if' => ' Total farms  is required',

            'newsize.*.required' => 'Product Size  is required.',
            'newsize.*.numeric' => 'Product Size  is number or float.',
            'newsize.*.regex' => 'Product Size  is number or float.',
            'newsft.*.required' => ' Sft Ratio   is required.',
            'newsft.*.numeric' => 'Product Size  is number or float.',
            'newsft.*.regex' => 'Product Size  is number or float.',
            'newquantity_farms.*.required_if' => ' Quantity / farms  is required',
            'newtotal_Farms.*.required_if' => ' Total farms  is required',
        ];
        foreach ($request->input('size') as $sizeId => $values) {
            foreach ($values as $index => $value) {
                $rules["size.{$sizeId}.{$index}"] = ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'];
                $customeMessage["size.{$sizeId}.{$index}.numeric"] = 'size  Ratio is number.';
                $customeMessage["size.{$sizeId}.{$index}.regex"] = 'size  Ratio is number or float.';
            }
        }
        foreach ($request->input('sft') as $sizeId => $values) {
            foreach ($values as $index => $value) {
                $rules["sft.{$sizeId}.{$index}"] = ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'];
                $customeMessage["sft.{$sizeId}.{$index}.numeric"] = 'Sft  Ratio is number or float.';
                $customeMessage["sft.{$sizeId}.{$index}.regex"] = 'Sft  Ratio is number or float.';
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
        // dd($customeMessage);
        $request->validate($rules, $customeMessage);
        // dd($request);
        foreach ($request->deleteSize as $size_id) {
            if ($size_id != null) {
                // productSize::find($size_id)->delete();
                $productSize = productSize::find($size_id);
                $productSize->update(['delete' => 1]);
            }
        }
        $sizes = $request->input('newsize');
        $sfts = $request->input('newsft');
        $quantity_farms = $request->input('newquantity_farms');
        $total_Farms = $request->input('newtotal_Farms');
        if ($sizes != null && $sfts != null) {
            foreach ($sizes as $index => $size) {
                $data[] = [];
                if ($request->category == 'Chemical Tiles') {
                    $data[] = [
                        'product_id' => $id,
                        'size' => $size,
                        'sft' => $sfts[$index],
                        'quantity_farma' => $quantity_farms[$index],
                        'total_farma' => $total_Farms[$index],
                    ];
                } else {
                    $data[] = [
                        'product_id' => $id,
                        'size' => $size,
                        'sft' => $sfts[$index],
                    ];
                }
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
        $record->delete = 1;
        $record->update();
        return response()->json(['message' => 'Record deleted successfully']);
    }
    public function softDelete(string $id)
    {
        $product =  Product::find($id);
        $product->delete = 1;
        $product->update(['delete' => 1]);

        $productSize = productSize::where('product_id', $id);
        $productSize->update(['delete' => 1]);

        return redirect()->back();
    }

    public function destroy(string $id)
    {
        $product =  Product::find($id)->delete();
        productSize::where('product_id', $id)->delete();
        return redirect()->back();
    }
}
