<?php


namespace App\Helpers;


class generalClass
{

    public $days = [
        0 => 'Lunes',
        1 => 'Martes',
        2 => 'Miercoles',
        3 => 'Jueves',
        4 => 'Viernes',
        5 => 'Sabado',
        6 => 'Domingo',
    ];
    public const MONTH = [
        0 => 'Enero',
        1 => 'Febrero',
        2 => 'Marzo',
        3 => 'Abril',
        4 => 'Mayo',
        5 => 'Junio',
        6 => 'Julio',
        7 => 'Agosto',
        8 => 'Septiembre',
        9 => 'Octubre',
        10 => 'Noviembre',
        11 => 'Diciembre',
    ];

    public function responseToApp($status, $data, $message = "")
    {
        return response()->json([
            'status' => $status,
            'data' => $data,
            'message' =>$message
        ]);
    }

    public function parseFecha(
        ?string $fecha,
        string $formato = 'd/m/Y',
        string $formatoOrdenar = 'U'
    ): array
    {
        return [
            'original' => $fecha,
            'ordenar' => $fecha ? date($formatoOrdenar, strtotime($fecha)) : '',
            'ver' => $fecha ? date($formato, strtotime($fecha)) : '',
        ];
    }
}
