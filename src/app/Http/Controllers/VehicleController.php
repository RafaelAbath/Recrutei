<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class VehicleController extends Controller
{
    // GET /api/vehicles
    public function index(): JsonResponse
    {
        return response()->json(Vehicle::paginate(10));
    }

    // POST /api/vehicles
    public function store(StoreVehicleRequest $request): JsonResponse
    {
        $vehicle = Vehicle::create($request->validated());

        return response()->json($vehicle, 201);
    }

    // GET /api/vehicles/{vehicle}
    public function show(Vehicle $vehicle): JsonResponse
    {
        return response()->json($vehicle);
    }

    // PUT /api/vehicles/{vehicle}
    public function update(UpdateVehicleRequest $request, Vehicle $vehicle): JsonResponse
    {
        $vehicle->update($request->validated());
        return response()->json($vehicle);
    }

    // DELETE /api/vehicles/{vehicle}
    public function destroy(Vehicle $vehicle): JsonResponse
    {
        $vehicle->delete();
        return response()->json([], 204);
    }
    public function search(Request $request)
{
    $q = $request->query('q', '');
    $results = Vehicle::search($q)
        ->paginate(15)
        ->withQueryString();

    return response()->json($results);
}
}