<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\stock;
use App\Models\Dispatch;
use App\Models\Product;
use App\Models\productSize;
use Illuminate\Support\Carbon;

class inOutSummeryController extends Controller
{
    public function tufftilesInOutSummery(Request $request)
    {

        $query = stock::query();
        $currentDateTime = Carbon::now();
        $Date = $currentDateTime->format('Y-m-d');
        $query->where('category', 'Tuff Tiles');
        if ($request->isMethod('POST')) {
            // dump($request);
            if (!empty($request->all())) {
                $filter = $request->all();
                if ($filter['from_date'] != null && $filter['to_date'] != null) {
                    $query->whereBetween('date', [$filter['from_date'], $filter['to_date']]);
                } elseif ($filter['from_date'] != null && $filter['to_date'] == null) {
                    $query->whereBetween('date', [$filter['from_date'], $Date]);
                } elseif ($filter['from_date'] == null && $filter['to_date'] != null) {
                    $query->where('date', '<=', $filter['to_date']);
                } else {
                    $query->where('date', $Date);
                }
                if (!empty($filter['product_id'])) {
                    $query->whereHas('products', function ($subQuery) use ($filter) {
                        $subQuery->where('product_id', $filter['product_id']);
                    });
                }
                if (!empty($filter['size'])) {
                    $query->whereHas('products', function ($subQuery) use ($filter) {
                        $subQuery->where('size_id', $filter['size']);
                    });
                }
            } else {
                $query->where('date', $Date);
                $filter = null;
            }
        } else {
            $query->where('date', $Date);
            $filter = null;
        }
        $stocks = $query->with(['products' => function ($productQuery) use ($filter) {
            if (!empty($filter['product_id'])) {
                $productQuery->where('product_id', $filter['product_id']);
            }
            if (!empty($filter['size_id'])) {
                $productQuery->where('size_id', $filter['size_id']);
            }
        }])->get();
        $ProductSummery = selectTotalStock($stocks);
        // Dispatch total stock
        $dispatchQuery = Dispatch::query();

        $dispatchQuery->where('category', 'Tuff Tiles');
        if ($request->isMethod('POST')) {
            // dump($request);
            if (!empty($request->all())) {
                $filter = $request->all();
                if ($filter['from_date'] != null && $filter['to_date'] != null) {
                    $dispatchQuery->whereBetween('date', [$filter['from_date'], $filter['to_date']]);
                } elseif ($filter['from_date'] != null && $filter['to_date'] == null) {
                    $dispatchQuery->whereBetween('date', [$filter['from_date'], $Date]);
                } elseif ($filter['from_date'] == null && $filter['to_date'] != null) {
                    $dispatchQuery->where('date', '<=', $filter['to_date']);
                } else {
                    $dispatchQuery->where('date', $Date);
                }
                if (!empty($filter['product_id'])) {
                    $dispatchQuery->whereHas('products', function ($subQuery) use ($filter) {
                        $subQuery->where('product_id', $filter['product_id']);
                    });
                }
                if (!empty($filter['size'])) {
                    $query->whereHas('products', function ($subQuery) use ($filter) {
                        $subQuery->where('size_id', $filter['size']);
                    });
                }
            } else {
                $query->where('date', $Date);
                $filter = null;
            }
        } else {
            $dispatchQuery->where('date', $Date);
            $filter = null;
        }
        $dispatchs = $dispatchQuery->with(['products'])->get();
        $dispatchProductSummery = selectTotalDispatch($dispatchs);
        $products = Product::where('category', 'Tuff Tiles')->get();
        $sizes = productSize::all();

        return view('stock.tuffTiles.inOutSummery', compact('sizes', 'products', 'ProductSummery', 'dispatchProductSummery', 'filter'));
    }
    public function chemicaltilesInOutSummery(Request $request)
    {

        $query = stock::query();
        $currentDateTime = Carbon::now();
        $Date = $currentDateTime->format('Y-m-d');
        $query->where('category', 'Chemical Tiles');
        if ($request->isMethod('POST')) {
            // dump($request);
            if (!empty($request->all())) {
                $filter = $request->all();
                if ($filter['from_date'] != null && $filter['to_date'] != null) {
                    $query->whereBetween('date', [$filter['from_date'], $filter['to_date']]);
                } elseif ($filter['from_date'] != null && $filter['to_date'] == null) {
                    $query->whereBetween('date', [$filter['from_date'], $Date]);
                } elseif ($filter['from_date'] == null && $filter['to_date'] != null) {
                    $query->where('date', '<=', $filter['to_date']);
                } else {
                    $query->where('date', $Date);
                }
                if (!empty($filter['product_id'])) {
                    $query->whereHas('products', function ($subQuery) use ($filter) {
                        $subQuery->where('product_id', $filter['product_id']);
                    });
                }
                if (!empty($filter['size'])) {
                    $query->whereHas('products', function ($subQuery) use ($filter) {
                        $subQuery->where('size_id', $filter['size']);
                    });
                }
            } else {
                $query->where('date', $Date);
                $filter = null;
            }
        } else {
            $query->where('date', $Date);
            $filter = null;
        }
        $stocks = $query->with(['products' => function ($productQuery) use ($filter) {
            if (!empty($filter['product_id'])) {
                $productQuery->where('product_id', $filter['product_id']);
            }
            if (!empty($filter['size_id'])) {
                $productQuery->where('size_id', $filter['size_id']);
            }
        }])->get();
        $ProductSummery = selectTotalStock($stocks);
        // Dispatch total stock
        $dispatchQuery = Dispatch::query();

        $dispatchQuery->where('category', 'Chemical Tiles');
        if ($request->isMethod('POST')) {
            // dump($request);
            if (!empty($request->all())) {
                $filter = $request->all();
                if ($filter['from_date'] != null && $filter['to_date'] != null) {
                    $dispatchQuery->whereBetween('date', [$filter['from_date'], $filter['to_date']]);
                } elseif ($filter['from_date'] != null && $filter['to_date'] == null) {
                    $dispatchQuery->whereBetween('date', [$filter['from_date'], $Date]);
                } elseif ($filter['from_date'] == null && $filter['to_date'] != null) {
                    $dispatchQuery->where('date', '<=', $filter['to_date']);
                } else {
                    $dispatchQuery->where('date', $Date);
                }
                if (!empty($filter['product_id'])) {
                    $dispatchQuery->whereHas('products', function ($subQuery) use ($filter) {
                        $subQuery->where('product_id', $filter['product_id']);
                    });
                }
                if (!empty($filter['size'])) {
                    $query->whereHas('products', function ($subQuery) use ($filter) {
                        $subQuery->where('size_id', $filter['size']);
                    });
                }
            } else {
                $query->where('date', $Date);
                $filter = null;
            }
        } else {
            $dispatchQuery->where('date', $Date);
            $filter = null;
        }
        $dispatchs = $dispatchQuery->with(['products'])->get();
        $dispatchProductSummery = selectTotalDispatch($dispatchs);
        $products = Product::where('category', 'Chemical Tiles')->get();
        $sizes = productSize::all();

        return view('stock.ChemicalConcert.inOutSummery', compact('filter', 'sizes', 'products', 'ProductSummery', 'dispatchProductSummery'));
    }
}
