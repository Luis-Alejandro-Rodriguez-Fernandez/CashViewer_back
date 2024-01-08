<?php


namespace App\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ObjetivoResource extends JsonResource
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
            'name' => $this->nombre,
            'description' => $this->descripcion,
            'saldo' => $this->saldo,
            'objetivo' => $this->objetivo ?? 0,
            'finalizado' => $this->finalizado ?? 0,
            'progreso' => $this->progreso ?? 0,
        ];
    }
}
