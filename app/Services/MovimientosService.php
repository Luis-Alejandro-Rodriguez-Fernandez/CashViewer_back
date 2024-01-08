<?php

namespace App\Services;

use App\Helpers\generalClass;
use App\Http\Resources\MovimientosResource;
use App\Repositories\MovimientosRepository;
use Exception;
use stdClass;

class MovimientosService
{
    protected $movimientosRepository;

    public function __construct(MovimientosRepository $movimientosRepository)
    {
        $this->movimientosRepository = $movimientosRepository;
    }

    public function getMovimientos(array $filtros = [])
    {
        $movimientos = $this->movimientosRepository->getMovimientos($filtros);

        return MovimientosResource::collection($movimientos);
    }

    public function createCompleteMovimiento($request)
    {
        return $this->movimientosRepository->createCompleteMovimiento($request);
    }

//    public function updateCompleteMovimiento($request)
//    {
//        if (!$request->id) {
//            throw new Exception("No se recibió el identificador");
//        }
//
//        $movimiento = $this->movimientosRepository->getMovimientos(['id' => $request->id])->first();
//
//        if (!$movimiento) {
//            throw new Exception("No se encontró el movimiento");
//        }
//
//        return $this->movimientosRepository->updateCompleteMovimiento($movimiento, $request);
//    }

    public function getEntradas(array $filtros = [])
    {
        $entradas = $this->movimientosRepository->getEntradas($filtros);

        if (!empty($entradas)) {
            return MovimientosResource::collection($entradas);
        }

        return [];
    }

    public function getSalidas(array $filtros = [])
    {
        $salidas = $this->movimientosRepository->getSalidas($filtros);

        if (!empty($salidas)) {
            return MovimientosResource::collection($salidas);
        }

        return [];
    }

    public function getBalanceTotal(array $filtros = [])
    {
        $entrada = $this->movimientosRepository->getEntradas($filtros)?->sum('cantidad') ?? 0;
        $salida = $this->movimientosRepository->getSalidas($filtros)?->sum('cantidad') ?? 0;

        return [
            'entrada' => $entrada,
            'salida' => $salida
        ];
    }

    public function getBalancePorEtapas(array $filtros = [])
    {
        $movimientos = $this->movimientosRepository->getMovimientosGrouped($filtros);

        return $this->processBalaceToLineChart($movimientos);
    }

    public function getGastosPorTipo()
    {
        $gastosPorTipo = $this->movimientosRepository->getGastosByTipo();


        return [
            'labels' => $gastosPorTipo->pluck('nombre'),
            'series' => $gastosPorTipo->pluck('gasto')
        ];
    }

    private function processBalaceToLineChart($data)
    {
        $series = [];
        $categories = $this->prepareCategoriesToBalaceToLineChart($data, true);

        $entradas = $data->filter(fn($item) => $item->destino_id === auth()->user()->cuentaMain()->id);
        $salidas = $data->filter(fn($item) => $item->origen_id === auth()->user()->cuentaMain()->id);

        //Ingresos
        $entradasSerie = new stdClass();
        $entradasSerie->name = 'Ingresos';
        $entradasSerie->data = $this->parseDataToBalaceToLineChart($entradas, $categories);

        $series[] = $entradasSerie;

        //Gastos
        $salidasSerie = new stdClass();
        $salidasSerie->name = 'Gastos';
        $salidasSerie->data = $this->parseDataToBalaceToLineChart($salidas, $categories);

        $series[] = $salidasSerie;

        return [
            'series' => $series,
            'categories' => $categories
        ];

    }

    private function parseDataToBalaceToLineChart($data, $categories)
    {
        $dataParsed = [];

        foreach ($categories as $key => $categoriy) {
            $dataParsed[] = $data->filter(function ($item) use ($key){
                    return $item->month === ($key + 1);
                })?->first()?->saldo ?? 0;
        }

        return $dataParsed;
    }

    private function prepareCategoriesToBalaceToLineChart($data, $all = false)
    {
        $categories = [];

        if ($all) {
            $months = app(generalClass::class)->getMonths();

            foreach ($months as $month) {
                $categories[] = $month;
            }

            return $categories;
        }

        $dataGrouped = $data->groupBy('month');

        foreach ($dataGrouped as $data) {
            $categories[] = app(generalClass::class)->getMonths()[$data->first()->month];
        }

        return $categories;
    }
}
