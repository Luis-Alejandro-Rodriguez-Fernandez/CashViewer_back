<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimientosRecurrencia extends Model
{
    use HasFactory;

    protected $table = "movimientos_recurrencias";

    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha',
        'activo'
    ];
}
