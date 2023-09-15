<?php

use App\Models\stockProduct;
use App\Models\Dispatch;
use App\Models\currentStock;
use App\Models\DispatchProduc;
use App\Models\productSize;

// FOR CYRRENT STOCK

function addCurrentStock($category, $product_type = null, $product_id, $size_id, $quantity)
{
    $current = currentStock::where('category', $category)
        ->where('product_id', $product_id)
        ->where('size_id', $size_id)
        ->first(); // You need to use first() to get a single instance
    if ($current) {
        $previous_qty = $current->quantity;
        $current->quantity = $quantity + $previous_qty;
        $current->update(); // Corrected method name
        return 'update successful';
    } else {
        $addnew = new currentStock();
        $addnew->product_type = $product_type;
        $addnew->category = $category;
        $addnew->product_id = $product_id;
        $addnew->size_id = $size_id;
        $addnew->quantity = $quantity;
        $addnew->save();
        return 'add successful';
    }
}

function SubCurrentStock($category, $product_id, $size_id, $quantity)
{
    $current = currentStock::where('category', $category)
        ->where('product_id', $product_id)
        ->where('size_id', $size_id)
        ->first();
    if ($current) {
        $previous_qty = $current->quantity;
        if ($quantity <= $previous_qty) {
            $current->quantity = $previous_qty - $quantity;
            $current->update(); // Corrected method name
            return [
                'status' => true,
                'current stock updated successful'
            ];
        } else {
            return [
                'status' => false,
                'Quentity is must be less then current stock'
            ];
        }
    }
}
function updateCurrentStock($type, $category, $product_id, $size_id, $previous_qty, $quantity)
{
    $current = currentStock::where('category', $category)
        ->where('product_id', $product_id)
        ->where('size_id', $size_id)
        ->first(); // You need to use first() to get a single instance
    if ($current) {
        if ($type == 'add') {
            $previous_qty = $current->quantity - $previous_qty;
            $current->quantity = $quantity + $previous_qty;
        } elseif ($type == 'sub') {
            $previous_qty = $current->quantity + $previous_qty;
            $quantity = $previous_qty - $quantity;
            $current->quantity = $quantity;
        }

        $current->update(); // Corrected method name
        return 'update successful';
    } else {
        $addnew = new currentStock();
        $addnew->category = $category;
        $addnew->product_id = $product_id;
        $addnew->size_id = $size_id;
        $addnew->quantity = $quantity;
        $addnew->save();
        return 'add successful';
    }
}
function selectCurrentStock($category, $product_type = null)
{
    $currentStock = currentStock::where('category', $category)->where('product_type', $product_type)->get();
    $currentstocks = $currentStock->groupBy('product_id')
        ->map(function ($group) {
            $sizes = $group->pluck('size_id')->unique()->toArray();
            $sizeInformation = productSize::whereIn('id', $sizes)->get();
            $quantities = $group->pluck('quantity')->unique()->toArray();
            $totalQuantity = array_sum($quantities);
            $sizeInfoMap = $sizeInformation->keyBy('id');

            $sizesWithInfo = collect($sizes)->map(function ($sizeId) use ($sizeInfoMap) {
                return $sizeInfoMap->has($sizeId) ? $sizeInfoMap->get($sizeId)->size : null;
            });

            return [
                'product_id' => $group->first()->product_id,
                'product_name' => $group->first()->products->name,
                'details' => [
                    'size' => $sizesWithInfo->toArray(),
                    'quantity' => $quantities
                ],
                'total' => $totalQuantity
            ];
        });
    // dd($currentstocks);

    $overallSum = $currentstocks->sum('total');

    return [
        'currentstocks' => $currentstocks->toArray(),
        'overallSum' => $overallSum
    ];
}
// selectTotalStock summery
function selectTotalStock($stocks)
{
    $ProductSummery = [];

    foreach ($stocks as $stock) {

        foreach ($stock->products as $product) {
            $productId = $product->product_id;
            if (!isset($ProductSummery[$productId])) {
                $ProductSummery[$productId] = [
                    'overall' => '',
                    'product_id' => $product->product_id,
                    'product_name' => $product->mainProduct->name,
                    'products' => [
                        [
                            'size_id' => $product->size_id,
                            'size' => $product->mainSize->size,
                            'quantity' => $product->total_tiles_sft
                        ]
                    ],
                ];
            } else {
                if ($ProductSummery[$productId]['products'][0]['size_id'] != $product->size_id) {
                    $ProductSummery[$productId]['products'][] = [
                        'size_id' => $product->size_id,
                        'size' => $product->mainSize->size,
                        'quantity' => $product->total_tiles_sft
                    ];
                } else {
                    $sumSize = $ProductSummery[$productId]['products'][0]['quantity'] + $product->total_tiles_sft;
                    $ProductSummery[$productId]['products'][0]['quantity'] = $sumSize;
                }
            }
        }
    }
    foreach ($ProductSummery as $key => $value) {
        $overall = 0;

        foreach ($value['products'] as $data) {
            $overall += $data['quantity'];
        }
        $ProductSummery[$key]['overall'] = $overall;
        // dump($value);
    }
    return $ProductSummery;
}
// select Total Dispatch summery
function selectTotalDispatch($dispatchs)
{
    // dispatch
    $dispatchProductSummery = [];

    foreach ($dispatchs as $stock) {

        foreach ($stock->products as $product) {
            $productId = $product->product_id;
            if (!isset($dispatchProductSummery[$productId])) {
                $dispatchProductSummery[$productId] = [
                    'overall' => '',
                    'product_id' => $product->product_id,
                    'product_name' => $product->mainProduct->name,
                    'products' => [
                        [
                            'size_id' => $product->size_id,
                            'size' => $product->mainSize->size,
                            'quantity' => $product->total_tiles_sft
                        ]
                    ],
                ];
            } else {
                if ($dispatchProductSummery[$productId]['products'][0]['size_id'] != $product->size_id) {
                    $dispatchProductSummery[$productId]['products'][] = [
                        'size_id' => $product->size_id,
                        'size' => $product->mainSize->size,
                        'quantity' => $product->total_tiles_sft
                    ];
                } else {
                    $sumSize = $dispatchProductSummery[$productId]['products'][0]['quantity'] + $product->total_tiles_sft;
                    $dispatchProductSummery[$productId]['products'][0]['quantity'] = $sumSize;
                }
            }
        }
    }
    // create total summery
    foreach ($dispatchProductSummery as $key => $value) {
        $overall = 0;
        foreach ($value['products'] as $data) {
            $overall += $data['quantity'];
        }
        $dispatchProductSummery[$key]['overall'] = $overall;
        // dump($value);
    }
    return $dispatchProductSummery;
}

// FOR CEMENT SELLER NAMES
function sellerName()
{
    return [
        'moazam'
    ];
}
// FOR USER ROLE
function getUserRole()
{
    return [
        'Moderator',
        'Manager',
        'Admin'
    ];
}
// FOR Dispatch  STOCK Vehicle type
function getVehicleType()
{
    return [
        'Company’s Tractor Trolley',
        'Outsider’s Tractor Trolley',
        'Truck (4 Wheeler)',
        'Truck (6 Wheeler)',
        'Truck (10 Wheeler)',
        'Truck (14 Wheeler)',
        'Truck (18 Wheeler)',
        'Truck (22 Wheeler)',
        'Loader Rikshaw'
    ];
}
// FOR STOCK PLANT NAMES
function getPlantName()
{
    return [
        'Plant No. 1 (Fiyaz)',
        'Plant No. 2 (Saeed)',
        'Plant No. 3 (Aladita)',
        'Plant No. 4 (Saeed Bau)',
        'Plant No. 5 (Zafar)',
        'Plant No. 6 (Sohail)'
    ];
}
// FOR STOCK PRODUCT TYPE
function getProductType()
{
    return [
        'Tuff Tile',
        'Patio & Outdoor Tile',
        'Ramp Tile',
        'Wall Tile',
        'Water Pipe & Blocks',
        'Others'
    ];
}
// FOR BANK
function getAccountCategory()
{
    return [
        'Inside Business Account',
        "Outsider’s Account",
    ];
}
function getAccountStatus()
{
    return [
        'Current Account',
        'Saving Account'
    ];
}
//  FOR Gravel and Sand
function getSellerNames()
{
    return [
        'Fareed',
        'Salman Bhaba',
        'Mureed',
        'Nadeem'
    ];
}
// For Graavel and Sand
function getMaterialTypes()
{
    return [
        'Red Sand',
        'Chanab Sand',
        'Taxila Sand',
        'Sakhi Sarwar White Sand',
        'Gravel'
    ];
}
// FOR PAYMENT
function getDepositBank()
{
    return [
        'Allied Bank',
        'Mehzan Bank'
    ];
}
//  FOR Invoice
function calculateTotalAmount($dispatches)
{
    $totalAmount = 0;
    foreach ($dispatches as $key => $value) {
        foreach ($value->products as $key => $value) {
            $totalAmount += $value->total_price;
        }
    }
    return $totalAmount;
}