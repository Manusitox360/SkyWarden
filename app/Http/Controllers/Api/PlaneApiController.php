<?php

namespace App\Http\Controllers\Api;

use App\Models\Plane;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlaneApiController extends Controller
{
    
    public function index()
    {
        $planes = Plane::all();
        return response()->json($planes, 200);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'max_seat' => 'required|integer',
        ]);

        $plane = Plane::create($validated);
        
        return response()->json([
            'data' => $plane,
        ], 201);
    }

    
    public function show(string $id)
    {
        return response()->json([
            'data' => Plane::findOrFail($id),
        ], 200);
    }

    
    public function update(Request $request, string $id)
    {
        $plane = Plane::findOrFail($id);
        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'max_seat' => 'sometimes|required|integer',
        ]);
    
        
        $plane->update($validated);
        return response()->json([
            'data' => $plane,
        ], 200);
    }

    
    public function destroy(string $id)
    {
        $plane = Plane::findOrFail($id);
        $plane->delete();
        return response()->json([], 204);
    }
}
