<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;
    // Relación de un cliente a un prestamo
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    // Relación un prestamo tiene muchas cuotas
    public function cuotas()
    {
        return $this->hasMany(Cuota::class);
    }
}
