<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimientosFamilia extends Model
{
    use HasFactory;

    protected $table = "movimientos_familias";

    protected $fillable = [
        'nombre',
        'activo'
    ];
}
