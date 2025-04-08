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
        Schema::create('ahorros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->decimal('monto_ahorro', 10, 2);
            $table->date('fecha_vencimiento');
            $table->enum('metodo_pago', ['Efectivo', 'Transferencia', 'Tarjeta', 'Cheque']);
            $table->string('referencia_pago');
            $table->enum('estado', ['Pendiente', 'Pagado']);
            $table->date('fecha_pago')->nullable();
            $table->string('detalle_pago')->nullable();
            $table->string('pago_id')->nullable();
            $table->decimal('multa', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ahorros');
    }
};
