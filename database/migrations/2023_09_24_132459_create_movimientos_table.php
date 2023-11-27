<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('origen_id')->nullable();
            $table->unsignedBigInteger('destino_id');
            $table->unsignedBigInteger('familia_id')->nullable();
            $table->unsignedBigInteger('asignacion_id')->nullable();
            $table->unsignedBigInteger('tipo_id')->nullable();
            $table->string('concepto')->nullable();
            $table->double('cantidad');
            $table->timestamp('fecha');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('origen_id')->references('id')->on('cuentas');
            $table->foreign('destino_id')->references('id')->on('cuentas');
            $table->foreign('familia_id')->references('id')->on('movimientos_familias');
            $table->foreign('asignacion_id')->references('id')->on('movimientos_recurrencias');
            $table->foreign('tipo_id')->references('id')->on('movimientos_tipos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
