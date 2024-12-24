<?php

use App\Http\Controllers\API\V1\CustomerController;
use App\Http\Controllers\API\V1\InvoiceController;
use App\Models\Customer;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix'=> 'api/v1','namespace'=>'App\Http\Controllers\API\V1'], function () {
    Route::apiResource('customers',CustomerController::class);
    Route::apiResource('invoices',InvoiceController::class);
});