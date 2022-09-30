<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
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
// Category routes
Route::get('/get_category', [CategoryController::class, 'show']);
Route::get('/get_category/{id}', [CategoryController::class, 'get_id']);
Route::post('/update_category/{id}', [CategoryController::class, 'edit']);
Route::post('/add-category', [CategoryController::class,'create']);
Route::delete('/delete_category/{id}', [CategoryController::class,'delete']);
// Product routes
Route::get('/get_product', [ProductController::class, 'show']);
Route::get('/get_product/{id}', [ProductController::class, 'get_id']);
Route::post('/update_product/{id}', [ProductController::class, 'edit']);
Route::post('/add_product', [ProductController::class,'create']);
Route::delete('/delete_product/{id}', [ProductController::class,'delete']);
