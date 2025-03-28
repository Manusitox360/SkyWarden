<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Flight;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReservationApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::all();
        return response()->json($reservations, 200);
    } 

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|min:0',
            'flight_id' => 'required|integer|min:0',
            'status' => 'required|boolean',
            'seat_number' => 'required|integer',
        ]);
        $reservation = Reservation::create($validated);
        return response()->json([
            'data' => $reservation,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $reservation = Reservation::findOrFail($id);
        return response()->json([
            'data' => $reservation,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json([
                'message' => 'Reservation not found',
            ], 404);
        }

        $validated = $request->validate([
            'user_id' => 'integer|min:0',
            'flight_id' => 'integer|min:0',
            'status' => 'boolean',
            'seat_number' => 'integer',
        ]);
        
        $flight_id = $validated['flight_id'] ?? $reservation->flight_id;
        $flight = Flight::find($flight_id);

        $user_id = $validated['user_id'] ?? $reservation->user_id;
        $user = User::find($user_id);
        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        $available_seat = $flight->available_seats;
        if ($available_seat < 1){
            return response()->json([
                'message' => 'There are no available seats',
            ], 400);
        }

        $max_seat = $flight->plane->max_seat;
        if ($validated['seat_number'] > $max_seat){
            return response()->json([
                'message' => 'Seat number is greater than max seat',
            ], 400);
        }

        if (!$flight){
            return response()->json([
                'message' => 'Flight not found',
            ], 404);
        }

        $reservation->update($validated);
        return response()->json([
            'data' => $reservation,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reservation = Reservation::find($id);
        if (!$reservation) {
            return response()->json([
                'message' => 'Reservation not found',
            ], 404);
        }

        $reservation->delete();
        return response()->json([], 204);

    }
}
