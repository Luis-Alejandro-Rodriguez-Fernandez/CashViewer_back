<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentasFamilia extends Model
{
    use HasFactory;

    protected $table = "cuentas_familias";

    protected $fillable = [
        'nombre',
        'activo'
    ];
}
