<?php

use App\Http\Controllers\ClientsController;
use App\Http\Controllers\DecCompController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(ClientsController::class)->group(function () {
    Route::get("/", "all")->name("clients");
    Route::get("/download/{format}", "download")->name("download");
    Route::get("/get_by_param", "get_by_param")->name("get_by_param");
    Route::get("/where_birth_date_between", "where_birth_date_between")->name("where_birth_date_between");
});


Route::controller(DecCompController::class)->group(function () {
    Route::get("/decomp_comp","decomp_comp")->name("decomp_comp");
    Route::post("/decompression", "return_decompression")->name("decompression");
    Route::post("/compression", "return_compression")->name("compression");
});
