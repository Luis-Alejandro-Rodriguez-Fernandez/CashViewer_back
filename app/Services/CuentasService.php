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

    public function createCuentaObjetivo(array $data = [])
    {
        if (isset($data['name']) && isset($data['descripcion']) && !empty($data['objetivo'])) {
            return $this->cuentasRepository->createCuentaObjetivo($data);
        }

        return null;
    }

    public function updateCuentaObjetivo(array $data = [])
    {
        $cuenta = $this->cuentasRepository->getCuentasObjetivos(['id' => $data['id']])->first();

        if ($cuenta) {
            return $this->cuentasRepository->updateCuentaObjetivo($cuenta, $data);
        }

        return null;
    }
}
