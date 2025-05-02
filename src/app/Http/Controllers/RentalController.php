<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRentalRequest;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class RentalController extends Controller
{
    // GET /api/rentals
    public function index(): JsonResponse
    {
        $rentals = Rental::with(['vehicle','customer'])
                         ->paginate(10);
        return response()->json($rentals);
    }

    // POST /api/rentals
    public function store(StoreRentalRequest $request): JsonResponse
    {
        $rental = Rental::create($request->validated());
        return response()->json($rental, 201);
    }

    // GET /api/rentals/{rental}
    public function show(Rental $rental): JsonResponse
    {
        $rental->load(['vehicle','customer']);
        return response()->json($rental);
    }

    // POST /api/rentals/{rental}/start
    public function start(Rental $rental): JsonResponse
    {
        $rental->update([
            'start_date' => Carbon::today()->toDateString(),
        ]);
        return response()->json($rental);
    }

    // POST /api/rentals/{rental}/end
    public function end(Rental $rental): JsonResponse
    {
        $rental->load('vehicle');
        $end = Carbon::today();
        $start = Carbon::parse($rental->start_date);
        $days = $start->diffInDays($end) + 1; 
        $rental->update([
            'end_date'     => $end->toDateString(),
            'total_amount' => $days * $rental->vehicle->daily_rate,
        ]);
        return response()->json($rental);
    }
}