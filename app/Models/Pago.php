<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    // Relación de un cliente a un pago
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
// Relación de un pago a una transacción

    
}
