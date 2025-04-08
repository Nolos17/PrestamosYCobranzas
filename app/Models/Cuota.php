<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuota extends Model
{
    use HasFactory;

    // Relación de un prestamo a una cuota
    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class);
    }
}
