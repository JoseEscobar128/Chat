<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Registro; // Asegúrate de importar el modelo de usuario
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'message' => 'Usuario no autenticado.',
            ], 401);
        }
        try {
            $request->validate([
                'receiver_email' => 'required|email|exists:registros,email', // Validar que el email del destinatario exista
                'message' => 'required|string',
            ]);

            // Obtener el ID del receptor
            $receiver = Registro::where('email', $request->receiver_email)->first();

            // Guardar el mensaje en la base de datos
            $message = Message::create([
                'sender_id' => auth()->id(), // ID del usuario autenticado
                'receiver_id' => $receiver->id,
                'message' => encrypt($request->message), // Encriptar el mensaje
            ]);

            return response()->json([
                'message' => 'Mensaje enviado exitosamente',
                'data' => $message,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->validator->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al enviar el mensaje',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function readMessages($userId)
{
    try {
        // Verificar si el usuario especificado existe
        $receiver = Registro::find($userId);
        if (!$receiver) {
            return response()->json([
                'message' => 'Usuario receptor no encontrado.',
            ], 404);
        }

        // Obtener los mensajes entre el usuario autenticado y el usuario especificado
        $messages = Message::where(function ($query) use ($userId) {
            $query->where('sender_id', auth()->id())
                  ->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                  ->where('receiver_id', auth()->id());
        })->get();

        // Verificar si hay mensajes
        if ($messages->isEmpty()) {
            return response()->json([
                'message' => 'No hay mensajes entre los usuarios.',
                'data' => []
            ], 204); // Código 204 No Content
        }

        // Desencriptar los mensajes
        $messages = $messages->map(function ($message) {
            return [
                'id' => $message->id,
                'sender_id' => $message->sender_id,
                'receiver_id' => $message->receiver_id,
                'message' => decrypt($message->message), // Desencriptar el mensaje
                'created_at' => $message->created_at,
                'updated_at' => $message->updated_at,
            ];
        });

        return response()->json([
            'message' => 'Mensajes leídos exitosamente',
            'data' => $messages,
        ]);
    } catch (\Illuminate\Database\QueryException $e) {
        return response()->json([
            'message' => 'Error en la consulta a la base de datos',
            'error' => $e->getMessage(),
        ], 500); // Código 500 Internal Server Error
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error al leer los mensajes',
            'error' => $e->getMessage(),
        ], 500); // Código 500 Internal Server Error
    }
}

    
    
    
}
