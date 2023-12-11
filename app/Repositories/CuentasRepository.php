<?php

namespace App\Repositories;

use App\Models\Cuenta;

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
            })
            ->whereNotNull('cuenta_id')
            ->get();
    }

}
