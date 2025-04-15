<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE transacciones MODIFY COLUMN tipo_transaccion1 ENUM(
            'ahorro inicial',
            'pago ahorro',
            'pago ahorro_parcial',
            'pago prestamo',
            'pago cuota_parcial',
            'multa',
            'precancelacion',
            'retiro interes',
            'retiro ahorro',
            'prestamo',
            'acumular',
            'reverso_prestamo',
            'reverso_pago'
        )");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE transacciones MODIFY COLUMN tipo_transaccion1 ENUM(
            'ahorro inicial',
            'pago ahorro',
            'pago prestamo',
            'multa',
            'precancelacion',
            'retiro interes',
            'retiro ahorro',
            'prestamo',
            'acumular'
        )");
    }
};
