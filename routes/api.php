<?php

use App\Classes\ProductHelper;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('find-users', [UserController::class, 'getUsers'])->name('users.find');
Route::get('find-email/{email}', [UserController::class, 'emailExist']);
Route::get('find-username/{username}', [UserController::class, 'usernameExist']);
Route::get('find-products', [ProductHelper::class, 'getProducts'])->name('products.find_products');
Route::get('find-product-variations', [ProductHelper::class, 'getProductVariations'])->name('products.find_product_variations');
Route::get('find-product-sub-variations', [ProductHelper::class, 'getProductSubVariations'])->name('products.find_product_sub_variations');


Route::post('fee_invoices/callback/my', [InvoiceController::class, 'callbackMy'])->name('fee.invoices.callback.my');
Route::any('fee_invoices/callback/id', [InvoiceController::class, 'callbackId'])->name('fee.invoices.callback.id');
Route::get('fee_invoices/check-status', [InvoiceController::class, 'checkStatus'])->name('fee.invoices.check_status');
Route::get('/fee_invoices/generate', [InvoiceController::class, 'feeInvoiceGenerate'])->name('fee.invoices.generate');
