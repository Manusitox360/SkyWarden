<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\ReservationController;
Route::get('/' , function () {
    return view('home');
})->name('home');

Route::get('/Flights', [FlightController::class, 'availableFlights'])->name('flights.AvailableFlights');
Route::get('/flights/past', [FlightController::class, 'pastFlights'])->name('flights.PastFlights');

Route::middleware(['auth'])->group(function () {
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::post('/reservations/{flightId}', [ReservationController::class, 'store'])->name('reservations.store');
    Route::delete('/reservations/{reservationId}', [ReservationController::class, 'cancel'])->name('reservations.cancel');
});





