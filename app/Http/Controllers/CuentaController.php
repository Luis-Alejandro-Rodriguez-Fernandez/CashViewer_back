<?php

namespace App\Http\Controllers;


use App\Http\Resources\CuentaResource;
use App\Http\Resources\ObjetivoResource;
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

        if (Auth::check() && !empty(auth()->user()->cuentaMain())) {
            $cuentas = $this->cuentasService->getCuentasObjetivos();
        }

        return $this->generalMethods()->responseToApp(
            1,
            ObjetivoResource::collection($cuentas),
            'Cuentas objetivo en data'
        );
    }

    public function setCuentaObjetivo(Request $request)
    {
        $goal = null;

        if (!Auth::check() || empty(auth()->user()->cuentaMain())) {
            return $this->generalMethods()->responseToApp(
                0,
                [],
                'No se pudo crear el objetivo'
            );
        }

        if (isset($request->id)) {
            $goal = $this->cuentasService->updateCuentaObjetivo($request->toArray());
        } else {
            $goal = $this->cuentasService->createCuentaObjetivo($request->toArray());
        }

        if ($goal && $goal->save()) {
            return $this->generalMethods()->responseToApp(
                1,
                new ObjetivoResource($goal),
                'Objetivo creado correctamente'
            );
        }

        return $this->generalMethods()->responseToApp(
            0,
            [],
            'No se pudo crear el objetivo'
        );
    }

    public function finalizarObjetivo(Request $request)
    {
        $goal = null;

        if (isset($request->id)) {
            $goal = $this->cuentasService->getCuentasObjetivos(['id' => $request->id])->first();
        }

        if ($goal) {
            $goal->finalizado = true;
        }

        if ($goal && $goal->save()) {

            return $this->generalMethods()->responseToApp(
                1,
                ObjetivoResource::collection($goal),
                'Objetivo creado correctamente'
            );
        }

        return $this->generalMethods()->responseToApp(
            0,
            [],
            'No se pudo finalizar el objetivo'
        );
    }

    public function deleteCuentaObjetivo()
    {
        $cuenta = null;

        if (Auth::check() && !empty(auth()->user()->cuentaMain())) {
            $cuenta = $this->cuentasService->getCuentasObjetivos(request()->toArray())?->first() ?? null;
        }

        if ($cuenta && $cuenta->saldo !== 0) {
            $cuenta->delete();

            return $this->generalMethods()->responseToApp(
                1,
                [],
                'El objetivo se eliminó correctamente'
            );
        }

        return $this->generalMethods()->responseToApp(
            0,
            [],
            'Hubo un error al eliminar el objetivo. Asegurese que la cuenta está sin saldo antes de realizar la operación.'
        );
    }
}
