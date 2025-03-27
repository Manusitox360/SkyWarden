<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PlaneApiController;
use App\Http\Controllers\Api\FlightApiController;
use App\Http\Controllers\Api\LocationApiController;
use App\Http\Controllers\Api\ReservationApiController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/planes',[PlaneApiController::class,'index'])->name('ApiIndexPlanes');
Route::post('/planes',[PlaneApiController::class, 'store'])->name('ApiStorePlanes');
Route::get('/planes/{id}',[PlaneApiController::class, 'show'])->name('ApiShowPlanes');
Route::put('/planes/{id}',[PlaneApiController::class, 'update'])->name('ApiUpdatePlanes');
Route::delete('/planes/{id}',[PlaneApiController::class, 'destroy'])->name('ApiDestroyPlanes');

Route::get('/Location',[LocationApiController::class,'index'])->name('ApiIndexLocations');
Route::post('/Location',[LocationApiController::class, 'store'])->name('ApiStoreLocation');
Route::get('/Location/{id}',[LocationApiController::class, 'show'])->name('ApiShowLocation');
Route::put('/Location/{id}',[LocationApiController::class, 'update'])->name('ApiUpdateLocation');
Route::delete('/Location/{id}',[LocationApiController::class, 'destroy'])->name('ApiDestroyLocation');

Route::get('/Flights',[FlightApiController::class,'index'])->name('ApiIndexFlights');
Route::post('/Flights',[FlightApiController::class, 'store'])->name('ApiStoreFlights');
Route::get('/Flights/{id}',[FlightApiController::class, 'show'])->name('ApiShowFlights');
Route::put('/Flights/{id}',[FlightApiController::class, 'update'])->name('ApiUpdateFlights');
Route::delete('/Flights/{id}',[FlightApiController::class, 'destroy'])->name('ApiDestroyFlights');

Route::get('/Reservations',[ReservationApiController::class,'index'])->name('ApiIndexReservations');
Route::post('/Reservation',[ReservationApiController::class, 'store'])->name('ApiStoreReservation');
Route::get('/Reservation/{id}',[ReservationApiController::class, 'show'])->name('ApiShowReservation');
Route::put('/Reservation/{id}',[ReservationApiController::class, 'update'])->name('ApiUpdateReservation');
Route::delete('/Reservation/{id}',[ReservationApiController::class, 'destroy'])->name('ApiDestroyReservation');

