<?php

namespace App\Http\Controllers;

use App\Services\CuentasFamiliasService;
use Illuminate\Http\Request;

class CuentasFamiliaController extends Controller
{
    protected $cuentasFamiliasService;

    public function __construct(CuentasFamiliasService $cuentasFamiliasService)
    {
        $this->cuentasFamiliasService = $cuentasFamiliasService;
    }

    public function getCuentasFamilias()
    {
        $cuentasFamilias = $this->cuentasFamiliasService->getCuentasFamilias();

        return $this->generalMethods()->responseToApp(1, $cuentasFamilias, 'familias en data');
    }
}
