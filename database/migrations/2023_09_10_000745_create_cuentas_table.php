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
        Schema::create('cuentas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('familia_id')->nullable();
            $table->unsignedBigInteger('cuenta_id')->nullable();
            $table->string('nombre');
            $table->string('descripcion');
            $table->double('saldo')->default(0);
            $table->boolean('activo')->default(1);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('cuenta_id')->references('id')->on('cuentas');
            $table->foreign('familia_id')->references('id')->on('cuentas_familias');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuentas');
    }
};
