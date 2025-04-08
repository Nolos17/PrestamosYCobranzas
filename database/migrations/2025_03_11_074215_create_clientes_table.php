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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nro_documento', 20)->unique();
            $table->string('nombres',  100);
            $table->string('apellidos', 100);
            $table->date('fecha_nacimiento');
            $table->string('genero');
            $table->string('email', 100);
            $table->string('celular', 20);
            $table->string('ref_celular');
            $table->integer('acciones');
            $table->date('fecha_afiliacion');
            $table->decimal('saldo_ahorro', 10, 2);
            $table->decimal('saldo_ahorro1', 10, 2);
            $table->enum('estado', ['Activo', 'Deshabilitado'])->default('Activo');
           

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
