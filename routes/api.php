<?php

use App\Http\Controllers\CategoryController;
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
Route::get('/get_category', [CategoryController::class, 'show']);
Route::get('/get_category/{id}', [CategoryController::class, 'get_id']);
Route::put('/update_category/{id}', [CategoryController::class, 'edit']);
Route::post('/add-category', [CategoryController::class,'create']);
