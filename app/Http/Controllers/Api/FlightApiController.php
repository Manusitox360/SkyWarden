<?php

namespace App\Http\Controllers\Api;

use App\Models\Flight;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FlightApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $flights = Flight::with(['plane', 'departureLocation', 'arrivalLocation'])->get();
        return response()->json($flights, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'plane_id' => 'required|integer|exists:planes,id',
            'price' => 'required|numeric|min:0',
            'departure_date' => 'required|date',
            'departure_location_id' => 'required|integer|exists:locations,id',
            'arrival_date' => 'required|date|after:departure_date',
            'arrival_location_id' => 'required|integer|exists:locations,id',
            'status' => 'required|boolean',
        ]);

        $flight = Flight::create($validated);

        return response()->json([
            'data' => $flight,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $flight = Flight::with(['plane', 'departureLocation', 'arrivalLocation'])->find($id);

        if (!$flight) {
            return response()->json([
                'message' => 'Flight not found',
            ], 404);
        }

        return response()->json([
            'data' => $flight,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $flight = Flight::find($id);

        if (!$flight) {
            return response()->json([
                'message' => 'Flight not found',
            ], 404);
        }

        $validated = $request->validate([
            'plane_id' => 'sometimes|required|integer|exists:planes,id',
            'price' => 'sometimes|required|numeric|min:0',
            'departure_date' => 'sometimes|required|date',
            'departure_location_id' => 'sometimes|required|integer|exists:locations,id',
            'arrival_date' => 'sometimes|required|date|after:departure_date',
            'arrival_location_id' => 'sometimes|required|integer|exists:locations,id',
            'status' => 'sometimes|required|boolean',
        ]);

        $flight->update($validated);

        return response()->json([
            'data' => $flight,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $flight = Flight::find($id);

        if (!$flight) {
            return response()->json([
                'message' => 'Flight not found',
            ], 404);
        }

        $flight->delete();

        return response()->json([], 200);
    }
}
