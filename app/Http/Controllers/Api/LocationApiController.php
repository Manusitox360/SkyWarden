<?php

namespace App\Http\Controllers\Api;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LocationApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::all();
        return response()->json($locations, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'city' => 'required|string',
            'country' => 'required|string',
            'airport_code' => 'required|string',
        ]);

        $location = Location::create($validated);
        
        return response()->json([
            'data' => $location,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            'data' => Location::findOrFail($id),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $location = Location::findOrFail($id);
        $validated = $request->validate([
            'city' => 'sometimes|required|string',
            'country' => 'sometimes|required|string',
            'airport_code' => 'sometimes|required|string',
        ]);
    
        
        $location->update($validated);
        return response()->json([
            'data' => $location,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $location = Location::findOrFail($id);
        $location->delete();
        return response()->json([], 204);
    }
}
