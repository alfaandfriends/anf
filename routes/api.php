<?php

use App\Classes\InvoiceHelper;
use App\Classes\ProductHelper;
use App\Classes\ProgressReportHelper;
use App\Classes\StoryHelper;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProgrammeController;
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

Route::middleware(['auth'])->group(function(){
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

    Route::get('/programmes/get-fee', [ProgrammeController::class, 'getFee'])->name('programmes.get_fee');

    Route::get('classes/get-class-types', [ClassController::class, 'getClassTypes'])->name('classes.get_class_types');
    Route::get('classes/get-class-levels', [ClassController::class, 'getClassLevels'])->name('classes.get_class_levels');
    Route::get('classes/find', [ClassController::class, 'findClasses'])->name('classes.find');
});
