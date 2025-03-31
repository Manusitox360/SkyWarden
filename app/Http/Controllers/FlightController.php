<?php
namespace App\Http\Controllers;

use App\Models\Flight;
use Carbon\Carbon;

class FlightController extends Controller
{
    /**
     * Muestra la lista de vuelos disponibles.
     */
    public function availableFlights()
    {
        $flights = Flight::where('departure_date', '>=', Carbon::now())
            ->orderBy('departure_date', 'asc')
            ->get();

        return view('flights.AvailableFlights', compact('flights'));
    }

    /**
     * Muestra la lista de vuelos pasados.
     */
    public function pastFlights()
    {
        $flights = Flight::where('departure_date', '<', Carbon::now())
            ->orderBy('departure_date', 'desc')
            ->get();

        return view('flights.PastFlights', compact('flights'));
    }
}

