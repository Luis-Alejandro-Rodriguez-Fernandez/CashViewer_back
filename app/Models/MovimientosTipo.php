<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimientosTipo extends Model
{
    use HasFactory;

    protected $table="movimientos_tipos";

    protected $fillable = [
        'nombre',
        'activo'
    ];
}
