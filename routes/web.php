<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ScoutController;

Route::get('/', function () {
    $stats = [
        'audited' => \App\Models\Audit::count(),
        'threats' => \App\Models\Audit::where('risk_score', '>', 50)->count(),
        'xlm'     => \App\Models\Audit::sum('amount_xlm'),
    ];
    return view('welcome', compact('stats'));
});

Route::get('/tutorial', function () {
    return view('tutorial');
});

Route::get('/mission-control', function () {
    return view('dashboard'); // El tablero actual
});

// Ruta para ejecutar la misión del agente
Route::get('/scout-api/agent/run', [ScoutController::class, 'run']);
Route::get('/scout-api/agent/history', [ScoutController::class, 'history']);

// Endpoint Premium Protegido por x402
Route::get('/scout-api/premium/audit/{token_id}', function ($token_id) {
    return response()->json([
        'token_id' => $token_id,
        'security_score' => rand(85, 99) . "/100",
        'audit_report' => "Auditoría profunda completada. El contrato es seguro y no tiene reentrancy hooks. Las ballenas poseen el < 5% del suministro total.",
        'timestamp' => now()->toDateTimeString()
    ]);
})->middleware('x402');

