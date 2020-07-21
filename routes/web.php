<?php

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


Route::group(['middleware' => ['checkBoleh']], function () {
    Route::get('/get-supplier','SupplierController@get');
    Route::post('/saveSupplier','SupplierController@save');
    Route::post('/getSupplierById','SupplierController@getById');
});


Route::get('{any}', function () {
    return view('welcome');
})->where('any','.*');
