<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\PlaneApiController;
use App\Http\Controllers\Api\FlightApiController;
use App\Http\Controllers\Api\LocationApiController;
use App\Http\Controllers\Api\ReservationApiController;
use App\Http\Controllers\Api\UserApiController;

Route::prefix('auth')->group(function () {
    // Make the register route accessible to guests
    Route::post('/register', [AuthApiController::class, 'store'])->name('auth.Register'); // Registration route
    Route::post('/login', [AuthApiController::class, 'login'])->name('auth.Login'); // Login route
    Route::post('/logout', [AuthApiController::class, 'logout'])->name('auth.Logout');
    Route::post('/refresh', [AuthApiController::class, 'refresh'])->name('auth.Refresh');
    Route::get('/me', [AuthApiController::class, 'me'])->name('auth.Me');
});

// Routes accessible to guests (only GET requests allowed)
Route::group(['middleware' => ['guest.only']], function () {
    Route::get('/Flights', [FlightApiController::class, 'index'])->name('ApiIndexFlights');
    Route::get('/Flights/{id}', [FlightApiController::class, 'show'])->name('ApiShowFlights');
    Route::get('/Location', [LocationApiController::class, 'index'])->name('ApiIndexLocations');
    Route::get('/Location/{id}', [LocationApiController::class, 'show'])->name('ApiShowLocation');
});

// Routes requiring authentication (for normal users and admins)
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/Reservations', [ReservationApiController::class, 'index'])->name('ApiIndexReservations');
    Route::post('/Reservation', [ReservationApiController::class, 'store'])->name('ApiStoreReservation');
    Route::get('/Reservation/{id}', [ReservationApiController::class, 'show'])->name('ApiShowReservation');
    Route::put('/Reservation/{id}', [ReservationApiController::class, 'update'])->name('ApiUpdateReservation');
    Route::delete('/Reservation/{id}', [ReservationApiController::class, 'destroy'])->name('ApiDestroyReservation');
});

// Routes requiring admin role
Route::group(['middleware' => ['auth:api', 'admin']], function () {
    Route::get('/admin-only', function () {
        return response()->json(['message' => 'Welcome, Admin!']);
    });

    // Admin-specific routes
    Route::get('/planes', [PlaneApiController::class, 'index'])->name('ApiIndexPlanes');
    Route::post('/planes', [PlaneApiController::class, 'store'])->name('ApiStorePlanes');
    Route::get('/planes/{id}', [PlaneApiController::class, 'show'])->name('ApiShowPlanes');
    Route::put('/planes/{id}', [PlaneApiController::class, 'update'])->name('ApiUpdatePlanes');
    Route::delete('/planes/{id}', [PlaneApiController::class, 'destroy'])->name('ApiDestroyPlanes');

    Route::post('/Flights', [FlightApiController::class, 'store'])->name('ApiStoreFlights');
    Route::put('/Flights/{id}', [FlightApiController::class, 'update'])->name('ApiUpdateFlights');
    Route::delete('/Flights/{id}', [FlightApiController::class, 'destroy'])->name('ApiDestroyFlights');

    Route::post('/Location', [LocationApiController::class, 'store'])->name('ApiStoreLocation');
    Route::put('/Location/{id}', [LocationApiController::class, 'update'])->name('ApiUpdateLocation');
    Route::delete('/Location/{id}', [LocationApiController::class, 'destroy'])->name('ApiDestroyLocation');

    Route::get('/Users', [AuthApiController::class, 'index'])->name('ApiIndexUsers');
    Route::post('/Users', [AuthApiController::class, 'store'])->name('ApiStoreUsers');
    Route::get('/Users/{id}', [AuthApiController::class, 'show'])->name('ApiShowUsers');
    Route::put('/Users/{id}', [AuthApiController::class, 'update'])->name('ApiUpdateUsers');
    Route::delete('/Users/{id}', [AuthApiController::class, 'destroy'])->name('ApiDestroyUsers');
});


