<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\LieuController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ItineraryController; 

// 🌐 Info sur Laravel
Route::get('/', fn () => ['Laravel' => app()->version()]);

// 🔐 Auth routes
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/me', fn (Request $request) => $request->user());
Route::middleware('auth:sanctum')->get('/user', fn (Request $request) => $request->user());
Route::post('/register', [AuthController::class, 'register']);
// 📍 Lieux publics
Route::get('/lieux', [LieuController::class, 'index']);
Route::get('/natures', [LieuController::class, 'nature']);

// 🧪 Test de requête
Route::post('/test-lieu', function (Request $request) {
    Log::info('Requête reçue', $request->all());
    return response()->json(['status' => 'ok'], 200);
});

// 🔒 Routes protégées par auth + admin
Route::middleware(['auth:sanctum', 'is_admin'])->group(function () {
    Route::post('/lieux', [LieuController::class, 'store']);
    Route::put('/lieux/{id}', [LieuController::class, 'update']);
    Route::delete('/lieux/{id}', [LieuController::class, 'destroy']);
    Route::get('/lieux/{id}', [LieuController::class, 'show']);

    // 📁 Accès aux images stockées
    Route::get('/storage/{filename}', function ($filename) {
        $path = storage_path('app/public/images/' . $filename);
        if (file_exists($path)) {
            return response()->file($path);
        }
        abort(404);
    });
});

// 🗺️ Itinéraires publics
Route::get('/itineraires', [ItineraryController::class, 'index']);

Route::get('/lieux/{id}', [LieuController::class, 'show']);
use App\Models\Lieu;

Route::get('/lieu/{id}/images/{filename}', function ($id, $filename) {
    $lieu = Lieu::findOrFail($id);

    // Supposons que $lieu->images est une collection des noms fichiers images liés au lieu
    if (!in_array($filename, $lieu->images->pluck('filename')->toArray())) {
        abort(404);
    }

    $path = storage_path('app/public/images/' . $filename);
    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    return response($file, 200)->header("Content-Type", $type);
});

