<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory;

    protected $table = 'registros';

     // Permitir la asignación masiva de estos campos
     protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
