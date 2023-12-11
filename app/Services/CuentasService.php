<?php

namespace App\Services;

use App\Repositories\CuentasRepository;

class CuentasService
{

    protected $cuentasRepository;

    public function __construct(CuentasRepository $cuentasRepository)
    {
        $this->cuentasRepository = $cuentasRepository;
    }

    public function getCuentasObjetivos(array $filtros = [])
    {
        return $this->cuentasRepository->getCuentasObjetivos($filtros);
    }
}
