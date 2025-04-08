<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    // Relación uno a muchos
    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }

    public function ahorros()
    {
        return $this->hasMany(Ahorro::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    public function retiros()
    {
        return $this->hasMany(Retiro::class);
    }
}
