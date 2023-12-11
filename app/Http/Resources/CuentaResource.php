<?php


namespace App\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CuentaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $ingresos = $this->whenLoaded('ingresos', function () {
            return !empty($this->ingresos) ? MovimientosSimplesResource::collection($this->ingresos) : null;
        });
        $gastos = $this->whenLoaded('gastos', function () {
            return !empty($this->gastos) ? MovimientosSimplesResource::collection($this->gastos) : null;
        });

        $movimientos = $ingresos->concat($gastos)
            ->sortByDesc('fecha_milis')
            ->slice(0, 3)
            ->values();

        return [
            'id' => $this->id,
            'name' => $this->nombre,
            'description' => $this->descripcion,
            'saldo' => $this->saldo,
            'movimientos' => $movimientos,
        ];
    }
}
