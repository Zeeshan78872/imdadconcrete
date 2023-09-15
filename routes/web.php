<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\customerController;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\TuffTilesStockController;
use App\Http\Controllers\chemicalTilesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DispatchTuffTilesController;
use App\Http\Controllers\DispatchChemicalTilesController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\biltiController;
use App\Http\Controllers\cementController;
use App\Http\Controllers\sandController;
use App\Http\Controllers\bankController;
use App\Http\Controllers\inOutSummeryController;
use App\Http\Controllers\Auth\userController;

use App\Models\customer;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::match(['get', 'head'], '/', function () {
    return redirect('login');
});
Route::middleware(['auth'])->group(function () {
    Route::match(['get', 'head'], '/NotAllow', function () {
        return view('Not_Allow_page');
    })->name('notAllow');

    Route::match(['get', 'head'], 'pdf/tufftile', [TuffTilesStockController::class, 'pdfgenerate'])->name('tufftiles.pdf');
    // dashboard
    Route::match(['get', 'head'], 'dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    // users
    Route::resource('user', userController::class);
    Route::post('logoutotherUser', [userController::class, 'logoutUser'])->name('logout.other');
    Route::match(['get', 'head'], 'user/softdelete/{id}', [userController::class, 'softDelete'])->name('user.softDelete');

    // product
    Route::resource('product', ProductController::class);
    Route::match(['get', 'head'], 'product/size/crete/{product_id}', [ProductController::class, 'sizeCreate'])->name('product.size.create');
    Route::match(['get', 'head'], 'product/softdelete/{product_id}', [ProductController::class, 'softDelete'])->name('product.softDelete');
    Route::post('product/size/store', [ProductController::class, 'StoreSize'])->name('product.size.store');
    // fetch size api methodfor ajex
    Route::match(['get', 'head'], 'fetchproductName/{product_type}', [ProductController::class, 'fetchproductName'])->name('ajex.fetchproductName');
    Route::match(['get', 'head'], 'fetchSize/{id}', [ProductController::class, 'fetchSize'])->name('ajex.size');
    Route::match(['get', 'head'], 'fetchQuantity/{id}', [ProductController::class, 'fetchQuantity'])->name('ajex.quantityF');
    // ajex to delete size in edit page
    // routes/web.php or routes/api.php
    Route::delete('/deleteSize/{id}', [ProductController::class, 'deleteSize'])->name('delete.record');
    //-------------- stock -------------
    //Tuff Tiles
    Route::resource('stock/tuffTile', TuffTilesStockController::class);
    Route::post('stock/tuffTile/filter', [TuffTilesStockController::class, 'index'])->name('tuffTile.filter');
    Route::match(['get', 'head', 'post'], 'tuffTile/stock/inOutSummery', [inOutSummeryController::class, 'tufftilesInOutSummery'])->name('tuffTile.InOutSummery');
    Route::match(['get', 'head'], 'tuffTile/stock/softDelete/{stock_id}', [TuffTilesStockController::class, 'softDelete'])->name('tuffTile.softDelete');
    // Chemical Tiles
    Route::resource('stock/chemicalTiles', chemicalTilesController::class);
    Route::match(['get', 'head', 'post'], 'stock/chemicalTiles/filter', [chemicalTilesController::class, 'index'])->name('chemicalTiles.filter');
    Route::match(['get', 'head', 'post'], 'chemicalTile/stock/inOutSummery', [inOutSummeryController::class, 'chemicaltilesInOutSummery'])->name('chemicalTiles.InOutSummery');
    Route::match(['get', 'head'], 'chemicalTile/stock/softDelete/{stock_id}', [chemicalTilesController::class, 'softDelete'])->name('chemicalTiles.softDelete');
    // grravel And Sand
    Route::resource('gravelSand', sandController::class);
    Route::post('gravelSand/filter', [sandController::class, 'index'])->name('gravelSand.filter');
    // cement
    Route::resource('cement', cementController::class);
    Route::post('cement/filter', [cementController::class, 'index'])->name('cement.filter');
    Route::match(['get', 'head'], 'currentStock/cement', [cementController::class, 'curentCement'])->name('cement.current');
    // bank
    Route::resource('bank', bankController::class);
    Route::post('bank/filter', [bankController::class, 'index'])->name('bank.filter');

    //curent stock
    Route::match(['get', 'head'], '{category}/current/stock', [TuffTilesStockController::class, 'currentStock'])->name('currentStock');

    //-------  Dispatch stock --------
    // Tuff Tiles
    Route::resource('dispatch/DtuffTile', DispatchTuffTilesController::class);
    Route::post('dispatch/DtuffTile/filter', [DispatchTuffTilesController::class, 'index'])->name('DtuffTile.filter');
    Route::match(['get', 'head'], 'DtuffTile/stock/softDelete/{stock_id}', [DispatchTuffTilesController::class, 'softDelete'])->name('DtuffTile.softDelete');

    // Chemical Tiles
    Route::resource('dispatch/DchemicalTiles', DispatchChemicalTilesController::class);
    Route::post('dispatch/DchemicalTiles/filter', [DispatchChemicalTilesController::class, 'index'])->name('DchemicalTiles.filter');
    Route::match(['get', 'head'], 'DchemicalTiles/stock/softDelete/{stock_id}', [DispatchChemicalTilesController::class, 'softDelete'])->name('DchemicalTiles.softDelete');

    // customer
    Route::resource('customer', customerController::class);
    Route::post('customer/filter', [customerController::class, 'index'])->name('customer.filter');
    // Customer Details page
    Route::match(['get', 'head'], 'Customer/detail', function () {
        return view('customer.detailCustomer');
    })->name('customer.detail');

    // user
    Route::match(['get', 'head'], 'user/add', function () {
        return view('user.addUser');
    })->name('user.add');
    Route::match(['get', 'head'], 'user/view', function () {
        return view('user.viewUser');
    })->name('user.view');



    // payment
    Route::resource('payment', paymentController::class);
    Route::post('payment/filter', [paymentController::class, 'index'])->name('payment.filter');

    // invoice

    Route::resource('invoice', InvoiceController::class);
    Route::post('invoice/filter', [InvoiceController::class, 'index'])->name('invoice.filter');

    // Bilti

    Route::resource('bilti', biltiController::class);
});

Auth::routes();
Route::middleware(['auth', 'user-access:manager'])->group(function () {

    Route::match(['get', 'head'], '/manager', [HomeController::class, 'index'])->name('home');
});
Route::middleware(['auth', 'user-access:superManager'])->group(function () {

    Route::match(['get', 'head'], '/SuperManager', [HomeController::class, 'SuperManager'])->name('Super.manager.home');
});
Route::middleware(['auth', 'user-access:superAdmin'])->group(function () {

    Route::match(['get', 'head'], '/admin', [HomeController::class, 'admin'])->name('Super.admin.home');
});



    // Route::match(['get','head'],'/home', [App\Http\Controllers\HomeController::class, 'index']);
    // Route::match(['get','head'],'/generate-pdf', 'HomeController@generatePdfFromUrl');
