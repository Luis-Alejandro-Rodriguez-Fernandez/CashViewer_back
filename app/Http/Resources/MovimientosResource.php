<?php


namespace App\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovimientosResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'origen_id' => $this->origen_id,
            'user_origen' => $this->user_origen,
            'destino_id' => $this->destino_id,
            'user_destino' => $this->user_destino,
            'familia_id' => $this->familia_id,
            'familia' => $this->familia,
            'asignacion_id' => $this->asignacion_id,
            'tipo_id' => $this->tipo_id,
            'tipo' => $this->tipo,
            'concepto' => $this->concepto,
            'cantidad' => $this->cantidad,
            'fecha' => $this->generalMethods()->parseFecha($this->fecha, 'd/m/Y H:i:s'),
        ];
    }
}
