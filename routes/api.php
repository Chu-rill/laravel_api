<?php

use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1'], function () {
    // Book routes
    Route::get('/books', [BookController::class, 'index']);
    Route::get('/books/{id}', [BookController::class, 'show']);
    Route::post('/books', [BookController::class, 'store']);
    Route::put('/books/{id}', [BookController::class, 'update']);
    Route::delete('/books/{id}', [BookController::class, 'destroy']);

    // Auth routes
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);

     // Reservation routes
     Route::get('/reservations', [ReservationController::class, 'index']);
     Route::get('/reservations/{id}', [ReservationController::class, 'show']);
     Route::post('/reservations', [ReservationController::class, 'store']);
     Route::put('/reservations/{id}', [ReservationController::class, 'update']);
     Route::delete('/reservations/{id}', [ReservationController::class, 'destroy']);
});