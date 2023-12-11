<?php

namespace App\Http\Controllers;


use App\Http\Resources\CuentaResource;
use App\Models\Cuenta;
use App\Services\CuentasService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CuentaController extends Controller
{
    protected $cuentasService;

    public function __construct(CuentasService $cuentasService)
    {
        $this->cuentasService = $cuentasService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cuenta = null;

        if (Auth::check()) {
            $cuenta = Cuenta::query()
                ->where('user_id', '=', auth()->user()->id)
                ->whereNull('cuenta_id')
                ->where('activo', true)
                ->with(['ingresos', 'gastos'])
                ->get()
                ->first();
        }

        if ($cuenta) {
            return $this->generalMethods()->responseToApp(1, new CuentaResource($cuenta));
        }

        return $this->generalMethods()->responseToApp(0, [], "No se ha encontrado la información de la cuenta");
    }

    /**
     * Store a newly created resource in storage.
     */

    public function getCuentasObjetivo()
    {
        $cuentas = [];

        if (Auth::check() && !empty(auth()->user()->cuenta)) {
            $cuentas = $this->cuentasService->getCuentasObjetivos(['id' => auth()->user()->id]);
        }

        return $this->generalMethods()->responseToApp(1, $cuentas, 'Cuentas objetivo en data');
    }

    public function createCuentaObjetivo()
    {}

    public function updateCuentaObjetivo()
    {}

    public function deleteCuentaObjetivo()
    {}
}
