<?php

use App\Http\Controllers\V1\AddressController;
use App\Http\Controllers\V1\CategoryController;
use App\Http\Controllers\V1\CustomerController;
use App\Http\Controllers\V1\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware(['auth:sanctum', 'firewall.all'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('V1')->group(function () {
    Route::apiResource('categories', CategoryController::class);

    // gesttion des produits
    Route::apiResource('products', ProductController::class);
    Route::delete('products/del-multi', [ProductController::class, 'multiDelete']);

    // gestion des clients et de leurs adresse
    Route::apiResource('customers', CustomerController::class);
    Route::post('customers/del-multi', [CustomerController::class, 'multiDelete']);
    Route::apiResource('addresses', AddressController::class);
    Route::post('addresses/del-multi', [AddressController::class, 'multiDelete']);
});
