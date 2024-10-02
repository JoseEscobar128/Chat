<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Asegúrate de importar esto
use Laravel\Sanctum\HasApiTokens;

class Registro extends Authenticatable // Cambiar a Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $table = 'registros';

    // Permitir la asignación masiva de estos campos
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Si deseas ocultar la contraseña al serializar el modelo
    protected $hidden = [
        'password',
    ];
}
