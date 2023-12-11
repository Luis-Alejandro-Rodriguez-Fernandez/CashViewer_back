<?php

namespace App\Services;

use App\Http\Resources\MovimientosFamiliasResource;
use App\Repositories\MovimientosFamiliasRepository;

class MovimientosFamiliasService
{
    protected $cuentasFamiliasRepository;

    public function __construct(MovimientosFamiliasRepository $cuentasFamiliasRepository)
    {
        return $this->cuentasFamiliasRepository = $cuentasFamiliasRepository;
    }

    public function getCuentasFamilias(array $filtros = [])
    {
        $familias = $this->cuentasFamiliasRepository->getMovimientosFamilia($filtros);

        return MovimientosFamiliasResource::collection($familias);
    }
}
