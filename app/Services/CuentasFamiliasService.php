<?php

namespace App\Services;

use App\Http\Resources\CuentasFamiliasResource;
use App\Repositories\CuentasFamiliasRepository;

class CuentasFamiliasService
{
    protected $cuentasFamiliasRepository;

    public function __construct(CuentasFamiliasRepository $cuentasFamiliasRepository)
    {
        return $this->cuentasFamiliasRepository = $cuentasFamiliasRepository;
    }

    public function getCuentasFamilias(array $filtros = [])
    {
        $familias = $this->cuentasFamiliasRepository->getCuentasFamilias($filtros);

        return CuentasFamiliasResource::collection($familias);
    }
}
