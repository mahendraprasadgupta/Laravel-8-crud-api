<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\productsController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('productlist/{id?}',[productsController::class,'productList']);
Route::post('product/add',[productsController::class,'addProduct']);
Route::put('product/update',[productsController::class,'updateProduct']);
Route::get('product/searchbyname/{key}',[productsController::class,'searchProductByName']);
Route::get('product/search/{key}',[productsController::class,'searchProduct']);
Route::delete('product/delete/{id?}',[productsController::class,'removeProduct']);