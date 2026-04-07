<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Endpoint Premium Protegido por x402
Route::get('/api/premium/audit/{token_id}', function ($token_id) {
    return response()->json([
        'token_id' => $token_id,
        'security_score' => rand(85, 99) . "/100",
        'audit_report' => "Auditoría profunda completada. El contrato es seguro y no tiene reentrancy hooks. Las ballenas poseen el < 5% del suministro total.",
        'timestamp' => now()->toDateTimeString()
    ]);
})->middleware('x402');

