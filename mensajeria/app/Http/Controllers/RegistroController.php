<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registro;

class RegistroController extends Controller
{
    public function registro(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:registros|max:255',
                'password' => 'required|string|min:8',
            ]);
 
            $user = Registro::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => hash('sha256', $request->password), // Usando SHA-256
            ]);
            return response()->json([
                'message' => 'Usuario creado exitosamente',
                'user' => $user
            ], 201);

        } catch (ValidationException $e) {
            // Devolver el JSON con el mensaje de error de validación
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->validator->errors()
            ], 422); // Código de estado 422 Unprocessable Entity
        } catch (\Exception $e) {
            // Devolver el JSON con el mensaje de error general
            return response()->json([
                'message' => 'Error al crear el usuario',
                'error' => $e->getMessage()
            ], 500); // Código de estado 500 Internal Server Error
        }
    }
}
