<?php

namespace App\Http\Controllers;

use App\Models\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
{
    $request->validate([
        'login' => 'required|string',
        'mdp' => 'required|string',
    ]);

    $utilisateur = Auth::where('login', $request->login)->first();

    if (!$utilisateur) {
        Log::info('User not found: ' . $request->login);
        return response()->json(['message' => 'Identifiants invalides'], 401);
    }

    if ($utilisateur->validatePassword($request->mdp)) {
        $token = $utilisateur->generateToken();
        return response()->json([
            'token' => $token,
            'admin' => $utilisateur->admin // Include admin status in the response
        ], 200);
    }

    Log::info('Password validation failed for user: ' . $request->login);
    return response()->json(['message' => 'Identifiants invalides'], 401);
}


}
