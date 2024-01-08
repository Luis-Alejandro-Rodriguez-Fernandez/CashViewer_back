<?php

namespace App\Repositories;

use App\Http\Resources\MovimientosResource;
use App\Models\Movimiento;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\select;

class MovimientosRepository
{
    public function getMovimientos(array $filtros = [])
    {
        return DB::table('movimientos as m')
            ->selectRaw('m.id as id')
            ->selectRaw('m.origen_id as origen_id')
            ->selectRaw('user_origen.name as user_origen')
            ->selectRaw('m.destino_id as destino_id')
            ->selectRaw('user_destino.name as user_destino')
            ->selectRaw('m.familia_id as familia_id')
            ->selectRaw('mf.nombre as familia')
            ->selectRaw('m.asignacion_id as asignacion_id')
            ->selectRaw('m.tipo_id as tipo_id')
            ->selectRaw('mt.nombre as tipo')
            ->selectRaw('m.concepto as concepto')
            ->selectRaw('m.cantidad as cantidad')
            ->selectRaw('m.fecha as fecha')
            ->leftJoin('cuentas as cuenta_origen', 'cuenta_origen.id', '=', 'm.origen_id')
            ->leftJoin('users as user_origen', 'user_origen.id', '=', 'cuenta_origen.user_id')
            ->leftJoin('cuentas as cuenta_destino', 'cuenta_destino.id', '=', 'm.destino_id')
            ->leftJoin('users as user_destino', 'user_destino.id', '=', 'cuenta_destino.user_id')
            ->leftJoin('movimientos_tipos as mt', 'mt.id', '=', 'm.tipo_id')
            ->leftJoin('movimientos_familias as mf', 'mf.id', '=', 'm.familia_id')
            ->when(auth()->check() && !empty($filtros['cuenta']), function ($q) use ($filtros) {
                $q->where('cuenta_origen.id', $filtros['cuenta']);
                $q->orWhere('cuenta_destino.id', $filtros['cuenta']);
            })
            ->where(function ($q) use ($filtros) {

                if (!empty($filtros['id'])) {
                    $q->where('m.id', $filtros['id']);
                }

            })
            ->offset($filtros['offset'])
            ->limit($filtros['limit'])
            ->orderByDesc('fecha')
            ->get();
    }

    public function createCompleteMovimiento($request)
    {
       return Movimiento::query()->create([
           'origen_id' => $request->origen_id,
           'destino_id' => $request->destino_id,
           'familia_id' => $request->familia_id,
           'asignacion_id' => isset($request->asignacion_id) ? $request->asignacion_id : null,
           'tipo_id' => $request->tipo_id,
           'concepto' => isset($request->concepto) ? $request->concepto : '',
           'cantidad' => $request->cantidad,
           'fecha' => $request->fecha,
       ]);
    }

//    public function updateCompleteMovimiento($movimiento, $request)
//    {
//        $movimiento-> = $request->;
//        $movimiento-> = $request->;
//        $movimiento-> = $request->;
//        $movimiento-> = $request->;
//
//        if ($movimiento->save()) {
//
//            $movimiento->refresh();
//
//            return $movimiento;
//        }
//
//        return null;
//    }

    public function getEntradas(array $filtros = [])
    {
        return Movimiento::query()
            ->selectRaw('movimientos.id as id')
            ->selectRaw('movimientos.origen_id as origen_id')
            ->selectRaw('user_origen.name as user_origen')
            ->selectRaw('movimientos.destino_id as destino_id')
            ->selectRaw('user_destino.name as user_destino')
            ->selectRaw('movimientos.familia_id as familia_id')
            ->selectRaw('mf.nombre as familia')
            ->selectRaw('movimientos.asignacion_id as asigancion_id')
            ->selectRaw('movimientos .tipo_id as tipo_id')
            ->selectRaw('mt.nombre as tipo')
            ->selectRaw('movimientos.concepto as concepto')
            ->selectRaw('movimientos.cantidad as cantidad')
            ->selectRaw('movimientos.fecha as fecha')
            ->leftJoin('cuentas as cuenta_origen', 'cuenta_origen.id', '=', 'movimientos.origen_id')
            ->leftJoin('users as user_origen', 'user_origen.id', '=', 'cuenta_origen.user_id')
            ->leftJoin('cuentas as cuenta_destino', 'cuenta_destino.id', '=', 'movimientos.destino_id')
            ->leftJoin('users as user_destino', 'user_destino.id', '=', 'cuenta_destino.user_id')
            ->leftJoin('movimientos_tipos as mt', 'mt.id', '=', 'movimientos.tipo_id')
            ->leftJoin('movimientos_familias as mf', 'mf.id', '=', 'movimientos.familia_id')
            ->when(auth()->check(), function ($q) {
                $q->where('user_origen.id', auth()->user()->id);
            })
            ->where(function ($q) use ($filtros) {

                if (!empty($filtros['fecha_desde'])) {
                    $q->whereDate('movimientos.fecha', '>=', $filtros['fecha_desde']);
                }

                if (!empty($filtros['fecha_hasta'])) {
                    $q->whereDate('movimientos.fecha', '<=', $filtros['fecha_hasta']);
                }
            })
            ->where('destino_id', auth()->user()->cuentaMain()->id)
            ->get();
    }

    public function getSalidas(array $filtros = [])
    {
        return Movimiento::query()
            ->selectRaw('movimientos.id as id')
            ->selectRaw('movimientos.origen_id as origen_id')
            ->selectRaw('user_origen.name as user_origen')
            ->selectRaw('movimientos.destino_id as destino_id')
            ->selectRaw('user_destino.name as user_destino')
            ->selectRaw('movimientos.familia_id as familia_id')
            ->selectRaw('mf.nombre as familia')
            ->selectRaw('movimientos.asignacion_id as asigancion_id')
            ->selectRaw('movimientos.tipo_id as tipo_id')
            ->selectRaw('mt.nombre as tipo')
            ->selectRaw('movimientos.concepto as concepto')
            ->selectRaw('movimientos.cantidad as cantidad')
            ->selectRaw('movimientos.fecha as fecha')
            ->leftJoin('cuentas as cuenta_origen', 'cuenta_origen.id', '=', 'movimientos.origen_id')
            ->leftJoin('users as user_origen', 'user_origen.id', '=', 'cuenta_origen.user_id')
            ->leftJoin('cuentas as cuenta_destino', 'cuenta_destino.id', '=', 'movimientos.destino_id')
            ->leftJoin('users as user_destino', 'user_destino.id', '=', 'cuenta_destino.user_id')
            ->leftJoin('movimientos_tipos as mt', 'mt.id', '=', 'movimientos.tipo_id')
            ->leftJoin('movimientos_familias as mf', 'mf.id', '=', 'movimientos.familia_id')
            ->when(auth()->check(), function ($q) {
                $q->where('user_origen.id', auth()->user()->id);
            })
            ->where(function ($q) use ($filtros) {

                if (!empty($filtros['fecha_desde'])) {
                    $q->whereDate('movimientos.fecha', '>=', $filtros['fecha_desde']);
                }

                if (!empty($filtros['fecha_hasta'])) {
                    $q->whereDate('movimientos.fecha', '<=', $filtros['fecha_hasta']);
                }
            })
            ->where('origen_id', auth()->user()->cuentaMain()->id)
            ->get();
    }

    public function getMovimientosModel(array $filtros = [])
    {
        return Movimiento::query()
            ->selectRaw('movimientos.id as id')
            ->selectRaw('movimientos.origen_id as origen_id')
            ->selectRaw('user_origen.name as user_origen')
            ->selectRaw('movimientos.destino_id as destino_id')
            ->selectRaw('user_destino.name as user_destino')
            ->selectRaw('movimientos.familia_id as familia_id')
            ->selectRaw('mf.nombre as familia')
            ->selectRaw('movimientos.asignacion_id as asigancion_id')
            ->selectRaw('.tipo_id as tipo_id')
            ->selectRaw('mt.nombre as tipo')
            ->selectRaw('movimientos.concepto as concepto')
            ->selectRaw('movimientos.cantidad as cantidad')
            ->selectRaw('movimientos.fecha as fecha')
            ->leftJoin('cuentas as cuenta_origen', 'cuenta_origen.id', '=', 'movimientos.origen_id')
            ->leftJoin('users as user_origen', 'user_origen.id', '=', 'cuenta_origen.user_id')
            ->leftJoin('cuentas as cuenta_destino', 'cuenta_destino.id', '=', 'movimientos.destino_id')
            ->leftJoin('users as user_destino', 'user_destino.id', '=', 'cuenta_destino.user_id')
            ->leftJoin('movimientos_tipos as mt', 'mt.id', '=', 'movimientos.tipo_id')
            ->leftJoin('movimientos_familias as mf', 'mf.id', '=', 'movimientos.familia_id')
            ->when(auth()->check(), function ($q) {
                $q->where('user_origen.id', auth()->user()->id);
            })
            ->where(function ($q) use ($filtros) {

                if (!empty($filtros['fecha_desde'])) {
                    $q->whereDate('movimientos.fecha', '>=', $filtros['fecha_desde']);
                }

                if (!empty($filtros['fecha_hasta'])) {
                    $q->whereDate('movimientos.fecha', '<=', $filtros['fecha_hasta']);
                }

                if (!empty($filtros['entradas']) && $filtros['entradas']) {
                    $q->where('destino_id', auth()->user()->cuentaMain()->id);
                }

                if (!empty($filtros['salidas']) && $filtros['salidas']) {
                    $q->where('origen_id', auth()->user()->cuentaMain()->id);
                }
            })
            ->get();
    }

    public function getMovimientosGrouped(array $filtros = [])
    {
        return Movimiento::query()
            ->selectRaw('SUM(movimientos.cantidad) as saldo')
            ->selectRaw('MONTH(movimientos.fecha) as month')
            ->selectRaw('YEAR(movimientos.fecha) as year')
            ->selectRaw('movimientos.destino_id as destino_id')
            ->selectRaw('movimientos.origen_id as origen_id')
            ->when(!empty($filtros['groupByDay']) && $filtros['groupByDay'], function ($q) {
                $q->selectRaw('DAY(movimientos.fecha) as day');
                $q->groupBy('day', 'month', 'year', 'origen_id', 'destino_id');
            })
            ->when(!empty($filtros['groupByMonth']) && $filtros['groupByMonth'], function ($q) {
                $q->groupBy('month', 'year', 'origen_id', 'destino_id');
            })
            ->where(function ($q) use ($filtros) {

                if (!empty($filtros['fecha_desde'])) {
                    $q->whereDate('movimientos.fecha', '>=', $filtros['fecha_desde']);
                }

                if (!empty($filtros['fecha_hasta'])) {
                    $q->whereDate('movimientos.fecha', '<=', $filtros['fecha_hasta']);
                }
            })
            ->where(function ($q) use ($filtros) {
                if (!empty($filtros['entradas']) && $filtros['entradas']) {
                    $q->where('movimientos.destino_id', auth()->user()->cuentaMain()->id);
                }

                if (!empty($filtros['salidas']) && $filtros['salidas']) {
                    $q->where('movimientos.origen_id', auth()->user()->cuentaMain()->id);
                }

                if (empty($filtros['salidas']) && empty($filtros['entradas'])) {
                    $q->where('movimientos.destino_id', auth()->user()->cuentaMain()->id);
                    $q->orWhere('movimientos.origen_id', auth()->user()->cuentaMain()->id);
                }
            })
            ->get();
    }

    public function getGastosByTipo($filtros = [])
    {
        return Movimiento::query()
            ->selectRaw('SUM(movimientos.cantidad) as gasto')
            ->selectRaw('mf.nombre as nombre')
            ->where(function ($q) use ($filtros) {
                if (!empty($filtros['fecha_desde'])) {
                    $q->whereDate('movimientos.fecha', '>=', $filtros['fecha_desde']);
                }

                if (!empty($filtros['fecha_hasta'])) {
                    $q->whereDate('movimientos.fecha', '<=', $filtros['fecha_hasta']);
                }

                $q->where('origen_id', auth()->user()->cuentaMain()->id);
            })
            ->leftJoin('movimientos_familias as mf', 'mf.id', '=', 'movimientos.familia_id')
            ->groupBy( 'mf.nombre')
            ->get();
    }
}
