<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registro;
use Illuminate\Support\Facades\Auth; // Asegúrate de importar esto al principio del archivo

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Verifica las credenciales
        $user = Registro::where('email', $request->email)
            ->where('password', hash('sha256', $request->password))
            ->first();

        if (!$user) {
            return response()->json([
                'message' => 'Error de autenticación',
                'error' => 'Las credenciales proporcionadas son incorrectas.'
            ], 401);
        }

        // Genera el token
        $token = $user->createToken('YourAppName')->plainTextToken;

        return response()->json([
            'message' => 'Inicio de sesión exitoso',
            'token' => $token,
            'user' => $user,
        ], 200);
    }
}
