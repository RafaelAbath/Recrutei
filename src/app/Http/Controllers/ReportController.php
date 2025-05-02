<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

class ReportController extends Controller
{
    /**
     * GET /api/reports/revenue?start=YYYY-MM-DD&end=YYYY-MM-DD
     */
    public function revenue(Request $request): JsonResponse
    {
        $data = $request->validate([
            'start' => ['required', 'date'],
            'end'   => ['required', 'date', 'after_or_equal:start'],
        ]);

        $url = config('services.report.url') . '/reports/revenue';

        $response = Http::get($url, [
            'start' => $data['start'],
            'end'   => $data['end'],
        ]);

        if (! $response->successful()) {
            abort(502, 'Erro ao conectar ao serviço de relatórios.');
        }

        return response()->json($response->json());
    }
}
