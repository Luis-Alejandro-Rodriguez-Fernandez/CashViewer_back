<?php

namespace App\Repositories;

use App\Models\CuentasFamilia;

class CuentasFamiliasRepository
{

    public function getCuentasFamilias(array $filtros = [])
    {
        return CuentasFamilia::query()->get();
    }

}
