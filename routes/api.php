<?php

use App\Http\Controllers\RaporController;
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
Route::middleware('api')->group(function () {
    Route::post('import',[RaporController::class,'import'])->name('import');
    Route::get('rapor',[RaporController::class,'rapor'])->name('rapor');
    Route::get('export',[RaporController::class,'export'])->name('export');

});

