<?php

use App\Http\Controllers\Product\ProductController;
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

Route::prefix('products')->controller(ProductController::class)->group(function () {
    Route::post('/{product}', 'update');
    Route::post('/search/name', 'searchByFilters');
});
Route::apiResource('products', ProductController::class);
// Route::apiResource('products', ProductController::class);
