<?php

namespace App\Repositories;

use App\Models\MovimientosFamilia;

class MovimientosFamiliasRepository
{

    public function getMovimientosFamilia(array $filtros = [])
    {
        return MovimientosFamilia::query()->get();
    }
}
