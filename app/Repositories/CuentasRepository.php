<?php

namespace App\Repositories;

use App\Models\Cuenta;
use Illuminate\Support\Facades\Auth;

class CuentasRepository
{

    public function getCuentasObjetivos(array $filtros = [])
    {
        return Cuenta::query()
            ->where(function ($q) use ($filtros) {
                if (!empty($filtros['id'])) {
                    $q->where('id', $filtros['id']);
                }
            })
            ->when(Auth::check(), function ($q) {
                $q->where('user_id', auth()->user()->id);
                $q->where('cuenta_id', auth()->user()->cuentaMain()->id);
            })
            ->whereNotNull('cuenta_id')
            ->where('activo', true)
            ->with(['ingresos', 'gastos'])
            ->get();
    }

    public function createCuentaObjetivo(array $data = [])
    {
        return Cuenta::query()->create([
            'user_id' => auth()->user()->id,
            'familia_id' => null,
            'cuenta_id' => auth()->user()->cuentaMain()->id,
            'nombre' => $data['name'],
            'descripcion' => $data['descripcion'],
            'saldo' => !empty($data['saldo']) ? $data['saldo'] : 0,
            'objetivo' => $data['objetivo'],
            'activo' => 1
        ]);
    }

    public function updateCuentaObjetivo($cuenta, array $data = [])
    {
        $cuenta->name = $data['name'];
        $cuenta->descripcion = $data['descripcion'];
        $cuenta->saldo = !empty($data['saldo']) ? $data['saldo'] : 0;
        $cuenta->objetivo = $data['objetivo'];

        return $cuenta->save() ? $cuenta : null;
    }
}
