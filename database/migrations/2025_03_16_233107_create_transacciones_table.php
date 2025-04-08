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
        Schema::create('transacciones', function (Blueprint $table) {
            $table->id();
            $table->integer('pago_id')->nullable();
            $table->integer('retiro_id')->nullable();
            $table->enum('tipo_transaccion', ['ingreso', 'egreso', 'movimiento interno',])->default('ingreso');
            $table->enum('tipo_transaccion1', ['ahorro inicial', 'pago ahorro', 'pago prestamo', 'multa', 'precancelacion', 'retiro interes', 'retiro ahorro', 'prestamo', 'acumular']);
            $table->string('detalle'); // Detalle de la transacción (ej. "pago prestamo", "entrega prestamo")
            $table->decimal('monto', 10, 2); // Monto de la transacción (positivo siempre)
            $table->decimal('saldo', 10, 2); // Saldo después de la transacción
            $table->date('fecha'); // Fecha de la transacción
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transacciones');
    }
};
