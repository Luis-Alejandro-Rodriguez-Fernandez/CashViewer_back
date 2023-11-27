<?php

namespace App\Http\Controllers;


use App\Http\Resources\CuentaResource;
use App\Models\Cuenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CuentaController extends Controller
{
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

        return $this->generalMethods()->responseToApp(1, new CuentaResource($cuenta));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cuenta $cuenta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cuenta $cuenta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cuenta $cuenta)
    {
        //
    }
}
