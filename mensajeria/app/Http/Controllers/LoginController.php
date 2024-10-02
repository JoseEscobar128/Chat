<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registro;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Buscar el usuario por el correo electrónico y la contraseña
        $user = Registro::where('email', $request->email)
            ->where('password', hash('sha256', $request->password)) // Usando SHA-256
            ->first();

        // Verificar si el usuario existe
        if (!$user) {
            return response()->json([
                'message' => 'Error de autenticación',
                'error' => 'Las credenciales proporcionadas son incorrectas.'
            ], 401);
        }

        // Devolver una respuesta de éxito
        return response()->json([
            'message' => 'Inicio de sesión exitoso',
            'user' => $user
        ], 200);
    }
}
