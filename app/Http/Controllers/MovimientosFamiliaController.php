<?php

namespace App\Http\Controllers;

use App\Services\MovimientosFamiliasService;
use Illuminate\Http\Request;

class MovimientosFamiliaController extends Controller
{
    protected $movimientosFamiliasService;

    public function __construct(MovimientosFamiliasService $movimientosFamiliasService)
    {
        $this->movimientosFamiliasService = $movimientosFamiliasService;
    }

    public function getMovimientosFamilias()
    {
        $familias = $this->movimientosFamiliasService->getCuentasFamilias();

        return $this->generalMethods()->responseToApp(1, $familias,'familias en data');
    }
}
