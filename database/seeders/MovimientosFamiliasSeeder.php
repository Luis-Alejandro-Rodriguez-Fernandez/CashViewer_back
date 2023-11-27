<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovimientosFamiliasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('movimientos_familias')->insert([
            'nombre' => 'Ocio',
            'activo' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('movimientos_familias')->insert([
            'nombre' => 'Nutrición',
            'activo' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('movimientos_familias')->insert([
            'nombre' => 'Adquisición',
            'activo' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('movimientos_familias')->insert([
            'nombre' => 'Gasto fijo',
            'activo' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('movimientos_familias')->insert([
            'nombre' => 'Traspaso',
            'activo' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('movimientos_familias')->insert([
            'nombre' => 'Nomina',
            'activo' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
