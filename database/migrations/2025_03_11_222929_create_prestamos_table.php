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
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->decimal('monto_prestado', 10, 2);
            $table->enum('metodo_prestamo', ['Institucional', 'Personalizado', 'Francés', 'Alemán']);
            $table->decimal('tasa_interes_anual', 5, 2)->nullable(); // Tasa anual para Francés y Alemán
            $table->enum('modalidad', ['Diario', 'Semanal', 'Quincenal', 'Mensual', 'Anual']);
            $table->integer('nro_cuotas');
            $table->decimal('monto_total', 12, 2);
            $table->decimal('monto_total1', 12, 2);
            $table->date('fecha_inicio');
            $table->enum('estado', ['Activo', 'Cancelado'])->default('Activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
