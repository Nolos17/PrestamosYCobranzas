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
        Schema::create('cuotas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prestamo_id');
            $table->foreign('prestamo_id')->references('id')->on('prestamos')->onDelete('cascade');
            $table->decimal('monto_cuota', 10, 2);
            $table->decimal('interes', 10, 2);
            $table->decimal('capital', 10, 2);
            $table->decimal('saldo_pendiente', 10, 2);
            $table->enum('metodo_pago', ['Efectivo', 'Transferencia', 'Tarjeta', 'Cheque']);
            $table->string('referencia_pago');
            $table->enum('estado', ['Pendiente', 'Pagado']);
            $table->date('fecha_vencimiento');
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
        Schema::dropIfExists('cuotas');
    }
};
