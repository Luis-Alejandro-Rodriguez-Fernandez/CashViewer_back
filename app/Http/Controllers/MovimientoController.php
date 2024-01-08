<?php

namespace App\Http\Controllers;

use App\Services\MovimientosService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{

    protected $movimientosService;

    public function __construct(MovimientosService $movimientosService)
    {
        $this->movimientosService = $movimientosService;
    }

    public function getMovimientos(Request $request): JsonResponse
    {
        $movimientos = $this->movimientosService->getMovimientos($request->toArray());

        return $this->generalMethods()->responseToApp(1, $movimientos, "Movimientos en data");
    }

    public function setMovimiento(Request $request): JsonResponse
    {
        $movimiento = null;

        try {

            if (!empty($request->id)) {

                $this->movimientosService->createCompleteMovimiento($request);

            } else {

//                $this->movimientosService->updateCompleteMovimiento($request);

            }

            if ($movimiento) {
                return $this->generalMethods()->responseToApp(1, $movimiento, "Guardado correctamente");
            }

        } catch (Exception $e) {
            return $this->generalMethods()->responseToApp(0, [], $e->getMessage());
        }

        return $this->generalMethods()->responseToApp(0, [], "No se pudo guardar la información");
    }

    public function getEntradas(): JsonResponse
    {
        $entradas = $this->movimientosService->getEntradas();

        return $this->generalMethods()->responseToApp(1, $entradas, "Entradas en data");
    }

    public function getSalidas(): JsonResponse
    {
        $salidas = $this->movimientosService->getSalidas();

        return $this->generalMethods()->responseToApp(1, $salidas, "Salidas en data");
    }

    public function getBalance(Request $response): JsonResponse
    {
        $balanceMensual = $this->movimientosService->getBalanceTotal($response->toArray());

        return $this->generalMethods()->responseToApp(1, $balanceMensual, 'Balance en data');
    }

    public function getBalancePorEtapas(Request $response): JsonResponse
    {
        $balancePorEtapas = $this->movimientosService->getBalancePorEtapas(['groupByMonth' => true]);

        return $this->generalMethods()->responseToApp(1, $balancePorEtapas, "Balance en data");
    }

    public function getGastosPorTipo(): JsonResponse
    {
        $gastosPorTipo = $this->movimientosService->getGastosPorTipo();

        return $this->generalMethods()->responseToApp(1, $gastosPorTipo, "Balance en data");
    }
}
