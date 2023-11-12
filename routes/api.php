<?php

use App\Http\Controllers\V1\CategoryController;
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

Route::prefix('V1')->group(function () {
    Route::middleware(['auth:sanctum', 'firewall.all'])->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('products', ProductController::class);
    Route::delete('products/del-multi', [ProductController::class, 'multiDelete']);
});
