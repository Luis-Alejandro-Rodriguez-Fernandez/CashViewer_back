<?php


namespace App\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovimientosSimplesResource extends JsonResource
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
            'destino_id' => $this->destino_id,
            'familia_id' => $this->familia_id,
            'asignacion_id' => $this->asignacion_id,
            'tipo_id' => $this->tipo_id,
            'concepto' => $this->concepto,
            'cantidad' => $this->cantidad,
            'fecha' => $this->fecha,
            'fecha_' => $this->fecha_milis,
        ];
    }
}
