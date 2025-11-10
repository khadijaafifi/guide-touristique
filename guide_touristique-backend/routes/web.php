<?php

use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Illuminate\Http\Request;
use App\Models\User;
use APP\Http\Controllers\LieuController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;




use Illuminate\Support\Facades\Auth;
Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('/login', function () {
    return response()->json(['message' => 'Page de login API non disponible.'], 404);
})->name('login');
