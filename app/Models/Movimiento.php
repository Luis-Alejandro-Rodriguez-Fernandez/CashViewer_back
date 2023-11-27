<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movimiento extends Model
{
    protected $fillable = [
        'origen_id',
        'destino_id',
        'familia_id',
        'asignacion_id',
        'tipo_id',
        'concepto',
        'cantidad',
        'fecha',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    protected $appends = ['fecha_milis'];

    public function getFechaMilisAttribute()
    {
        return strtotime($this->fecha);
    }

    use HasFactory;
    use SoftDeletes;
}
