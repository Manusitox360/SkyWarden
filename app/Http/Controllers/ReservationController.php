<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Flight;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Muestra todas las reservas del usuario autenticado.
     */
    public function index(Request $request)
    {
        $reservations = Reservation::where('user_id', Auth::id())->get();

        return view('reservations.index', compact('reservations'));
    }

    /**
     * Realiza una reserva para un vuelo.
     */
    public function store(Request $request, $flightId)
    {
        $flight = Flight::findOrFail($flightId);

        // Verifica que el usuario no sea admin
        if (Auth::user()->role === 'admin') {
            return redirect()->back()->with('error', 'Los administradores no pueden reservar.');
        }

        // Verifica si aún hay plazas disponibles
        if ($flight->reservations->count() < $flight->plane->max_seat) {
            Reservation::create([
                'user_id' => Auth::id(),
                'flight_id' => $flight->id
            ]);
            return redirect()->route('flights.AvailableFlights')->with('success', 'Vuelo reservado exitosamente!');
        }

        return redirect()->back()->with('error', 'No hay plazas disponibles.');
    }

    /**
     * Cancela una reserva.
     */
    public function cancel($reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);

        // Verifica que la reserva pertenezca al usuario autenticado
        if ($reservation->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'No puedes cancelar la reserva de otro usuario.');
        }

        $reservation->delete();

        return redirect()->route('reservations.index')->with('success', 'Reserva cancelada exitosamente!');
    }
}


