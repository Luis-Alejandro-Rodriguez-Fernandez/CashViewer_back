<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    use HasFactory;

    protected $table = "cuentas";

    protected $fillable = [
        'user_id',
        'familia_id',
        'cuenta_id',
        'nombre',
        'descripcion',
        'saldo',
        'activo',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    function ingresos()
    {
        return $this->hasMany(Movimiento::class, 'destino_id', 'id')
            ->orderByDesc('created_at');
    }

    function gastos()
    {
        return $this->hasMany(Movimiento::class, 'origen_id', 'id')
            ->orderByDesc('created_at');
    }
}
