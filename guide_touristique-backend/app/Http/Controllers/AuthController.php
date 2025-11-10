<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log; 
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Gère la connexion utilisateur et retourne un token API.
     */
    public function login(Request $request)
    {
        Log::info('Tentative de connexion', ['email' => $request->email]);

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
      
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            Log::warning('Utilisateur non trouvé', ['email' => $request->email]);
            throw ValidationException::withMessages([
                'email' => ['Les identifiants sont incorrects.'],
            ]);
        }

        if (!Hash::check($request->password, $user->password)) {
            Log::warning('Mot de passe incorrect', ['email' => $request->email]);
            throw ValidationException::withMessages([
                'email' => ['Les identifiants sont incorrects.'],
            ]);
        }

        $token = $user->createToken('admin-token')->plainTextToken;

        Log::info('Connexion réussie', ['email' => $request->email, 'user_id' => $user->id]);

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }

    /**
     * Déconnexion de l'utilisateur (révoque tous les tokens).
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        Log::info('Déconnexion utilisateur', ['user_id' => $request->user()->id]);

        return response()->json([
            'message' => 'Déconnecté avec succès',
        ]);
    }
    public function register(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
    ]);

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user' => $user,
    ]);
}

}
